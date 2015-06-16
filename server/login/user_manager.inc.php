<?php

class UserManager
{

    /*
     * check is a name haven't special chars
     */
    public function isValidUserName($in_user_name)
    {
        if ($in_user_name == ''
            or preg_match('/[^[:alnum:] _-]/', $in_user_name) === TRUE)
            return FALSE;
        else
            return TRUE;
    }

    public function isValidDate($date)
    {
        return (preg_match('/^(\d{4}-\d{2}-\d{2})$/', $date)>0);
    }

    public function isUniqueNickname($nickname, $iduser_to_skip = 0, $in_db_conn = NULL)
    {
        $filter = ($iduser_to_skip > 0?" id_user <> '$iduser_to_skip' ":'');

        return $this->isUniqueValueUser('nickname', $nickname, NULL, $filter);
    }

    /*
     * check if is a valid e-mail
     */
    public function isValidEmail($email)
    {
        if ($email == ''
            or
            !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',
                $email))
            return FALSE;
        else
            return TRUE;
    }

    /*
    * add new user, data must be already checked
    */
    public function createAccount
    (
        $in_email,
        $in_pw
    )
    {
    
        // get db connection
        $conn = $this->getConnection();

        try
        {

            // make sure the parameters are safe for insertion
            // and encrypt the password for storage.
            $in_email = $this->super_escape_string($in_email, $conn);
            $in_pw = $this->super_escape_string($in_pw, $conn);

            // save pass in sha1
            $pw = sha1($in_pw);

            // create query to insert new user.
            $qstr = <<<EOQUERY
            INSERT INTO askme_users (pass, email, registration_date)
            VALUES ('$pw', '$in_email', NOW())
EOQUERY;

            // insert new user
            $results = @$conn->query($qstr);
            if ($results === FALSE)
            throw new DatabaseErrorException($conn->error);

            // we want to return the newly created user id.
            $user_id = $conn->insert_id;

            // create the settings
            $this->createDefaultSettings($conn, $user_id);

            // add the shared categories
            $this->addSharedCategories($conn, $user_id);

            // add the email address to the newsletter
            $this->addNewsletterEmail($in_email);
            
        }
        catch (Exception $e)
        {
            if (isset($conn)) $conn->close();
            throw $e;
        }

        // clean up and exit
        $conn->close();
        return $user_id;
    }

    private function addNewsletterEmail($email)
    {

        $news = new pommoUsers();
        $news->addEmailIfNotExists($email);
        $news = NULL;

    }

    private function addSharedCategories(&$conn, $id_user)
    {

        // query with default shared categories from user number 1
        $qstr = <<<EOQUERY
            INSERT INTO askme_shared_categories (id_category, id_user)
            SELECT c.id_category, $id_user as 'id_user' FROM askme_categories c
            WHERE c.id_user = '1' AND c.shared = '1' LIMIT 0,100
EOQUERY;

        // execute the query
        $results = @$conn->query($qstr);
        return ($results !== FALSE);

    }

    private function createDefaultSettings(&$conn, $id_user)
    {
        
        // query with default values
        $qstr = <<<EOQUERY
        INSERT INTO askme_settings (`id_user`, `id_setting`, `value`)
        SELECT $id_user, a.`id_setting`, a.`default_value`
        FROM askme_key_settings a LIMIT 10;
EOQUERY;

        // execute the query
        $results = @$conn->query($qstr);
        return ($results !== FALSE);

    }

    //
    // - validate input
    // - get connection
    // - execute query
    // - see if we found an existing record or not.
    // - clean up connection IF necessary.
    //
    public function eMailExists
    (
        $in_uemail,
        $in_db_conn = NULL
    )
    {

        return !$this->isUniqueValueUser('email', $in_uemail,$in_db_conn);
        
    }


    public function isUniqueValueUser
    (
        $field,
        $value,
        $in_db_conn = NULL,
        $in_filter = ''
    )
    {

        // initialize the result
        $unique = false;

        // check if isn't empty
        if ($value == '')
            throw new InvalidArgException();


        // looking for the connection
        if ($in_db_conn === NULL)
            $conn = $this->getConnection();
        else
            $conn = $in_db_conn;

        try
        {

            // check string
            $value = $this->super_escape_string($value, $conn);

            // add the and
            if (strlen($in_filter) > 0)
                $in_filter = " AND $in_filter";

            // prepare query
            $qstr = <<<EOQUERY
            SELECT count(*) as tt FROM askme_users
            WHERE $field = '$value' $in_filter
            LIMIT 1
EOQUERY;

            // execute the query
            $results = @$conn->query($qstr);
            if ($results === FALSE)
                throw new DatabaseErrorException($conn->error);

            // check if it exists
            $row = @$results->fetch_assoc();

            $unique = ($row['tt'] == 0);

        }
        catch (Exception $e)
        {
            // clean up and re-throw the exception.
            if ($in_db_conn === NULL and isset($conn))
                $conn->close();
            throw $e;
        }

        // only clean up what we allocated.
        $results->close();
        if ($in_db_conn === NULL) $conn->close();

        return $unique;

    }

    /*
    * check if username and password are correct and return the id
    */
    public function processLogin($in_user_name, $in_user_passwd)
    {

        // check if variables are fill in
        if ($in_user_name == '' || $in_user_passwd == '')
            return 0;

        // get the session id
        $sessionid = session_id();

        // get the connection
        $conn = $this->getConnection();

        try
        {

            // get the id user
            $userid = $this->confirmUserNamePasswd($in_user_name,
                                             $in_user_passwd,
                                             $conn);

            if ($userid > 0)
            {

                // clear his logged row
                $this->clearLoginEntriesForUser($userid, $conn);

                // insert the row the he is logged
                $query = <<<EOQUERY
                INSERT INTO askme_logged_user(id_user, sessionid, last_update)
                VALUES('$userid', '$sessionid', NOW())
EOQUERY;

                // run the query
                $result = @$conn->query($query);
                if ($result === FALSE)
                    throw new DatabaseErrorException($conn->error);

                // update last login date
                $query = <<<EOQUERY
                UPDATE askme_users SET last_loggin = NOW()
                WHERE id_user = '$userid' LIMIT 1
EOQUERY;

                // run the query
                $result = @$conn->query($query);
                if ($result === FALSE)
                    throw new DatabaseErrorException($conn->error);
                
            }

        }
        catch (Exception $e)
        {
            if (isset($conn))
            $conn->close();
            throw $e;
        }


        // close the connection
        $conn->close();

        // return the user id
        return $userid;
        
    }


  public function processLogout($in_conn = NULL)
  {
    $this->clearLoginEntriesForSessionID(session_id(), $in_conn);
  }

    /*
     * get the id from the session id
     */
    public function sessionLoggedIn($in_sid, $in_db_conn = NULL)
    {

        
        // if no value, return 0
   
        if ($in_sid == '')
            return 0;

        // prepare the return the id
        $user_id = 0;

        // get connection
        if ($in_db_conn == NULL)
            $conn = $this->getConnection();
        else
            $conn = $in_db_conn;

        try
        {

            // get clean id session
            $in_sid = $this->super_escape_string($in_sid, $conn);

            // create query
            $query = <<<EOQUERY
                SELECT u.id_user, u.email FROM askme_logged_user l
                inner join askme_users u on l.id_user = u.id_user
                WHERE l.sessionid = '$in_sid'
                LIMIT 1
EOQUERY;

            // execute query
            $result = @$conn->query($query);

            if ($result === FALSE)
            {
                throw new DatabaseErrorException($conn->error);
            }
            else
            {
                $row = @$result->fetch_assoc();
                
                if ($row !== NULL)
                {
                    $this->updateSessionActivity($in_sid, $conn);
                    $_SESSION['username'] = $row['email'];
                    $user_id = $row['id_user'];
                }
                $result->close();
            }

        }
        catch (Exception $e)
        {
            if (isset($conn))
            $conn->close();
            throw $e;
        }

        // close connection
        if ($in_db_conn === NULL)
            $conn->close();

        // return the id
        return $user_id;
        
    }


  //
  // - check args
  // - get database connection
  // - logout user if they're logged in
  // - delete account.
  //
  public function deleteAccount($in_userid)
  {
    //
    // 0. verify parameters
    //
    if (!is_int($in_userid))
      throw new InvalidArgException();

    //
    // 1. get a database connection with which to work.
    //
    $conn = $this->getConnection();
    try
    {
      //
      // 2. make sure user is logged out.
      //
      $this->clearLoginEntriesForSessionID(session_id());

      //
      // 3. create query to delete given user and execute!
      //
      $in_userid = (int)$in_userid;
      $in_userid = $this->super_escape_string($in_userid, $conn);
      $qstr = "DELETE FROM askme_users WHERE id_user = '$in_userid' LIMIT 1";
      $result = @$conn->query($qstr);
      if ($result === FALSE)
        throw new DatabaseErrorException($conn->error);
    }
    catch (Exception $e)
    {
      if (isset($conn))
        $conn->close();
      throw $e;
    }

    //
    // clean up and go home!
    //
    $conn->close();
  }


    /*
     * get a new connection
     */
    public function getConnection()
    {
        $conn = new mysqli(MYSQL_DB_SERVER, MYSQL_DB_USERNAME, MYSQL_DB_PW, MYSQL_DB_DB);
        if (mysqli_connect_errno() !== 0)
            throw new DatabaseErrorException(mysqli_connect_error());
        return $conn;
    }

    /*
     * check and replace strange chars
     */
    public function super_escape_string($in_string, $in_conn)
    {
        $str = $in_conn->real_escape_string($in_string);
        return preg_replace('([%;])', '\\\1', $in_string);
    }

    // check if username and password are correct
    private function confirmUserNamePasswd
    (
    $in_uname,
    $in_user_passwd,
    $in_db_conn = NULL
    )
    {

        // convert the name to low
        $in_uname = strtolower($in_uname);

        // return the id
        $userid = 0;

        // get connection
        if ($in_db_conn == NULL)
            $conn = $this->getConnection();
        else
            $conn = $in_db_conn;

        try
        {
    
            // clear from strange chars
            $in_uname = $this->super_escape_string($in_uname, $conn);
            $in_user_passwd = $this->super_escape_string($in_user_passwd, $conn);

            // get sha1 of password
            $sha1pass = sha1($in_user_passwd);

            // get the record with this user name
            $querystr = <<<EOQUERY
            SELECT id_user FROM askme_users
            WHERE email = '$in_uname' AND
            pass = '$sha1pass'
            LIMIT 1
EOQUERY;

            // run the query
            $results = @$conn->query($querystr);
            if ($results === FALSE)
                throw new DatabaseErrorException($conn->error);

            // check if i have the row
            $row = @$results->fetch_assoc();
            if ($row !== NULL)
            {
                // get the id
                $userid = $row['id_user'];
            }
            $results->close();
            
        }
        catch (Exception $e)
        {
            if ($in_db_conn === NULL and isset($conn))
            $conn->close();
            throw $e;
        }

        // close the connection
        if ($in_db_conn === NULL)
            $conn->close();

        // return the value
        return $userid;

    }


    private function clearLoginEntriesForUser
    (
    $in_userid,
    $in_db_conn = NULL
    )
    {

        // check if the id is numeric
        if ($in_userid == 0)
            return 0;

        // get connection
        if ($in_db_conn == NULL)
            $conn = $this->getConnection();
        else
            $conn = $in_db_conn;

        try
        {

            $in_userid = (int)$in_userid;
            $in_userid = $this->super_escape_string($in_userid, $conn);

            // prepare the delete query
            $querystr = <<<EOQUERY
            DELETE FROM askme_logged_user WHERE id_user = '$in_userid'
EOQUERY;

            $results = @$conn->query($querystr);

            if ($results === FALSE)
                throw new DatabaseErrorException($conn->error);
        }
        catch (Exception $e)
        {
            // if error, close connection
            if ($in_db_conn === NULL and isset($conn))
            $conn->close();
            throw $e;
        }

        // close the connection
        if ($in_db_conn === NULL)
        $conn->close();
        
    }


    private function clearLoginEntriesForSessionId
    (
    $in_sid,
    $in_db_conn = NULL
    )
    {

        // get connection
        if ($in_db_conn == NULL)
          $conn = $this->getConnection();
        else
          $conn = $in_db_conn;


        try
        {
            // clean up
            $in_sid = $this->super_escape_string($in_sid, $conn);
            $query = <<<EOQ
			DELETE FROM askme_logged_user 
			WHERE sessionid ='$in_sid' LIMIT 1
EOQ;

            $results = @$conn->query($query);
            if ($results === FALSE or $results === NULL)
                throw new DatabaseErrorException($conn->error);
        }
        catch (Exception $e)
        {
            if ($in_db_conn === NULL and isset($conn))
            $conn->close();
            throw $e;
        }

        // close connection
        if ($in_db_conn === NULL)
              $conn->close();
        
  }

  private function updateSessionActivity
  (
    $in_sessid,
    $in_db_conn
  )
  {
    //
    // make sure we have a database connection.
    //
    if ($in_db_conn == NULL)
      $conn = $this->getConnection();
    else
      $conn = $in_db_conn;

    try
    {
      //
      // update the row for this session.
      //
      $in_sessid = $this->super_escape_string($in_sessid, $conn);
      $querystr = <<<EOQUERY
		UPDATE askme_logged_user SET last_update = NOW()
		WHERE sessionid = '$in_sessid' LIMIT 1
EOQUERY;

      $results = @$conn->query($querystr);
      if ($results === FALSE)
        throw new DatabaseErrorException($conn->error);
    }
    catch (Exception $e)
    {
      if ($in_db_conn === NULL and isset($conn))
        $conn->close();
      throw $e;
    }

    //
    // clean up and return.
    //
    if ($in_db_conn === NULL)
      $conn->close();
  }
}

?>

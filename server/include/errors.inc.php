<?php

class InvalidArgException extends Exception
{
  public function __construct()
  {
    parent::__construct('The function was called with an invalid parameter');
  }
}

class UserAlreadyExistsException extends Exception
{
  public function __construct()
  {
    parent::__construct('A user with the given name already exists.');
  }
}

class NoSuchUserException extends Exception
{
  public function __construct()
  {
    parent::__construct('No Such User exists');
  }
}

class InvalidLoginException extends Exception
{
  public function __construct()
  {
    parent::__construct('The username and password supplied are incorrect.');
  }
}

class DatabaseErrorException extends Exception
{
  public function __construct($in_msg)
  {
    parent::__construct('A database error occurred: ' . $in_msg);
  }
}

class InvalidInputException extends Exception
{
  public function __construct()
  {
    parent::__construct('The form input was incorrect');
  }
}

class InvalidSessionIdException extends Exception
{
  public function __construct()
  {
    parent::__construct('Invalid session ID');
  }
}

?>

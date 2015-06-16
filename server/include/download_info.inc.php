<?php

class download_info {

    function getCount($conn, $os)
    {
        // get the count
        $querystr = <<<EOQUERY
            select numeric_value as x from askme_values
            where id_value = 'download_$os' limit 1
EOQUERY;

        $count = 0;

        $results = @$conn->query($querystr);
        if ($results)
        {
            if (($row = $results->fetch_assoc()) !== NULL)
                $count = $row['x'];

            $results->close();
        }

        return $count;

    }

}

?>

<?php	

require "live.php";

     
/**
 * Function to set Database connection
 */
function dbConnect($host, $user, $pass, $dbName, $dbPort)
{
    $link = mysqli_connect($host, $user, $pass, $dbName, $dbPort);

    if (!$link) {
        die("Unable to connect to database server $host.");
    }
    
    mysqli_query($link,"SET CHARACTER SET 'utf8'");
    mysqli_query($link,"SET SESSION collation_connection ='utf8_unicode_ci'");

    return $link;
}

/**
 * Function to call database queries
 */
function dbQuery($query, $type = '')
{
    $link = dbConnect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    $query = trim($query);
    $first_letter = strtoupper(substr($query, 0, 1));

    $query_result = mysqli_query($link, $query);
    if (!$query_result)
        trigger_error("Error executing query $query. -- " . mysqli_error($link));

    for($i=0; $i<mysqli_num_rows($query_result); $i++)
            $rows[] = mysqli_fetch_array($query_result);
    
    return $rows;
}

?>
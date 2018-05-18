<?php

define('DB_HOST', 'dbcallertech.clthqqzsvi0y.us-west-2.rds.amazonaws.com');
define('DB_USERNAME', 'ct_user');
define('DB_PASS', '+ybd=p9N_d1C');
define('DB_NAME', 'callertech');
/*********function to check new order******************/
function get_new_order()
{
    $con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASS);
    mysqli_select_db(DB_NAME, $con);
    $sql   = "SELECT * FROM `ct_printed_numbers` WHERE `to_print` != '' AND `is_printed` = '0' AND `client_id` = '20' LIMIT 1";
    //0 for new order
    $query = mysqli_query($sql, $con);
    if (mysqli_num_rows($query) > 0) {
        return true;
    } else
        return false;
}
/*************************************/
/********Socket Server*********************/
set_time_limit(0);
// Set the ip and port we will listen on
$address = '127.0.0.1';
$port    = 8009;
// Create a TCP Stream socket
$sock    = socket_create(AF_INET, SOCK_STREAM, 0); // 0 for  SQL_TCP
// Bind the socket to an address/port
socket_bind($sock, 0, $port) or die('Could not bind to address'); //0 for localhost
// Start listening for connections
socket_listen($sock);
//loop and listen
while (true) {
    /* Accept incoming  requests and handle them as child processes */
    $client  = socket_accept($sock);
    // Read the input  from the client – 1024000 bytes
    $input   = socket_read($client, 1024000);
    // Strip all white  spaces from input
    $output  = ereg_replace("[ \t\n\r]", "", $input) . "\0";
    $message = explode('=', $output);
    if (count($message) == 2) {
        if (get_new_order())
            $response = 'NEW:1';
        else
            $response = 'NEW:0';
    } else
        $response = 'NEW:0';
    // Display output  back to client
    socket_write($client, $response);
    socket_close($client);
}
// Close the master sockets
socket_close($sock);

?>
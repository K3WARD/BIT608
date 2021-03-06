<?php
include "header.php";
include "checksession.php";
include "menu.php";
echo '<div id="site_content">';
include "sidebar.php";

echo '<div id="content">';
include "content.php";

include "config.php"; //load in any variables*/
$DBC = mysqli_connect('localhost', DBUSER, DBPASSWORD, DBDATABASE, DBPORT);

//insert DB code from here onwards
//check if the connection was good
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit; //stop processing the page further
}

$id = $_GET['id'];
if (empty($id) or !is_numeric($id)) {
 echo "<h2>Invalid Booking ID</h2>"; //simple error feedback
 exit;
} 

//prepare a query and send it to the server
//NOTE for simplicity purposes ONLY we are not using prepared queries
//make sure you ALWAYS use prepared queries when creating custom SQL like below
$query = 'SELECT * FROM bookings WHERE bookingid='.$id;
$result = mysqli_query($DBC,$query);
$rowcount = mysqli_num_rows($result); 
?>

<h1>Room Details View</h1>

<h2><a href='listbookings.php'>[Return to Room List]</a><a href="index.php">[Return to main page]</a></h2>

<?php

//makes sure we have the Room
if ($rowcount > 0) {  
   echo "<fieldset><legend>Booking detail #$id</legend><dl>"; 
   $row = mysqli_fetch_assoc($result);
   echo "<dt>Room name:</dt><dd>".$row['roomname']."</dd>".PHP_EOL;
   echo "<dt>Checkin Date:</dt><dd>".$row['checkInDate']."</dd>".PHP_EOL;
   echo "<dt>Checkout Date:</dt><dd>".$row['checkOutDate']."</dd>".PHP_EOL;
   echo "<dt>Contact Number:</dt><dd>".$row['phoneNumber']."</dd>".PHP_EOL;
   echo "<dt>Breakfast:</dt><dd>".$row['breakfastChoice']."</dd>".PHP_EOL;
   echo "<dt>Extras:</dt><dd>".$row['bookingExtras']."</dd>".PHP_EOL;
   echo "<dt>Room Review:</dt><dd>".$row['roomReview']."</dd>".PHP_EOL;   
   echo '</dl></fieldset>'.PHP_EOL;  
} else echo "<h2>No Room found!</h2>"; //suitable feedback

mysqli_free_result($result); //free any memory used by the query
mysqli_close($DBC); //close the connection once done

echo '</div></div>';
include "footer.php";


?>


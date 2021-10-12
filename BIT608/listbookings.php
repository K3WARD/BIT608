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

//prepare a query and send it to the server
$query = 'SELECT bookingID,room_Name,checkInDate,checkOutDate,customer_ID,breakfastChoice FROM bookings ORDER BY bookingID';
$result = mysqli_query($DBC,$query);
$rowcount = mysqli_num_rows($result); 
?>
<h1>Current Bookings</h1>

<h2><a href='BookingPage.html'>[Make a booking]</a> &nbsp;&nbsp; <a href="index.php">[Return to main page]</a></h2>

<table>
<thead> <tr><th>Booking#</th><th>Room</th><th>From (Date)</th><th>To (Date)</th><th>Customer</th><th>Breakfast</th><th>Action</th></tr></thead>

<?php

//makes sure we have rooms
if ($rowcount > 0) {  
    while ($row = mysqli_fetch_assoc($result)) {
	  $id = $row['bookingID'];	
	  echo '<tr><td>'.$row['bookingID'].'</td><td>'.$row['room_Name'].'</td><td>'.$row['checkInDate'].'</td><td>'.$row['checkOutDate'].'</td><td>'.$row['customer_ID'].'</td><td>'.$row['breakfastChoice'].'</td>';
	  echo     '<td><a href="viewbooking.php?id='.$id.'">[View]</a>';
      /*if(isAdmin()){*/
	  echo         '<a href="editbooking.php?id='.$id.'">[Edit]</a>';
      echo         '<a href="addreview.php?id='.$id.'">[Manage Reviews]</a>';  
	  echo         '<a href="deletebooking.php?id='.$id.'">[Delete]</a></td>';
      /* }*/
      echo '</tr>'.PHP_EOL;
   }
} else echo "<h2>No rooms found!</h2>"; //suitable feedback

mysqli_free_result($result); //free any memory used by the query
mysqli_close($DBC); //close the connection once done
?>

</table>
<?php
echo '</div></div>';
include "footer.php";
?>
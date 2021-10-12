<?php
include "checksession.php";
checkUser();
loginStatus();

echo "<pre>"; var_dump($_POST); echo "</pre>";
echo "<pre>"; var_dump($_SESSION); echo "</pre>";

include "header.php";
include "menu.php";

echo '<div id="site_content">';
include "sidebar.php";

echo '<div id="content">';
include "content.php";



function cleanInput($data) {  
    return htmlspecialchars(stripslashes(trim($data)));
  }
  
  //the data was sent using a formtherefore we use the $_POST instead of $_GET
  //check if we are saving data first by checking if the submit button exists in the array
  if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Add')) {
  //if ($_SERVER["REQUEST_METHOD"] == "POST") { //alternative simpler POST test    
      include "config.php"; //load in any variables
      $DBC = mysqli_connect('localhost', DBUSER, DBPASSWORD, DBDATABASE, DBPORT);
  
      if (mysqli_connect_errno()) {
          echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
          exit; //stop processing the page further
      };
  
  //validate incoming data - only the first field is done for you in this example - rest is up to you do
  //roomname
      $error = 0; //clear our error flag
      $msg = 'Error: ';
      if (isset($_POST['room_Name']) and !empty($_POST['room_Name']) and is_string($_POST['room_Name'])) {
         $fn = cleanInput($_POST['room_Name']); 
         $room_Name = (strlen($fn)>50)?substr($fn,1,50):$fn; //check length and clip if too big
         //we would also do context checking here for contents, etc       
      } else {
         $error++; //bump the error flag
         $msg .= 'Invalid roomname '; //append eror message
         $room_Name = '';  
      } 
   
  //Check in date
          $checkInDate = cleanInput($_POST['checkInDate']);        
  //Check Out Date
         $checkOutDate = cleanInput($_POST['checkOutDate']);         
  //Booking Extras
         $bookingExtras = cleanInput($_POST['bookingExtras']); 
  // Phone Number
         $phoneNumber = cleanInput($_POST['phoneNumber']); 
  //Breakfast Choice
         $breakfastChoice = cleanInput($_POST['breakfastChoice']); 
  // Room ID
         $room_ID = cleanInput($_POST['room_ID']); 
  //customer ID
         $customer_ID = cleanInput($_POST['customer_ID']);    
         
  //save the room data if the error flag is still clear
      if ($error == 0) {
          $query = "INSERT INTO bookings (room_Name,checkInDate,checkOutDate,bookingExtras,phoneNumber,breakfastChoice,room_ID,customer_ID) VALUES (?,?,?,?,?,?,?,?)";
          $stmt = mysqli_prepare($DBC,$query); //prepare the query
          mysqli_stmt_bind_param($stmt,'sssssssd', $room_Name, $checkInDate, $checkOutDate,$bookingExtras,$phoneNumber,$breakfastChoice,$room_ID,$customer_ID ); 
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);    
          echo "<h2>New booking added</h2>";        
      } else { 
        echo "<h2>$msg</h2>".PHP_EOL;
      }      
      mysqli_close($DBC); //close the connection once done
  }
  
  ?>



<ul>
            <li><a href="CurrentBookings.php">Return to Booking List </a>  &nbsp;&nbsp; <a href="index.php">Return to main Page</a>&nbsp;&nbsp; <a href="roomavailability.php">Check Room Availablity</a></li>
        </ul> 
  <h2>Booking Form</h2>
        <form method="POST" action="BookingPage.php" >
        <div class="form_settings">



          <input  name="customer_ID" id="customer_ID" value = <?php echo $_SESSION['loggedin'];?>>
          <input  name="room_Name" class = "room_Name" id="room_Name" >

          


 <p>



 <?php

include "config.php"; //load in any variables*/
$DBC = mysqli_connect('localhost', DBUSER, DBPASSWORD, DBDATABASE, DBPORT);

//insert DB code from here onwards
//check if the connection was good
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit; //stop processing the page further
}

$queryroom = 'SELECT roomID,roomname,roomtype,beds FROM room ORDER BY roomtype';
$resultroom = mysqli_query($DBC,$queryroom);
$rowcountroom = mysqli_num_rows($resultroom); 

?>
 <span>Room (name,type,beds)</span> 

 <select type ="text" id="room_ID" class="room_ID" name="room_ID" onChange="myFunction(this.options[this.selectedIndex].innerHTML)" required >
 <option disabled selected value> -- select a room -- </option>
 <?php


 if ($rowcountroom > 0) {
  while ($row = mysqli_fetch_assoc($resultroom)) {
       echo"<option value=".$row['roomID'].">".$row['roomname'].", ".$row['roomtype'].", ".$row['beds']."</optiom>";
  
 }
 } else echo "<h2>No rooms found!</h2>";

mysqli_free_result($resultroom); //free any memory used by the query
mysqli_close($DBC); //close the connection once done

?>

<script>

$( function() {
   $( "#checkInDate" ).datepicker({
     numberOfMonths: 2,
     showButtonPanel: true,
     dateFormat: 'yy-mm-dd',
     minDate: 'today',
     
  });
 } );

 $( function() {
   $( "#checkOutDate" ).datepicker({
     numberOfMonths: 2,
     showButtonPanel: true,
     dateFormat: 'yy-mm-dd',
     minDate: 'startdate + 1',
   });
 } );


function myFunction(chosen) {
  document.getElementById("room_Name").value = chosen;
  //console.log(chosen);
}
 
 </script>
</select>

</p>
  
<p><span>Checkin Date (dd-mm-yyyy)</span><input type="text" id="checkInDate" name = "checkInDate"></p> 
<p><span> Checkout Date (dd-mm-yyyy) </span><input type="text" id="checkOutDate" name = "checkOutDate"></p>

<p><span>Contact number ((###)-###-####)</span><input type="tel"  class ="telephone" id="telephone" placeholder="(123)-456-7890" required /></p>

<p>
  <span>Breakfast Choice</span>
  <select type="text" id="breakfastChoice" name="breakfastChoice" required >
  <option disabled selected value> -- select a breakfast -- </option>
  <option value="Cooked">Cooked</option>
  <option value="Continental">Continental</option>
</select>
</p>
<p><span>Booking Extras</span><textarea type="text" id="bookingExtras" name="bookingExtras" maxlength="300" rows="8" cols="50" name="name"></textarea></p>
<p>
<span>Add to confirm booking:</span>
<input id="add" class="submit" type="submit" name="submit" value="Add">
<input id="cancel" class="cancel" type="button" name="name" href="CurrentBookings.php" value="Cancel" onClick="window.location.href='CurrentBookings.php';">
</p>

<?php
echo '</div></div>';
include "footer.php";

?>
+
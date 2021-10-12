<?php
include "header.php";
include "checksession.php";
include "menu.php";
echo '<div id="site_content">';
include "sidebar.php";

echo '<div id="content">';


include "config.php"; //load in any variables
$DBC = mysqli_connect('localhost', DBUSER, DBPASSWORD, DBDATABASE, DBPORT);

if (mysqli_connect_errno()) {
  echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
  exit; //stop processing the page further
};

//function to clean input but not validate type and content
function cleanInput($data) {  
  return htmlspecialchars(stripslashes(trim($data)));
}
//retrieve the bookingid from the URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    if (empty($id) or !is_numeric($id)) {
        echo "<h2>Invalid Booking ID</h2>"; //simple error feedback
        exit;
    } 

}
//the data was sent using a formtherefore we use the $_POST instead of $_GET
//check if we are saving data first by checking if the submit button exists in the array
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Update')) {     
//validate incoming data - only the first field is done for you in this example - rest is up to you do
 
//roomID (sent via a form ti is a string not a number so we try a type conversion!)    
    if (isset($_POST['id']) and !empty($_POST['id']) and is_integer(intval($_POST['id']))) {
       $id = cleanInput($_POST['id']); 
    } else {
       $error++; //bump the error flag
       $msg .= 'Invalid booking ID '; //append error message
       $id = 0;  
    }   
//roomname
       $room_Name = cleanInput($_POST['room_Name']); 
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
       
 
    
//save the room data if the error flag is still clear and room id is > 0
    if ($error == 0 and $id > 0) {
        $query = "UPDATE bookings SET room_Name=?,checkInDate=?,checkOutDate=?,bookingExtras=?,phoneNumber=?,breakfastChoice=?,room_ID=?,customer_ID=? WHERE bookingID=?";
        $stmt = mysqli_prepare($DBC,$query); //prepare the query
        mysqli_stmt_bind_param($stmt,'ssssssssi', $room_Name, $checkInDate, $checkOutDate, $bookingExtras, $phoneNumber, $breakfastChoice,  $room_ID, $customer_ID, $id); 
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);    
        echo "<h2>Booking details updated.</h2>";     
//        header('Location: http://localhost/bit608/listrooms.php', true, 303);      
    } else { 
      echo "<h2>$msg</h2>".PHP_EOL;
    }      
}
//locate the room to edit by using the roomID
//we also include the room ID in our form for sending it back for saving the data
$query = 'SELECT bookingID,room_Name,checkInDate,checkOutDate,bookingExtras,phoneNumber, breakfastChoice, room_ID, customer_ID FROM bookings WHERE bookingID='.$id;
$result = mysqli_query($DBC,$query);
$rowcount = mysqli_num_rows($result);
if ($rowcount > 0) {
  $row = mysqli_fetch_assoc($result);
 /*         */
?>

        <h2><a href='listbookings.php'>[Return to the room listing]</a><a href='index.php'>[Return to the main page]</a></h2> 


        <h2>Edit Booking</h2>
        <form  method="POST" action="EditaBooking.php">
          <div class="form_settings">

          <input  name="id" value="<?php echo $id;?>">
          <input  type="hidden" name="room_ID" id="room_ID" value="<?php echo $row['room_ID'];?>">
          <input  type="hidden" name="customer_ID" id="customer_ID" value="<?php echo $row['customer_ID'];?>">
          <br>

<p>
<span>Room (name,type,beds)</span>
<select id="room_Name" name="room_Name">
<option value="<?php echo $row['room_Name']; ?>"><?php echo $row['room_Name']; ?></option>
<option value="Kellie">Kellie, S, 5</option>
<option value="Octavia">Octavia, D, 3</option>
<option value="Herman">Herman, D, 5</option>
<option value="Scarlet">Scarlet, D, 2</option>
<option value="Preston">Preston, D, 2</option>
<option value="Dacey">Dacey, D, 2</option>
<option value="Cretchen">Gretchen, D, 3</option>
<option value="Dane">Dane, S, 4</option>
<option value="Bernard">Bernard, S, 5</option>
<option value="Helen">Helen, S, 2</option>
<option value="Miranda">Miranda, S, 4</option>
<option value="Sonya">Sonya, S, 5</option>
<option value="Jelani">Jelani, S, 2</option>
<option value="Cole">Cole, S, 1</option>         
</select>
</p>

<p><span>Checkin Date (dd-mm-yyyy)</span><input type="text" id="checkInDate" name = "checkInDate" value = <?php echo $row['checkInDate'];?>></p> 
<p><span> Checkout Date (dd-mm-yyyy) </span><input type="text" id="checkOutDate" name = "checkOutDate"value= <?php echo $row['checkOutDate'];?> ></p>   
<p><span>Contact number ((###)-###-####)</span><input type="tel" pattern="^\d({3})-\d{3}-\d{4}$" id="phoneNumber" name="phoneNumber" class ="telephone" value= <?php echo $row['phoneNumber'];?> required ></p>

<p><span>Breakfast Choice</span>
  <select id="breakfastChoice" name="breakfastChoice">
  <option value="<?php echo $row['breakfastChoice']; ?>"><?php echo $row['breakfastChoice'];?> </option>
  <option value="Cooked">Cooked</option>
  <option value="Continental">Continental</option>
 
</select></p>
            
<p><span>Booking Extras</span><textarea id="bookingExtras" name="bookingExtras" rows="8" cols="50" name="name" maxlength="300"> <?php echo $row['bookingExtras']; ?> </textarea></p>

<p>
  <span>Update to confirm changes </span>
  <input id="add" class="submit" type="submit" name="submit" value="Update">
  <input id="cancel" class="cancel" type="button" name="name" href="CurrentBookings.php" value="Cancel" onClick="window.location.href='listbookings.php';">
  </p>
</div>       
</form>

<script>




var newRoomName = document.getElementById('roomname');
a.addEventListener('change', function() {
  alert(this.value);
}, false);

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



</script>    

<?php 
} else { 
  echo "<h2>Booking not found with that ID</h2>"; //simple error feedback
  echo $id;
}
mysqli_close($DBC); //close the connection once done


echo '</div></div>';
include "footer.php";
?>


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

//the data was sent using a form therefore we use the $_POST instead of $_GET
//check if we are saving data first by checking if the submit button exists in the array
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Update')) { 
    $error = 0; //clear our error flag
    $msg = 'Error: ';  
      
    //validate incoming data - only the first field is done for you in this example - rest is up to you do
    
    //roomID (sent via a form ti is a string not a number so we try a type conversion!)    
    if (isset($_POST['id']) and !empty($_POST['id']) and is_integer(intval($_POST['id']))) {
      $id = cleanInput($_POST['id']); 
    } else {
      $error ++; //bump the error flag
      $msg = 'Invalid booking ID '; //append error message
      $id = 0; 
      
    }  
         
    //room Review 
    if (isset($_POST['roomReview']) and !empty($_POST['roomReview']) and is_string($_POST['roomReview'])) {
      $roomReview = cleanInput($_POST['roomReview']);
    } else {
      $error ++; //bump the error flag
      $msg = 'Invalid booking Room Review '; //append error message
      $id = 0; 
      
    } 
        
    //save the room data if the error flag is still clear and room id is > 0
        if ($error == 0 and $id > 0) {
            $query = "UPDATE bookings SET roomReview=? WHERE bookingID=?";
            $stmt = mysqli_prepare($DBC,$query); //prepare the query
            mysqli_stmt_bind_param($stmt,'si', $roomReview, $id); 
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);    
            echo "<h2>Review details updated.</h2>";     
    //        header('Location: http://localhost/bit608/listrooms.php', true, 303);      
        } else { 
          echo "<h2>$msg</h2>".PHP_EOL;
        }      
    }
    //locate the room to edit by using the roomID
    //we also include the room ID in our form for sending it back for saving the data
    $query = 'SELECT bookingID,room_Name,checkInDate,checkOutDate,bookingExtras,phoneNumber,breakfastChoice,roomReview FROM bookings WHERE bookingID='.$id;
    $result = mysqli_query($DBC,$query);
    $rowcount = mysqli_num_rows($result);
    if ($rowcount > 0) {
      $row = mysqli_fetch_assoc($result);
     /*         */
    ?>

<h2><a href='listbookings.php'>[Return to the room listing]</a><a href='index.php'>[Return to the main page]</a></h2> 

<fieldset>
  <legend>Booking Detail &num; <?php echo $id;?></legend>
  
     <dl>
       <dt>Room name:</dt><dd><?php echo $row['roomname']; ?></dd>
       <dt>Checkin Date:</dt><dd><?php echo $row['checkInDate'];?></dd>
       <dt>Checkout Date:</dt><dd><?php echo $row['checkOutDate'];?></dd>
       <dt>Contact Number:</dt><dd><?php echo $row['phoneNumber'];?></dd>
       <dt>Breakfast:</dt><dd><?php echo $row['breakfastChoice']; ?></dd>
       <dt>Extras:</dt><dd><?php echo $row['bookingExtras']; ?></dd>
       <dt>Room Review:</dt><dd><?php echo $row['roomReview'];?></dd> 
     </dl>
  </fieldset>


<form  method="POST" action="AddReview.php">
 <div class="form_settings">
   <input type="hidden" name="id" value="<?php echo $id;?>">       
   <p><span>Edit/Add Review</span><textarea id="roomReview" name="roomReview"rows='8' cols='150' name='name' maxlength='300'><?php echo $row['roomReview']; ?></textarea>
           
   <p>
  <span>Update to confirm changes </span>
  <input id="add" class="submit" type="submit" name="submit" value="Update">
  <input id="cancel" class="cancel" type="button" name="name" href="CurrentBookings.php" value="Cancel" onClick="window.location.href='CurrentBookings.php';">
  </p>

  <?php 
} else { 
  echo "<h2>Booking not found with that ID</h2>"; //simple error feedback
  echo $id;
}
mysqli_close($DBC); //close the connection once done

echo '</div></div>';
include "footer.php";

?>
  
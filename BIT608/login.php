<?php
include "checksession.php";
loginStatus();
echo "<pre>"; var_dump($_POST); echo "</pre>";
echo "<pre>"; var_dump($_SESSION); echo "</pre>";

if (isset($_POST['logout'])) logout();
 
if (isset($_POST['login']) and !empty($_POST['login']) and ($_POST['login'] == 'Login')) {
    include "config.php"; //load in any variables
    $DBC = mysqli_connect('localhost', DBUSER, DBPASSWORD, DBDATABASE, DBPORT) or die();
 
//validate incoming data - only the first field is done for you in this example - rest is up to you to do
//firstname
    $error = 0; //clear our error flag
    $msg = 'Error: ';
    if (isset($_POST['username']) and !empty($_POST['username']) and is_string($_POST['username'])) {
       $un = htmlspecialchars(stripslashes(trim($_POST['username'])));  
       $username = (strlen($un)>32)?substr($un,1,32):$un; //check length and clip if too big       
    } else {
       $error++; //bump the error flag
       $msg .= 'Invalid username '; //append error message
       $username = '';  
    } 
                 
//password  - normally we avoid altering a password apart from whitespace on the ends   

  
    $password = trim($_POST['password']);   
  

       
//This should be done with prepared statements!!
    if ($error == 0) {
        $query = "SELECT customerID, firstname, password FROM customer WHERE firstname = '$username'";
        $result = mysqli_query($DBC,$query);     
        if (mysqli_num_rows($result) == 1) { //found the user
            $row = mysqli_fetch_assoc($result);
            mysqli_free_result($result);
            mysqli_close($DBC); //close the connection once done
  //this line would be added to the registermember.php to make a password hash before storing it
  //$hash = password_hash($password); 
  //this line would be used if our user password was stored as a hashed password
           //if (password_verify($password, $row['password'])) {           
            if ($password === $row['password']) //using plaintext for demonstration only!            
              login($row['customerID'],$username);
        } echo "<h2>Login fail</h2>".PHP_EOL;   
    } else { 
      echo "<h2>$msg</h2>".PHP_EOL;
    }      
}


include "header.php";
include "menu.php";

 //show the current login status
echo '<div id="site_content">';
include "sidebar.php";

echo '<div id="content">';
include "content.php";


//this line is for debugging purposes so that we can see the actual POST data
//echo "<pre>"; var_dump($_POST); echo "</pre>";
 
//simple logout


?>

<h2><a href='BookingPage.html'>[Make a booking]</a> &nbsp;&nbsp; <a href="index.php">[Return to main page]</a></h2>

<h2>Login</h2>
<div class="form_settings">
<form method="POST" action="login.php">

  
 <p>  
    <span><label for="username">Username: </label></span>
    <input type="text" id="username" name="username" maxlength="32" size="50"> 
   </p>
  <p>
   <span><label for="password">Password: </label></span>
    <input type="password" id="password" name="password" minlength="8" maxlength="32"> 
  </p> 
  <p>
  <span>Please enter details to log in:</span>
   <input type="submit" class="submit" name="login" value="Login">
   <input type="submit" class="submit" name="logout" value="Logout">
</p>
 </form>

 <br>
</div>
 <div id="imgJail">
  <img src="img/Ongaonga_OldJail.jpg" alt="Historic Old Jail in Ongaonga">
  <?php
echo '</div></div>';
include "footer.php";

?>


<div id="main">
    <div id="header">
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a href="index.html"><span class="logo_colour">Ongaonga Bed & Breakfast </span></a></h1>
          <h2>Make yourself at home is our slogan. We offer some of the best beds on the east coast. Sleep well and rest well.</h2>
        </div>
      </div>
      <div id="menubar">
        <ul id="menu">
            <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
            <li class="selected"><a href="index.php">Home</a></li>
            <li><a href="listrooms.php">Rooms</a></li>
            <li><a href="listbookings.php">Bookings</a></li>
            <li><a href="makebooking.php">Make a Booking</a></li>
            <li><a href="registercustomer.php">Register</a></li>
            
            <?php
            /*
            if (isAdmin()){
              echo '<li><a href="listcustomers.php">Customers</a></li>';
              }
*/
              ?>
            <li><a href="login.php">Login</a></li>
              
        </ul>
      </div>
      
       </div>
       <div id='status'><p id="loginstatus"><?/*php loginStatus();*/?></p></div>

	
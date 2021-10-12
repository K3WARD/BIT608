<?php
include "header.php";
/*include "checksession.php";*/
include "menu.php";
echo '<div id="site_content">';
include "sidebar.php";
echo '<div id="content">';
include "content.php";

?>



  <h2>Please Register and log on before making a booking</h2>
  <h2><a href='login.php'>[Login]</a><a href="registercustomer.php">[Register]</a></h2>
 
  <div id="imgbutcher">
  <img src="img/OngaongaButcher2.jpg" alt="Historic Butchers in Ongaonga">
</div>

<?php
echo '</div></div>';
include "footer.php";

?>
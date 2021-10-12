<?php
include "header.php";
include "checksession.php";
include "menu.php";
echo '<div id="site_content">';
include "sidebar.php";

echo '<div id="content">';
include "content.php";



include "config.php"; //load in any variables
$DBC = mysqli_connect('localhost', DBUSER, DBPASSWORD, DBDATABASE, DBPORT);

//insert DB code from here onwards
//check if the connection was good
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit; //stop processing the page further
}

//prepare a query and send it to the server
$query = 'SELECT * FROM customer WHERE ORDER BY lastname';
$result = mysqli_query($DBC,$query);
$rowcount = mysqli_num_rows($result); 
?>

<h1>Customer Details View</h1>
<h2><a href='listcustomers.php'>[Return to the Customer listing]</a><a href='index.php'>[Return to the main page]</a></h2>

<thead><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Action</th></tr></thead>
<?php

//makes sure we have the customer
if ($rowcount > 0) {  
    while ($row = mysqli_fetch_assoc($result)) {
	  $id = $row['roomID'];	
	  echo '<tr><td>'.$row['firstname'].'</td><td>'.$row['lastname'].'</td>';
	  echo     '<td><a href="viewroom.php?id='.$id.'">[view]</a>';
	  echo         '<a href="addroom.php">[add]</a>';
      echo         '<a href="editroom.php?id='.$id.'">[edit]</a>';
      echo         '<a href="deleteroom.php?id='.$id.'">[delete]</a></td>';
      
      echo '</tr>'.PHP_EOL;
   }
} else echo "<h2>No rooms found!</h2>"; //suitable feedback
echo "</table>";
mysqli_free_result($result); //free any memory used by the query
mysqli_close($DBC); //close the connection once done

mysqli_free_result($result); //free any memory used by the query
mysqli_close($DBC); //close the connection once done
?>
</table>
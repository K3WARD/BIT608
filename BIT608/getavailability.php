<?php
$con=mysqli_connect("localhost", "root", "root", "bnb", "8889");
$checkInDate=$_POST["checkInDate"];
$checkOutDate=$_POST["checkOutDate"];
$sql=mysqli_query($con,"SELECT roomID, roomname, roomtype, beds FROM room LEFT JOIN bookings ON bookings.room_ID=room.roomID WHERE roomID NOT IN (SELECT room_ID FROM bookings WHERE checkInDate between '.$checkInDate.' AND '.$checkOutDate.' OR checkOutDate between '.$checkInDate.' AND '.$checkOutDate.')");
$view="";
 while($row=mysqli_fetch_array($sql)){
      $view = $view ."<tr>";
        $view=$view."<td>".$row[0]."</td>";
        $view=$view."<td>".$row[1]."</td>";
        $view=$view."<td>".$row[2]."</td>";
        $view=$view."<td>".$row[3]."</td>";
      $view=$view."</tr>";
    }
    echo $view;
?>


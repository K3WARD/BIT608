<?php
include "header.php";
include "checksession.php";
include "menu.php";

echo '<div id="site_content">';
include "sidebar.php";

echo '<div id="content">';
include "content.php";

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



	$(document).ready(function(){
		$("#get_data").click(function(){
			var checkInDate=$("#checkInDate").val();
			var checkOutDate=$("#checkOutDate").val();
			$.ajax({
				type:'post',
				url:'getavailability.php',
				data:{checkInDate:checkInDate,checkOutDate,checkOutDate},
				success:function(data){
					$("#bookingdata").html(data);
					console.log(data);
				}
			});
		});
	});


</script>

<ul>
            <li><a href="CurrentBookings.php">Return to Booking List </a>  &nbsp;&nbsp; <a href="index.php">Return to main Page</a></li>
        </ul> 
  <h2>Booking Form</h2>
        <form>
        <div class="form_settings">

 <p><span>Checkin Date (dd-mm-yyyy)</span><input type="text" id="checkInDate" name = "checkInDate"></p> 
<p><span> Checkout Date (dd-mm-yyyy) </span><input type="text" id="checkOutDate" name = "checkOutDate"></p>
<span>Check for Available Rooms</span>
<input id="get_data" class="check" type="button" name="get_data" value="Check">

</div>
 
<table id="tablebookings" class="tablebooking">
<thead>
    <tr>
        <th>roomID</th>
        <th>Roomname</th>
        <th>Roomtype</th>
        <th>Beds</th>
    </tr>
</thead>
<tbody id="bookingdata">

</tbody>

</table>

<?php
echo '</div></div>';
include "footer.php";
?>



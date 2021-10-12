<?php
include "header.php";
include "checksession.php";
include "menu.php";
echo '<div id="site_content">';
include "sidebar.php";
echo '<div id="content">';
include "content.php";

?>


<h2><a href='login.php'>[Login]</a><a href="registercustomer.php">[Register]</a></h2>
<h2>Oagaonga Bed and Breakfast Privacy Policy</h2>
  
 <div id=privacypolicy>
     
 <p>We collect personal information from you, including information about your:</p> 
            <ul class="pplist">
              <li>name</a></li>
              <li>computer or network</a></li>
              <li>billing or purchase information</a></li>
            </ul>


<p>We collect your personal information in order to:</p>

            <ul class="pplist">
              <li>make accommodation bookings</a></li>
              
            </ul>



<p>Providing some information is optional. If you choose not to enter your name and email address, we'll take booking requests.</p>

<p>We keep your information safe by using password protected files and only allowing the owners access to them.</p>

<p>We keep your information for three years at which point we securely destroy it by securely deleting all electronic records.</p>

<p>You have the right to ask for a copy of any personal information we hold about you, and to ask for it to be corrected if you think it is wrong. If you’d like to ask for a copy of your information, or to have it corrected, please contact us at admin&amp;OBnB.nz, or 123-456 7894, or 123 Main St, Ongaonga, PO Box 123, New Zealand.</p>

</div>
  


<?php
echo '</div></div>';
include "footer.php";

?>
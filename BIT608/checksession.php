<?php
session_start();
/*
function isAdmin() {
 if (($_SESSION['loggedin'] == 1) and ($_SESSION['userid'] == 1)) 
     return TRUE;
 else 
     return FALSE;
}
*/
//function to check if the user is logged else send to the login page 
function checkUser() {
return true;
    $_SESSION['URI'] = '';    
    if ($_SESSION['loggedin'] == 1)
       return TRUE;
    else {
       $_SESSION['URI'] = 'http://localhost:8888/'.$_SERVER['REQUEST_URI']; //save current url for redirect     
       header('Location: http://localhost:8888/login.php', true, 303); 
       exit();      
    }       
}


//just to show we are are logged in

// changed the logged in and out from h2 tags to nothing so can echo in menu bar
function loginStatus() {
    $un = $_SESSION['username'];
    if ($_SESSION['loggedin'] == 1)     
        echo "Logged in as $un";
    else
        echo "Logged out";            
}

//log a user in
function login($id,$username) {
   //simple redirect if a user tries to access a page they have not logged in to
   if ($_SESSION['loggedin'] == 0 and !empty($_SESSION['URI']))        
        $uri = $_SESSION['URI'];          
   else { 
     $_SESSION['URI'] =  'http://localhost:8888/login.php';         
     $uri = $_SESSION['URI'];           
   }  





   $_SESSION['loggedin'] = 1;        
   $_SESSION['userid'] = $id;   
   $_SESSION['username'] = $username; 
   $_SESSION['URI'] = ''; 
   header('Location: '.$uri, true, 303);        
}



//simple logout function
function logout(){
  $_SESSION['loggedin'] = 0;
  $_SESSION['userid'] = -1;        
  $_SESSION['username'] = '';
  $_SESSION['URI'] = '';
  header('Location: http://localhost:8888/login.php', true, 303);    
}
?>
<?php 
    libxml_disable_entity_loader($disable=true);
    session_start();
//      echo '<script>alert(document.cookie)</script>';
//     // set time-out period (in seconds)
//     $inactive = 0;
//     // check to see if $_SESSION["timeout"] is set
//     //echo $_SESSION['timeout'];
//     if (isset($_SESSION["timeout"])) {
//         // calculate the session's "time to live"
//         $sessionTTL = time() - $_SESSION["timeout"];
//         if ($sessionTTL > $inactive) {
//             session_destroy();
//         }
//     }
    session_regenerate_id();
    //check if any user is in a session
    if(!isset($_SESSION['loggedin'])){
        die('You are not authorised to view this page.');
    }else{
        //echo $_SESSION['username'];
    }


?>
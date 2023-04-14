<?php 

function sanitizeData($datainput){
    
    $output = htmlspecialchars($datainput, ENT_QUOTES);
    
    
    return $output;
    
}

?>
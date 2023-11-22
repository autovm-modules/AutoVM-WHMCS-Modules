<?php 


if(isset($CloudDefaulLanguage)){
  $defLangadmin = $CloudDefaulLanguage;
} else {
  $defLangadmin = 'English';
}




// Check the cookies
if (isset($_COOKIE['temlangcookie'])) {
    $templatelang = $_COOKIE['temlangcookie'];
} elseif(!headers_sent()) {
    setcookie('temlangcookie', $defLangadmin, time() + (86400 * 30 * 12), '/');     
    $templatelang = $defLangadmin;
}


?>
<!-- Same as cloud -->
<!-- include address is different -->

<?php 

$defLangadmin = 'en';

// Defaul value from Config 
if(isset($CloudDefaulLanguage)){
  $defLangadmin = $CloudDefaulLanguage;
}

// Acceptable language list
$LangList = [ 'en' , 'fa' , 'tr' , 'fr' , 'ru' , 'du', 'it', 'br'];


// Change def language of is not valid
if(!in_array($defLangadmin, $LangList)){

  $defLangadmin = 'en';
  
} 


// set a default for page language
$templatelang = $defLangadmin; 



// Check the cookies
if (isset($_COOKIE['temlangcookie'])) {

  $templatelang = $_COOKIE['temlangcookie'];
    
} else {
    
  setcookie('temlangcookie', $defLangadmin, time() + (86400 * 30 * 12), '/'); 
    
}





// redirect the page with new language
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  // Handle the form submission and update the cookie
  $newLanguage = $_POST['language'];
  setcookie('temlangcookie', $newLanguage, time() + (86400 * 30), '/');
  
  // Reload the page to reflect the updated cookie
  header('Location: ' . $_SERVER['REQUEST_URI']);
  
  exit;
}
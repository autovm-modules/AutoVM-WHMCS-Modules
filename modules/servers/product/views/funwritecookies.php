<?php
include_once('config.php');

// Write Language
if (isset($_COOKIE['temlangcookie'])) {
    $templatelang = $_COOKIE['temlangcookie'];
} elseif (!headers_sent()) {
    setcookie('temlangcookie', 'English', time() + (86400 * 30 * 12), '/');     
    $templatelang = 'English';
}

// Verifique se $service está definido e não é nulo antes de tentar acessar suas propriedades
if (isset($service) && !is_null($service)) {
    // Find prefix or suffix from config
    $currencysymb = isset($service->client->currencyrel->prefix) ? $service->client->currencyrel->prefix : '';

    // find id for url
    $id = isset($service->id) ? $service->id : '';
    $machineId = $id;

    // find information to send to view
    $userid = isset($service->userid) ? $service->userid : '';
    $productid = isset($service->id) ? $service->id : '';

    $productname = isset($service->product->name) ? $service->product->name : '';
    $registrationdate = isset($service->regdate) ? $service->regdate : '';
    $nextduedate = isset($service->nextduedate) ? $service->nextduedate : '';
    $recurringpayment = isset($service->amount) ? $service->amount : '';
    $billingcycle = isset($service->billingcycle) ? $service->billingcycle : '';
    
    // set value in cookies for the first time
    $datapairs = array(
        'productname' => $productname,
        'registrationdate' => $registrationdate,
        'nextduedate' => $nextduedate,
        'recurringpayment' => $recurringpayment,
        'currencysymb' => $currencysymb,
        'billingcycle' => $billingcycle
    );
    
    // Delet all other machines
    $allCookies = $_COOKIE;

    // Loop through all cookies and delete the ones that contain 'price' in their names
    foreach ($allCookies as $cookieName => $cookieValue) {
        if (strpos($cookieName, 'productname') !== false || strpos($cookieName, 'registrationdate') !== false || strpos($cookieName, 'nextduedate') !== false || strpos($cookieName, 'recurringpayment') !== false || strpos($cookieName, 'billingcycle') !== false || strpos($cookieName, 'currencysymb') !== false) {
            // Set the cookie with an expiration time in the past to delete it
            setcookie($cookieName, '', time() - 3600, '/');
            
            // Unset the cookie from the $_COOKIE superglobal array
            unset($_COOKIE[$cookieName]);
        }
    }
    
    // Loop through the data keys and write cookies
    foreach ($datapairs as $key => $value) {   
        $dynamicKey = $key . $id;
        setcookie($dynamicKey, $value, time() + 3600 * 24 * 7, '/');
    }
    
} else {
    // Se $service não estiver definido ou for nulo, defina variáveis padrão para evitar erros.
    $id = '';
    $userid = '';
    $productid = '';
    $productname = '';
    $registrationdate = '';
    $nextduedate = '';
    $recurringpayment = '';
    $billingcycle = '';
    $currencysymb = '';
}
?>

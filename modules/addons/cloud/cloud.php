<?php
use WHMCS\Database\Capsule;
$path = dirname(__FILE__);

require $path . '/controller.php';

function cloud_config()
{
    $configarray = array(
        "name" => "AutoVM Cloud",
        "description" => "Cloud Module By AutoVM for WHMCS",
        "version" => "V05.09.00",
        "author" => "AutoVM.net",
    );
    return $configarray;

}



// Get Token From AutoVm module
function autovm_get_admintoken_baseurl_cloud(){
    $response = [];

    // find Module aparams
    try {
        $moduleparams = Capsule::table('tbladdonmodules')->get();
        foreach ($moduleparams as $item) {
            if($item->module == 'autovm'){
                if($item->setting == 'BackendUrl'){
                    $BackendUrl = $item->value;
                }
                
                if($item->setting == 'AdminToken'){
                    $AdminToken = $item->value;
                }
                
                if($item->setting == 'DefLang'){
                    $DefLang = $item->value;
                }
                
                if($item->setting == 'CloudActivationStatus'){
                    $CloudActivationStatus = $item->value;
                }
            }
        }
    } catch (\Exception $e) {
        $error = '<p><li style="color:red; padding: 5px;">Database ERR ===> Can not find module params table in database</li></p>';
        $response['error'] = $error;
        return $response;
    }


    // if cloud is active
    if(isset($CloudActivationStatus)){
        $response['CloudActivationStatus'] = $CloudActivationStatus;
    }


    if(empty($BackendUrl)){
        $message = '<p><li style="color:red; padding: 5px;">Backend URL ERR ===> Go to addons module and insert your backend adrress</li></p>';
        $response['message'] = $message;
        return $response;
    }
    
    if(empty($AdminToken)){
        $message = '<p><li style="color:red; padding: 5px;">Admin Token ERR ===> Go to addons module and insert your Token</li></p>';
        $response['message'] = $message;
        return $response;
    }

    if(empty($DefLang)){
        $message = '<p><li style="color:red; padding: 5px;">Defaul Language ERR ===> Go to addons module and select a language</li></p>';
        $response['message'] = $message;
        return $response;
    }

    if(isset($AdminToken) && isset($BackendUrl) && isset($DefLang)){
        $response['AdminToken'] = $AdminToken;
        $response['BackendUrl'] = $BackendUrl;
        $response['DefLang'] = $DefLang;
        return $response;
    }
    
}




// Add functionality to client area env
function cloud_clientarea($vars)
{
    $response = autovm_get_admintoken_baseurl_cloud();

    
    if(!empty($response['error'])){
        $error = $response['error'];
        echo($error);
        return false;
    }


    if(!empty($response['CloudActivationStatus'])){
        $CloudActivationStatus = $response['CloudActivationStatus'];
        
    }
    
    
    if(!empty($response['message'])){
        $message = $response['message'];
        return false;
    }
    
    
    if(!empty($CloudActivationStatus)){
        if(!empty($response['AdminToken']) && !empty($response['BackendUrl']) && !empty($response['DefLang'])){
            $AdminToken = $response['AdminToken'];
            $BackendUrl = $response['BackendUrl'];
            $DefLang = $response['DefLang']; 
        }
        
        
        
        // get Default Language
        if(empty($DefLang)){
            $DefLang = 'English';
        }
        
        if(($DefLang != 'English' && $DefLang != 'Farsi' && $DefLang != 'Turkish' && $DefLang != 'Russian' && $DefLang != 'Deutsch' && $DefLang != 'French' && $DefLang != 'Brizilian' && $DefLang != 'Italian')){
            $DefLang = 'English';
        }
    
        if(!empty($DefLang)){
            if(empty($_COOKIE['temlangcookie'])) {
                setcookie('temlangcookie', $DefLang, time() + (86400 * 30 * 12), '/');
            }
        }



    
        // Create Controller
        $action = autovm_get_query('action');
        $clientId = autovm_get_session('uid');
        if(!empty($clientId) && !empty($AdminToken) && !empty($BackendUrl)) {
            try {
                $controller = new CloudController($clientId, $AdminToken, $BackendUrl);
                return $controller->handle($action);
            } catch (Exception $e) {
                return "Error: " . $e->getMessage();
            }
        } else {
            echo "Error: Missing required parameters";
        }
    }
}




// Show in admin panel in addon menu page
function cloud_output($vars) {

    $response = autovm_get_admintoken_baseurl_cloud();    
    
    if(!empty($response['DefLang'])){
        $DefLang = $response['DefLang'];
    } else {
        $DefLang = 'English';
    }

    if(!empty($vars['version']) && !empty($DefLang) ){
        $version = $vars['version'];
        $text = '<h2> Version : ' . $version . '</h2><h3>Language :' .  $DefLang . '</h3>';
        echo($text);
    }




    $text = '
        <p style="padding: 50px 0px 0px 0px; !important">
        <span style="font-weight: 800 !important;">AutoVM Cloud</span> is a specialized module designed by <a href="https://AutoVM.net/" style="font-weight: 800 !important;" target="_blank">AutoVM</a> to streamline the connection between the AutoVM Backend and WHMCS, providing an intelligent solution for efficiently managing clients and their virtual machines within the WHMCS environment.
        </p>';
    echo($text);

    
    $text = '
        <p>
        You can always get the latest version from the <a href="https://github.com/AutoVM-modules/AutoVM-WHMCS-Modules" style="font-weight: 800 !important;" target="_blank">AutoVM git repository</a>
        </p>
        <p>
        To learn how to use AutoVM modules, please check out the <a href="https://AutoVM.net/docs/" style="font-weight: 800 !important;" target="_blank"> AutoVM documentation page</a>
        </p>
        ';
    echo($text);


    
    // Show deactive status
    if(empty($response['CloudActivationStatus'])){
        
        
        echo('<p style="color: red; font-weight: bold; margin: 50px 0px 0px 0px">Cloud Module is currently disabled in your WHMCS</p>');
        echo('<li style="font-weight: 400; margin: 10px 0px 0px 0px">
        <span style="font-weight: 600;">AutoVM Cloud Module</span> is now disabled in your WHMCS, if you are sure to enable it, you should go to <span style="font-weight: 600;">"WHMCS System Setting"</span>, and find <span style="font-weight: 600;">"Addon Modules"</span>, then find <span style="font-weight: 600;">AUTOVM Module</span> and check the <span style="font-weight: 600;">"Enable Cloud Module"</span> checkbox.
        </li>');
        echo('<li style="font-weight: 400; margin: 5px 0px 0px 0px">Remember, it is crucial to be absolutely certain about your actions, as they have the potential to cause <span style="font-weight: 600; color:red;">significant damage</span></li>');
        
    } 


    // show Messgaes
    if(!empty($response['message'])){
        echo('<pre style="padding: 20px 20px 20px 20px; margin: 30px 0px 30px 0px">');
        print_r($response['message']);
        echo('</pre>');
    } 
    
    // show Errors
    if(!empty($response['error'])){
        echo('<pre style="padding: 20px 20px 20px 20px; margin: 30px 0px 30px 0px">');
        print_r($response['error']);
        echo('</pre>');
    } 
    
    
}
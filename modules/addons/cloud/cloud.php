<?php
use WHMCS\Database\Capsule;
$path = dirname(__FILE__);

require $path . '/controller.php';

function cloud_config()
{
    $AutovmDefaultCurrencyID = 'Insert Id of your currency for cloud';
    $AutovmDefaultCurrencySymbol = 'Insert Symbol of your currency for cloud';
    $PlaceCurrencySymbol = 'Select between "suffix" or "prefix" or "code" as the place of symbol in your currency setting';
    $ShowExchange = 'Select "on" to enable showing Ratio and Conversion exchanges';
    $ChargeModuleEnable = 'Select "on" to enable direct charging module';
    $ConsoleRoute = 'This is usually is domain of your WHMCS added to /console e.q. "https://www.mywhmcs.com/console"';
    $TopupLink = 'This is usually one of your pages that user can increase their credit, default is "/clientarea.php?action=addfunds"';
    $AdminUserSummeryPagePath = 'This is the url of user sumery page in admin panel, if you did not changed it, it will be like this "/admin/clientssummary.php"';
    $minimumChargeInAutovmCurrency = 'The least amount a user can charge its own cloud balance';
    $DefaultMonthlyDecimal = 'Insert the decimal for Cost Monthly in cloud currency';
    $DefaultHourlyDecimal = 'Insert the decimal for Cost Hourly in cloud currency';
    $DefaultBalanceDecimalWhmcs = 'Insert the decimal for Balance in User Currency';
    $DefaultBalanceDecimalCloud = 'Insert the decimal for Balance in cloud currency';
    $DefaultChargeAmountDecimalWhmcs = 'Insert the decimal for Charge amount in user currency';
    $DefaultChargeAmountDecimalCloud = 'Insert the decimal for Charge amount in cloud currency';
    $DefaultCreditDecimalWhmcs = 'Insert the decimal for Credit in user currency';
    $DefaultCreditDecimalCloud = 'Insert the decimal for Credit in cloud currency';
    $DefaultMinimumDecimalWhmcs = 'Insert the decimal for Minimum Charge Amount in user currency';
    $DefaultMinimumDecimalCloud = 'Insert the decimal for Minimum Charge Amount in cloud currency';
    $DefaultRatioDecimal = 'Insert the decimal for Ratio';
    
    $decimalOptions = array (
        'option1' => 0,
        'option2' => 1,
        'option3' => 2,
    );

    $OnOffOption = array(
        'option1' => 'on',
        'option2' => 'off',
    );
    
    $CurrencyPlaceOption = array(
        'option1' => 'code',
        'option2' => 'suffix',
        'option3' => 'prefix',
    );


    $configarray = array(
        "name" => "AutoVMCloud",
        "description" => "Cloud Module By AutoVM for WHMCS",
        "version" => "V05.11.00",
        "author" => "AutoVM.net",
        "fields" => array(
            "AutovmDefaultCurrencyID" => array ("FriendlyName" => "Currency ID", "Type" => "text", "Size" => "31", "Description" => $AutovmDefaultCurrencyID, "Default" => 1),
            "AutovmDefaultCurrencySymbol" => array ("FriendlyName" => "Currency Symbol", "Type" => "text", "Size" => "31", "Description" => $AutovmDefaultCurrencySymbol, "Default" => "$"),
            "PlaceCurrencySymbol" => array ("FriendlyName" => "Currency Placeholder", "Type" => "dropdown", 'Options' => $CurrencyPlaceOption, "Default" => 'option3', "Description" => $PlaceCurrencySymbol),
            "ShowExchange" => array ("FriendlyName" => "Show Exchange", "Type" => "dropdown", 'Options' => $OnOffOption, "Default" => 'option2', "Description" => $ShowExchange),
            "ChargeModuleEnable" => array ("FriendlyName" => "Enable Charging Module", "Type" => "dropdown", 'Options' => $OnOffOption, "Default" => 'option1', "Description" => $ChargeModuleEnable),
            "ConsoleRoute" => array ("FriendlyName" => "Console Route", "Type" => "text", "Size" => "31", "Description" => $ConsoleRoute, "Default" => "https://www.mywhmcs.com/console"),
            "TopupLink" => array ("FriendlyName" => "Topup page Link", "Type" => "text", "Size" => "31", "Description" => $TopupLink, "Default" => "/clientarea.php?action=addfunds"),
            "AdminUserSummeryPagePath" => array ("FriendlyName" => "User Summery Page address in panel admin", "Type" => "text", "Size" => "51", "Description" => $AdminUserSummeryPagePath, "Default" => "/admin/clientssummary.php"),
            "minimumChargeInAutovmCurrency" => array ("FriendlyName" => "Minumum charge allowed in cloud currency", "Type" => "text", "Size" => "31", "Description" => $minimumChargeInAutovmCurrency, "Default" => "2"),
            "DefaultMonthlyDecimal" => array ("FriendlyName" => "Cost Decimal Monthly in User Currency", "Type" => "dropdown",'Options' => $decimalOptions, "Default" => 'option1', "Description" => $DefaultMonthlyDecimal),
            "DefaultHourlyDecimal" => array ("FriendlyName" => "Cost Decimal hourly in User Currency", "Type" => "dropdown",'Options' => $decimalOptions, "Default" => 'option1', "Description" => $DefaultHourlyDecimal),
            "DefaultBalanceDecimalWhmcs" => array ("FriendlyName" => "Balance Decimal in User Currency", "Type" => "dropdown", 'Options' => $decimalOptions, "Default" => 'option1', "Description" => $DefaultBalanceDecimalWhmcs),
            "DefaultBalanceDecimalCloud" => array ("FriendlyName" => "Balance Decimal in Cloud Currency", "Type" => "dropdown", 'Options' => $decimalOptions, "Default" => 'option1', "Description" => $DefaultBalanceDecimalCloud),
            "DefaultChargeAmountDecimalWhmcs" => array ("FriendlyName" => "Charge Amount Decimal in User Currency", "Type" => "dropdown", 'Options' => $decimalOptions, "Default" => 'option1', "Description" => $DefaultChargeAmountDecimalWhmcs),
            "DefaultChargeAmountDecimalCloud" => array ("FriendlyName" => "Charge Amount Decimal in Cloud Currency", "Type" => "dropdown", 'Options' => $decimalOptions, "Default" => 'option1', "Description" => $DefaultChargeAmountDecimalCloud),
            "DefaultCreditDecimalWhmcs" => array ("FriendlyName" => "Credit Decimal in User Currency", "Type" => "dropdown", 'Options' => $decimalOptions, "Default" => 'option1', "Description" => $DefaultCreditDecimalWhmcs),
            "DefaultCreditDecimalCloud" => array ("FriendlyName" => "Credit Decimal in Cloud Currency", "Type" => "dropdown", 'Options' => $decimalOptions, "Default" => 'option1', "Description" => $DefaultCreditDecimalCloud),
            "DefaultMinimumDecimalWhmcs" => array ("FriendlyName" => "Minimum charge amount Decimal in User Currency", "Type" => "dropdown", 'Options' => $decimalOptions, "Default" => 'option1', "Description" => $DefaultMinimumDecimalWhmcs),
            "DefaultMinimumDecimalCloud" => array ("FriendlyName" => "Minimum charge amount Decimal in Cloud Currency", "Type" => "dropdown", 'Options' => $decimalOptions, "Default" => 'option1', "Description" => $DefaultMinimumDecimalCloud),
            "DefaultRatioDecimal" => array ("FriendlyName" => "Exchange Rate Decimal", "Type" => "dropdown", 'Options' => $decimalOptions, "Default" => 'option1', "Description" => $DefaultRatioDecimal),
        ));
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
        $error = 'Database ERR ===> Can not find module params table in database';
        $response['error'] = $error;
        return $response;
    }


    // if cloud is active
    if(isset($CloudActivationStatus)){
        $response['CloudActivationStatus'] = $CloudActivationStatus;
    }


    if(empty($BackendUrl)){
        $message = 'Backend URL ERR ===> Go to addons module and insert your backend adrress';
        $response['message'] = $message;
        return $response;
    }
    
    if(empty($AdminToken)){
        $message = 'Admin Token ERR ===> Go to addons module and insert your Token';
        $response['message'] = $message;
        return $response;
    }

    if(empty($DefLang)){
        $message = 'Defaul Language ERR ===> Go to addons module and select a language';
        $response['message'] = $message;
        return $response;
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
    
    if(isset($AdminToken) && isset($BackendUrl) && isset($DefLang)){
        $response['AdminToken'] = $AdminToken;
        $response['BackendUrl'] = $BackendUrl;
        $response['DefLang'] = $DefLang;
        return $response;
    }
    
}

// Get Token From AutoVm module
function autovm_get_config_cloud(){
    $response = [];
    $requiredKeys = [
        'AutovmDefaultCurrencyID' => null,
        'AutovmDefaultCurrencySymbol' => null,
        'PlaceCurrencySymbol' => null,
        'ShowExchange' => null,
        'ChargeModuleEnable' => null,
        'ConsoleRoute' => null,
        'TopupLink' => null,
        'AdminUserSummeryPagePath' => null,
        'minimumChargeInAutovmCurrency' => null,
        'DefaultMonthlyDecimal' => null,
        'DefaultHourlyDecimal' => null,
        'DefaultBalanceDecimalWhmcs' => null,
        'DefaultBalanceDecimalCloud' => null,
        'DefaultChargeAmountDecimalWhmcs' => null,
        'DefaultChargeAmountDecimalCloud' => null,
        'DefaultCreditDecimalWhmcs' => null,
        'DefaultCreditDecimalCloud' => null,
        'DefaultMinimumDecimalWhmcs' => null,
        'DefaultMinimumDecimalCloud' => null,
        'DefaultRatioDecimal' => null,
    ];

    try {
        $moduleparams = Capsule::table('tbladdonmodules')->get();
        foreach ($moduleparams as $item) {
            if($item->module == 'cloud'){
                foreach ($requiredKeys as $key => $value) {
                    if ($item->setting == $key) {
                        if(!empty($item->value)){
                            $requiredKeys[$key] = $item->value;
                        } else {
                            $response['message'] = "$key has no value";
                            return $response;
                        }
                    }
                }
            }
        }
    } catch (\Exception $e) {
        $error = 'Cloud Config ERR ===> Can not find module params table in database';
        $response['error'] = $error;
        return $response;
    }

    foreach ($requiredKeys as $key => $value){
        if(isset($requiredKeys[$key])){
            $response[$key] = $value;
        } 
    }
    
    $variables = $requiredKeys;
    cloud_create_config_file($variables);

    return $response;
}



// Add functionality to client area env
function cloud_create_config_file($variables){
    
    $configFilePath = __DIR__ . '/views/autovm/includes/commodules/vitalvariable.php';
    $configArray = $variables;
    
    // Write the array to the configuration file
    file_put_contents($configFilePath, '<?php return ' . var_export($configArray, true) . ';');
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
            autovm_get_config_cloud();
            try {
                $controller = new CloudController($clientId, $AdminToken, $BackendUrl);
                return $controller->handle($action);
            } catch (Exception $e) {
                return "Error";
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


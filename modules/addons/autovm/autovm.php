<?php

use WHMCS\Database\Capsule;

function autovm_config()
{  
    $BackendUrlLabel = '<span style="padding-left: 30px">Insert your Backend Address, started with http as an example "http://backend.autovm.online"</span>';
    $AdminTokenLabel = '<span style="padding-left: 30px">Insert your Admin Token here, as an Example "de8fs953k49ho3ellg9x", You can find the Admin Token in AutoVM Frontend Panel/User tab</span>';
    $DefLangLabel = '<span style="padding-left: 30px">Select a language as default language for admin and users panel, this language setting is for AutoVM Module and has nothing to do with WHMCS language setting</span>';
    $CloudActivationStatusLabel = '<span style="padding-left: 30px; color: red;">!!! Please be very careful. Enabling Cloud Module unintentionally or accidentally can be harmful.</span>';
    $ConsoleRoute = '<span style="padding-left: 30px">This is usually is domain of your WHMCS added to /console e.q. "https://mywhmcs.com/console"</span>';
    
    $langiageOption = array (
        'English' => 'English',
        'Farsi' => 'Farsi',
        'Turkish' => 'Turkish',
        'Russian' => 'Russian',
        'Deutsch' => 'Deutsch',
        'French' => 'French',
        'Brizilian' => 'Brizilian',
        'Italian' => 'Italian',
    );

    $configarray = array(
        "name" => "AutoVM",
        "description" => "Main AutoVM Module",
        "version" => "V05.13.01",
        "author" => "autovm.net",
        "fields" => array(
            "BackendUrl" => array ("FriendlyName" => "Backend Url", "Type" => "text", "Size" => "31", "Description" => $BackendUrlLabel, "Default" => "http://backend.autovm.online"),
            "AdminToken" => array ("FriendlyName" => "Admin Token", "Type" => "text", "Size" => "31", "Description" => $AdminTokenLabel, "Default" => "xxxx"),
            "DefLang" => array ("FriendlyName" => "Default Language", "Type" => "dropdown", "Options" => $langiageOption, "Description" => $DefLangLabel, "Default" => "English"),
            "CloudActivationStatus" => array ("FriendlyName" => "Enable Cloud Module", "Type" => "yesno", 'Description' => $CloudActivationStatusLabel, "Default" => ""),            
            "ConsoleRoute" => array ("FriendlyName" => "Console Route", "Type" => "text", "Size" => "50", "Description" => $ConsoleRoute, "Default" => "https://mywhmcs.com/console"),
            "RefreshTraffic" => array("FriendlyName" => "Refresh Traffic", "Type" => "dropdown", "Options" => array("active" => "Active", "passive" => "Passive"), "Description" => "Refresh Traffic By WHMCS", "Default" => "passive")
        ));
        return $configarray;
}

function autovm_activate()
{
    autovm_get_admintoken_baseurl_autovm();

    $hasTable = Capsule::schema()->hasTable('autovm_user');

    if (empty($hasTable)) {

        Capsule::schema()->create('autovm_user', function ($table) {

            $table->increments('id');
            $table->string('user_id');
            $table->string('token');
        });
    }

    $hasTable = Capsule::schema()->hasTable('autovm_order');

    if (empty($hasTable)) {

        Capsule::schema()->create('autovm_order', function ($table) {

            $table->increments('id');
            $table->string('order_id');
            $table->string('machine_id');
        });
    }

    $pdo = Capsule::connection()->getPdo();

    $pdo->exec('ALTER TABLE tblcurrencies MODIFY rate decimal(30, 10)');
}

// Get Token From AutoVM
function autovm_get_admintoken_baseurl_autovm(){
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
        $message = '<p><li style="color:red; padding: 5px;">Database ERR ===> Can not find module params table in database</li></p>';
        $response['message'] = $message;
        return $response;
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

    
    if($AdminToken && $BackendUrl && $DefLang){
        $response['AdminToken'] = $AdminToken;
        $response['BackendUrl'] = $BackendUrl;
        $response['DefLang'] = $DefLang;
        return $response;
    }
    
}

// Show in admin panel in addon menu page
function autovm_output($vars) {

    $response = autovm_get_admintoken_baseurl_autovm();    
    if(!empty($response['DefLang'])){
        $DefLang = $response['DefLang'];
    } else {
        $DefLang = 'English';
    }

    $version = $vars['version'];
    $text = '<h2> Version : ' . $version . '</h2><h3>Language :' .  $DefLang . '</h3>';
    echo($text);


    $text = '
        <p style="padding: 50px 0px 0px 0px; !important">
        <span style="font-weight: 800 !important;">AutoVM Module</span> is a specialized module designed by <a href="https://AutoVM.net/" style="font-weight: 800 !important;" target="_blank">AutoVM</a> to streamline the connection between the AutoVM Backend and WHMCS.
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

    
    if(!empty($response['message'])){
        echo('<pre style="padding: 20px 20px 20px 20px; margin: 30px 0px 30px 0px">');
        print_r($response['message']);
        echo('</pre>');
    } 
    

    $iframe = '<iframe src="/autovmupdatepage.php" frameborder="0" class="iframe"></iframe><style>.iframe{width:100%; height: 800px;}</style>';
    echo $iframe;
}

add_hook('AddonConfigSave', 1, function($vars) {
    autovm_get_admintoken_baseurl_autovm();
});

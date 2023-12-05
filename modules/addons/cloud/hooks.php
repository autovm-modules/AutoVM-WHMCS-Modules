<!-- Create Cloud Menu, Create controller for user balance in admin panel -->
<?php
use WHMCS\Database\Capsule;
use PG\Request\Request;
use WHMCS\User\Client;

// Create a menu with name CLOUD, if cloud module is enabled
function autovm_create_cloud_menu(){
    add_hook('ClientAreaPrimaryNavbar', 1, function($primaryNavbar) {
        /** @var \WHMCS\View\Menu\Item $primaryNavbar */
        $newMenu = $primaryNavbar->addChild(
            'uniqueMenuItemName',
            array(
                'name' => 'cloud',
                'label' => 'Cloud',
                'uri' => '/index.php?m=cloud&action=pageIndex',
                'order' => 99,
                'icon' => '',
            )
        );
    });
}


// Get Admin Token and BaseUrl From AutoVm module
function autovm_get_admintoken_baseurl_admin(){
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
                
                if($item->setting == 'ConsoleRoute'){
                    $ConsoleRoute = $item->value;
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
        $response['ConsoleRoute'] = $ConsoleRoute;
        return $response;
    }
}


// Create user and record user token
function admin_create_user($client, $BackendUrl)
{
    if(!empty($BackendUrl)){
        $params = [
            'name' => $client->fullName, 'email' => $client->email
        ];
    
        $address = [
            $BackendUrl, 'candy', 'frontend', 'auth', 'token', 'register'
        ];
    
        return Request::instance()->setAddress($address)->setParams($params)->getResponse()->asObject();
    } else {
        return false;
    }
}


// Get user token from data base
function admin_get_user_token_from_database($WhUserId)
{
    $params = ['userId' => $WhUserId];
    $user = Capsule::selectOne('SELECT token FROM autovm_user WHERE user_id = :userId', $params);
    return current($user);
}


// Manage user token, read from table or create and record a new token
function admin_handel_usertoken($WhUserId, $BackendUrl)
{
    try {
        // Find client info
        $client = Client::find($WhUserId);
        if (empty($client)) {
            echo('can not find client');
            return false; // We dont need to log anything here
        }

        // Find token in database
        $token = admin_get_user_token_from_database($WhUserId);

        // Create user in AutoVM if there is no token in data base
        if (empty($token)) {
            $response = admin_create_user($client, $BackendUrl);

            if (empty($response)) {
                echo('can not connect to backend to create new user');
                return false; // We dont need to log anything here
            }

            $message = property_exists($response, 'message');
            if ($message) {
                echo('error accured, Err: ');
                echo($response->message);
                return false; // We dont need to log anything here
            }

            // Save token
            $user = $response->data;
            $params = ['user_id' => $client->id, 'token' => $user->token];

            $answer = Capsule::table('autovm_user')->insert($params);

            if($answer){
                return true;
            } else {
                echo('can not able to insert user token');
                return false;
            }

        } else {
            return true;
        }
    } catch (\Exception $e) {
        echo "handle user token failed : ";
        echo($e);
        return false;
    }
}


// iframe in user profile tab in admin panel to handle user balance and credit
add_hook('AdminAreaClientSummaryPage', 1, function($vars) {
    include ('admincontroller.php');

    $response =  autovm_get_admintoken_baseurl_admin();
    
    if(isset($response['CloudActivationStatus'])){
        $CloudActivationStatus = $response['CloudActivationStatus'];
    }
    
    // if cloud is active
    if(!empty($CloudActivationStatus)){
        if(!empty($response['error'])){
            $text = '<pre style="padding: 20px 20px 20px 20px; margin: 30px 0px 30px 0px">' . $response['error'] . '</pre>';
            return $text;
        } else if(!empty($response['message'])){
            $text = '<pre style="padding: 20px 20px 20px 20px; margin: 30px 0px 30px 0px">' . $response['message'] . '</pre>';
            return $text;
        } else if(!empty($response['AdminToken']) && !empty($response['BackendUrl']) && !empty($response['DefLang'])){
            $AdminToken = $response['AdminToken'];
            $BackendUrl = $response['BackendUrl'];
            $DefLang = $response['DefLang'];
        } else {
            $text = '<pre style="padding: 20px 20px 20px 20px; margin: 30px 0px 30px 0px">Admin Token or URL is empty</pre>';
            return $text;
        }
        




            
        // get Default Language
        if(empty($DefLang)){
            $DefLang = 'English';
        }
        
        if(($DefLang != 'English' && $DefLang != 'Farsi' && $DefLang != 'Turkish' && $DefLang != 'Russian' && $DefLang != 'Deutsch' && $DefLang != 'French' && $DefLang != 'Brizilian' && $DefLang != 'Italian')){
            $DefLang = 'English';
        }
    
        if(!empty($DefLang)){
            if(empty($_COOKIE['temlangcookie']) && !headers_sent()) {
                setcookie('temlangcookie', $DefLang, time() + (86400 * 30 * 12), '/');
            }
        }
    
    
    



        // Writing user token
        $WhUserId = $vars['userid'];
        if(isset($WhUserId) && isset($BackendUrl)){
            $response = admin_handel_usertoken($WhUserId, $BackendUrl);
        }
    
        if(!$response){
            echo('handle did not work');
            return false;
        }
    
        try {
            $userTable = Capsule::table('autovm_user')->get();
            foreach ($userTable as $item) {
                if($item->user_id == $WhUserId){
                    $userToken = $item->token;
                }
            }
        } catch (\Exception $e) {
            echo "Can not find autovm_user table in database";
        }
        
        
        if(isset($userToken)){
            $controller = new admincontroller($userToken, $WhUserId, $BackendUrl, $AdminToken);
            if(isset($_GET['method'])){
                $controller->handle($_GET['method']);
            }
        } else {
            echo "Can not find token in database";
        }
    
        
        $PersonalRootDirectoryURL = '';
        $link = $PersonalRootDirectoryURL . '/modules/addons/cloud/views/autovm/admin.php?userid=' . $WhUserId;
        $value = '<iframe src="' . $link . '" class="autovm"></iframe><style type="text/css"> .autovm{width: 1200px;height: 600px;border: none;}</style>';
        
        return $value;    
    }
});



// create menu if cloud is active
$response =  autovm_get_admintoken_baseurl_admin();
if(isset($response['CloudActivationStatus'])){
    $CloudActivationStatus = $response['CloudActivationStatus'];
}
if(!empty($CloudActivationStatus)){
    autovm_create_cloud_menu();
}



<?php

use WHMCS\Database\Capsule;
use PG\Request\Request;
use WHMCS\User\Client;


function autovm_create_user($client, $BackendUrl)
{
    $params = ['name' => $client->fullName, 'email' => $client->email ];
    $address = [ $BackendUrl, 'candy', 'frontend', 'auth', 'token', 'register' ];
    return Request::instance()->setAddress($address)->setParams($params)->getResponse()->asObject();
}



function autovm_get_user_token($userId)
{
    $params = ['userId' => $userId];
    $user = Capsule::selectOne('SELECT token FROM autovm_user WHERE user_id = :userId', $params);
    return current($user);
}



// Get Token From AutoVm module
function autovm_get_admintoken_baseurl_client(){
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
    
    if(empty($ConsoleRoute)){
        $message = 'ConsoleRoute ERR ===> Go to addons module and insert ConsoleRoute';
        $response['message'] = $message;
        return $response;
    }

    if(isset($AdminToken) && isset($BackendUrl) && isset($DefLang) && isset($ConsoleRoute)){
        $response['AdminToken'] = $AdminToken;
        $response['BackendUrl'] = $BackendUrl;
        $response['DefLang'] = $DefLang;
        $response['ConsoleRoute'] = $ConsoleRoute;
        return $response;
    } 
}



// Hook to generate user and token in data base for cloud in client side
add_hook('ClientAreaPage', 100, function($params) {
    $response =  autovm_get_admintoken_baseurl_client();
    if(!empty($response['error'])){
        return false;
    }

    if(isset($response['CloudActivationStatus'])){
        $CloudActivationStatus = $response['CloudActivationStatus'];
    }

    if(!empty($response['message'])){
        return false;
    }
    
    if(isset($response['AdminToken']) && isset($response['BackendUrl'])){
        $AdminToken = $response['AdminToken'];
        $BackendUrl = $response['BackendUrl'];
    }
    
    // create token if cloud is active
    if(!empty($CloudActivationStatus) && !empty($AdminToken) && !empty($BackendUrl)){
        
        $clientId = autovm_get_session('uid');
        if (empty($clientId)) {
            // echo('can not find client ID');
            return false;
        }
    

        $client = Client::find($clientId);
        if(empty($client)) {
            echo('can not find the client');
            return false;
        }


        $token = autovm_get_user_token($clientId);
        if($token) {
            return false;
        }


        // create new user if can not find Token
        $CreateResponse = autovm_create_user($client, $BackendUrl);
        if(empty($CreateResponse)) {
            return false;
        }


        $message = property_exists($CreateResponse, 'message');
        if($message) {
            return false;
        }


        $user = $CreateResponse->data;

        // Save token in WHMCS
        $params = ['user_id' => $client->id, 'token' => $user->token];

        Capsule::table('autovm_user')
            ->insert($params);
            
    } else {
        return false;
    }
});




// Hook for creating traffic in WHMCS version 5.4
// add_hook('InvoicePaid', 1, function($vars) {

//     $invoiceid = $vars['invoiceid'];
//     $command = 'GetInvoice';
//     $postData = array(
//         'invoiceid' => $invoiceid,
//     );

//     $results = localAPI($command, $postData);

//     $items = $results['items']['item'];

//     foreach ($items as $item) {
//         $description = $item['description'];
//         $description = strtolower($description);
//         if (strpos($description, 'traffic') !== false) {
            

            
            


//             // Find OrderId from InvoiceID in tblorders
//             $Ordertable = Capsule::table('tblorders')
//             ->where('invoiceid', $invoiceid)
//             ->first();

//             if(empty($Ordertable)){
//                 return 'can not find invoice in tblorders';
//             }
            
//             $OrderIdFromInvoceID = $Ordertable->id;

//             if(empty($OrderIdFromInvoceID)){
//                 return 'can not find orderid from invoiceid in tblorders';
//             }

            







//             // Find real orderID from hostingid in tblhostingaddons
//             $hostingAddonsTable = Capsule::table('tblhostingaddons')
//             ->where('orderid', $OrderIdFromInvoceID)
//             ->first();

//             if(empty($hostingAddonsTable)){
//                 return 'can not find orderid in hostingAddonsTable';
//             }

//             $hostingid = $hostingAddonsTable->hostingid;

//             if(empty($hostingid)){
//                 return 'can not find hostingid in hostingAddonsTable';
//             }

//             // hostingid is actually serviceid
//             $serviceId = $hostingid;
            
            
            






//             // Find Addon ID to find params
//             $addonid = $hostingAddonsTable->addonid;
//             if(empty($addonid)){
//                 return 'can not find addonid in hostingAddonsTable';
//             }

//             $addonsTable = Capsule::table('tbladdons')
//             ->where('id', $addonid)
//             ->first();
            
//             if(empty($addonsTable)){
//                 return 'can not find addonid in addonsTable';
//             }
            
//             $addonDescription = $addonsTable->description;

            

//             if(empty($addonDescription)){
//                 return 'can not find addonDescription in addonsTable';
//             }

//             $TrafficAmount = $addonDescription;
//             if(!is_numeric($TrafficAmount)){
//                 return 'traffic amount is not numeric';
//             }

            

//             // Send request
//             $controller = new AVMController($serviceId);
//             $machineId = $controller->getMachineIdFromService();

//             if (empty($machineId)) {
//                 return 'Could not find the machine identity';
//             }
            
//             $ServiceDuration = $controller->getServiceDuration();
//             if (empty($ServiceDuration)) {
//                 return 'Could not find duration';
//             }


//             $ServiceRemaining = $controller->getServiceRemaining();
//             if (empty($ServiceRemaining)) {
//                 //nothing
//             }

//             $controller->sendTrafficRequest($machineId, $TrafficAmount, $ServiceRemaining, $ServiceDuration, 'plus');
        

//             // $filePath = __DIR__ . '/file.txt';
//             // file_put_contents($filePath, var_export($ServiceRemaining, true));
            
//         }
//     }
    
// });

<?php

use WHMCS\Database\Capsule;
use PG\Request\Request;

class CloudController
{
    
    protected $clientId;
    protected $AdminToken;
    protected $BackendUrl;

    public function __construct($clientId, $AdminToken, $BackendUrl)
    {
        $this->clientId = $clientId;
        $this->AdminToken = $AdminToken;
        
        $BackendUrl = str_replace(' ', '', $BackendUrl);
        $BackendUrl = preg_replace('/\s+/', '', $BackendUrl);        
        $this->BackendUrl = $BackendUrl;
    }

    public function pageIndex()
    {
        return ['templatefile' => 'views/index'];
    }

    public function pageMachines()
    {
        return ['templatefile' => 'views/machines'];
    }

    public function pageMachine()
    {
        return ['templatefile' => 'views/machine'];
    }

    public function pageCreate()
    {
        return ['templatefile' => 'views/create'];
    }

    public function login()
    {
        $token = $this->getUserTokenFromClientId();

        $response = $this->sendLoginRequest($token);

        $this->response($response);
    }

    public function sendLoginRequest($token)
    {
        $params = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'auth', 'token', 'login'
        ];
        return Request::instance()->setAddress($address)->setParams($params)->getResponse()->asObject();
    }

    public function machines()
    {
        $token = $this->getUserTokenFromClientId();
        $response = $this->sendMachinesRequest($token);
        $this->response($response);
    }

    public function sendMachinesRequest($token)
    {
        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'machine', 'index'
        ];
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function machine()
    {
        $id = autovm_get_query('id');
        $token = $this->getUserTokenFromClientId();
        $response = $this->sendMachineRequest($token, $id);
        $this->response($response);
    }

    public function sendMachineRequest($token, $id)
    {
        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'machine', 'show', $id
        ];
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function detail()
    {
        $id = autovm_get_query('id');
        $token = $this->getUserTokenFromClientId();
        $response = $this->sendDetailRequest($token, $id);
        $this->response($response);
    }

    public function sendDetailRequest($token, $id)
    {
        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'machine', 'detail', $id
        ];
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function create()
    {
        $params = autovm_get_post_array(['productId', 'templateId', 'publicKey', 'name']);
        $token = $this->getUserTokenFromClientId();
        $response = $this->sendCreateRequest($token, $params);
        $this->response($response);
    }

    public function sendCreateRequest($token, $params)
    {
        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'machine', 'create'
        ];
        return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
    }

    public function setup()
    {
        $id = autovm_get_query('id');
        $token = $this->getUserTokenFromClientId();
        $response = $this->sendSetupRequest($token, $id);
        $this->response($response);
    }

    public function sendSetupRequest($token, $id)
    {
        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'machine', 'setup', $id
        ];
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function change()
    {
        $id = autovm_get_query('id');
        $params = autovm_get_post_array(['templateId']);
        $token = $this->getUserTokenFromClientId();
        $response = $this->sendChangeRequest($token, $id, $params);
        $this->response($response);
    }

    public function sendChangeRequest($token, $id, $params)
    {
        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'machine', 'change', $id
        ];
        return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
    }

    public function start()
    {
        $id = autovm_get_query('id');
        $token = $this->getUserTokenFromClientId();
        $response = $this->sendStartRequest($token, $id);
        $this->response($response);
    }

    public function sendStartRequest($token, $id)
    {
        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'machine', 'start', $id
        ];
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function stop()
    {
        $id = autovm_get_query('id');
        $token = $this->getUserTokenFromClientId();
        $response = $this->sendStopRequest($token, $id);
        $this->response($response);
    }

    public function sendStopRequest($token, $id)
    {
        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'machine', 'stop', $id
        ];
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function reboot()
    {
        $id = autovm_get_query('id');
        $token = $this->getUserTokenFromClientId();
        $response = $this->sendRebootRequest($token, $id);
        $this->response($response);
    }

    public function sendRebootRequest($token, $id)
    {
        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'machine', 'reboot', $id
        ];
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function snapshot()
    {
        $id = autovm_get_query('id');
        $token = $this->getUserTokenFromClientId();
        $response = $this->sendSnapshotRequest($token, $id);
        $this->response($response);
    }

    public function sendSnapshotRequest($token, $id)
    {
        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'machine', 'snapshot', $id
        ];
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function revert()
    {
        $id = autovm_get_query('id');
        $token = $this->getUserTokenFromClientId();
        $response = $this->sendRevertRequest($token, $id);
        $this->response($response);
    }

    public function sendRevertRequest($token, $id)
    {
        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'machine', 'revert', $id
        ];
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function console()
    {
        $id = autovm_get_query('id');
        $token = $this->getUserTokenFromClientId();
        $response = $this->sendConsoleRequest($token, $id);
        $this->response($response);
    }

    public function sendConsoleRequest($token, $id)
    {
        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'machine', 'console', $id
        ];
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function destroy()
    {
        $id = autovm_get_query('id');
        $token = $this->getUserTokenFromClientId();
        $response = $this->sendDestroyRequest($token, $id);
        $this->response($response);
    }

    public function sendDestroyRequest($token, $id)
    {
        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'machine', 'destroy', $id
        ];
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function expenses()
    {
        $id = autovm_get_query('id');
        $token = $this->getUserTokenFromClientId();
        $response = $this->sendExpensesRequest($token, $id);
        $this->response($response);
    }

    public function sendExpensesRequest($token, $id)
    {
        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'graph', 'machine', 'expenses', $id
        ];
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function currentTrafficUsage()
    {
        $id = autovm_get_query('id');
        $token = $this->getUserTokenFromClientId();
        $response = $this->sendCurrentTrafficUsageRequest($token, $id);
        $this->response($response);
    }

    public function sendCurrentTrafficUsageRequest($token, $id)
    {
        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'graph', 'machine', $id, 'traffic', 'current'
        ];
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function memoryUsage()
    {
        $id = autovm_get_query('id');
        $token = $this->getUserTokenFromClientId();
        $response = $this->sendMemoryUsageRequest($token, $id);
        $this->response($response);
    }

    public function sendMemoryUsageRequest($token, $id)
    {
        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'graph', 'machine', $id, 'memory', 'daily'
        ];
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function cpuUsage()
    {
        $id = autovm_get_query('id');
        $token = $this->getUserTokenFromClientId();
        $response = $this->sendCpuUsageRequest($token, $id);
        $this->response($response);
    }

    public function sendCpuUsageRequest($token, $id)
    {
        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'graph', 'machine', $id, 'cpu', 'daily'
        ];
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function bandwidthUsage()
    {
        $id = autovm_get_query('id');

        $token = $this->getUserTokenFromClientId();

        $response = $this->sendBandwidthUsageRequest($token, $id);

        $this->response($response);
    }

    public function sendBandwidthUsageRequest($token, $id)
    {
        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'graph', 'machine', $id, 'bandwidth', 'current'
        ];
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function regions()
    {
        $response = $this->sendRegionsRequest();
        $this->response($response);
    }

    public function sendRegionsRequest()
    {
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'common', 'regions'
        ];
        return Request::instance()->setAddress($address)->getResponse()->asObject();
    }

    public function products()
    {
        $regionId = autovm_get_query('id');
        $response = $this->sendProductsRequest($regionId);
        $this->response($response);
    }

    public function sendProductsRequest($regionId)
    {
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'common', 'products', $regionId
        ];
        return Request::instance()->setAddress($address)->getResponse()->asObject();
    }

    public function templates()
    {
        $response = $this->sendTemplatesRequest();
        $this->response($response);
    }

    public function sendTemplatesRequest()
    {
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'common', 'templates'
        ];
        return Request::instance()->setAddress($address)->getResponse()->asObject();
    }

    public function categories()
    {
        $response = $this->sendCategoriesRequest();
        $this->response($response);
    }

    public function sendCategoriesRequest()
    {
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'frontend', 'common', 'template', 'categories'
        ];
        return Request::instance()->setAddress($address)->getResponse()->asObject();
    }

    public function getUserTokenFromClientId()
    {
        $params = [
            'userId' => $this->clientId
        ];
        $user = Capsule::selectOne('SELECT token FROM autovm_user WHERE user_id = :userId', $params);
        if ($user) {
            return current($user);
        }
        return $user;
    }

    public function response($response)
    {
        header('Content-Type: application/json');
        $response = json_encode($response);
        exit($response);
    }

    public function handle($action)
    {
        $class = new ReflectionClass($this);
        $method = $class->getMethod($action);
        if ($method) {
            return $method->invoke($this);
        }
    }

    public function loadCredit()
    {
        $clientId = $this->clientId;
        $command = 'GetClientsDetails';
        $postData = array(
            'clientid' => $clientId,
            'stats' => true,
        );
        
        $results = localAPI($command, $postData);

        if($results['result'] == "success"){
            $credit = $results['credit'];
            $currency = $results['currency_code'];
            $userCurrencyId = $results['currency'];
            $response = array(
                'credit' => $credit,
                'currency' => $currency,
                'userCurrencyId' => $userCurrencyId,
            );
            $this->response($response); 
        } else {
            $this->response(null);
        } 
    }

    public function ChargeCloudAccount()
    {
        // Extract request params
        $data = json_decode( file_get_contents('php://input'), true);

        // Find amount
        $whmcs = autovm_get_array('whmcs', $data);

        if (!$whmcs) {
            return $this->response(['message' => 'You should enter charge amount']);
        }

        // Find amount
        $autovm = autovm_get_array('autovm', $data);

        if (!$autovm) {
            return $this->response(['message' => 'You should enter charge amount']);
        }

        // Find AutoVM user
        $token = $this->getUserTokenFromClientId();

        $response = $this->sendLoginRequest($token);

        $success = property_exists($response, 'data');

        if (!$success) {
            return $this->response(['message' => 'Could not send login request']);
        }

        $user = $response->data;

        // Create invoice
        $currentDate = date('Y-m-d');

        $params = [
            'userid' => $this->clientId,
            'itemdescription1' => 'Charge Cloud Account',
            'itemamount1' => $whmcs,
            'date' => $currentDate];

        $response = localAPI('CreateInvoice', $params);

        // Find invoice ID
        $invoiceId = autovm_get_array('invoiceid', $response);

        if (!$invoiceId) {
            return $this->response(['message' => 'Could not create invoice']);
        }

        // Apply credit
        $params = [
            'invoiceid' => $invoiceId,
            'amount' => $whmcs];

        $response = localAPI('ApplyCredit', $params);

        // Find status
        $status = autovm_get_array('result', $response);

        if ($status <> 'success') {
            return $this->response(['message' => 'Could not apply credit to the invoice']);
        }

        // Charge AutoVM user
        $response = $this->sendChargeCloudRequest($this->AdminToken, $user->id, $autovm);

        $success = property_exists($response, 'data');

        if (!$success) {
            return $this->response(['message' => 'Could not charge account']);
        }

        return $this->response(['success' => true]);
    }

    public function CreateUnpaidInvoice()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);
        if($requestData['chargeamount']){
            $chargeamount = $requestData['chargeamount'];
        } else {
            echo 'can not access charge amount (E01-Create Invoice)';
        }

        $clientId = $this->clientId;
        $currentDateTime = date('Y-m-d');
        $nextDay = date('Y-m-d', strtotime($currentDateTime . ' +1 day'));
        
        if(isset($chargeamount) && isset($clientId)){
            $command = 'CreateInvoice';
            $postData = array(
                'userid' => $clientId,
                'taxrate' => '0',
                'date' => $currentDateTime,
                'duedate' => $nextDay,
                'itemdescription1' => 'Charge Cloud Account',
                'itemamount1' => $chargeamount,
                'itemtaxed1' => '0',
                'notes' => 'This is an auto created invoice. If it has yet been unpaid, you should check it with Client Cloud Account and if Transaction has down successfully, then force customer to pay this invoice',
                'autoapplycredit' => '0',
            );
            $results = localAPI($command, $postData);
            $this->response($results); 
        } 
    }

    public function markCancelInvoice()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);
        if($requestData['invoiceid']){
            $invoiceid = $requestData['invoiceid'];
        } else {
            echo 'Can not access Invoice Id (E02-Mark Cancel)';
        }

        $clientId = $this->clientId;
        $currentDateTime = date('Y-m-d');

        $command = 'UpdateInvoice';
            $postData = array(
                'invoiceid' => $invoiceid,
                'status' => 'Cancelled',
                'date' => $currentDateTime,
                'notes' => 'This invoice created automatically to charge Cloud Balance, but we have error in Autovm Api request, so this invoice cancelled automatically, it means that the cloud balance did not charged',
            );
            $results = localAPI($command, $postData);
            $this->response($results); 
    }

    // Deprecated
    protected function chargeCloud()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);

        if($requestData['id']){
            $userId = $requestData['id'];
        } else {
            echo 'can not access user id (E03-Charge Cloud)';
        }
        
        if($requestData['chargeamount']){
            $chargeamount = $requestData['chargeamount'];
        } else {
            echo 'can not access charge amount (E03-Charge Cloud)';
        }

        $token = $this->AdminToken;;
    
        $response = $this->sendChargeCloudRequest($token, $userId, $chargeamount);
        $this->response($response);
    }
    
    public function sendChargeCloudRequest($token, $userId, $amount)
    {
        $params = [
            'userId' => $userId,
            'amount' => $amount,
            'type' => 'balance',
            'status' => 'paid'
        ];

        $headers = ['token' => $token];
        $BackendUrl = $this->BackendUrl;
        $address = [
            $BackendUrl, 'candy', 'backend', 'trans', 'create'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
    }

    public function applyTheCredit()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);
        if($requestData['invoiceid']){
            $invoiceid = $requestData['invoiceid'];
        } else {
            echo 'can not access user id (E04-Apply Credit)';
        }
        
        if($requestData['chargeamount']){
            $chargeamount = $requestData['chargeamount'];
        } else {
            echo 'can not access charge amount (E04-Apply Credit)';
        }

        if(isset($chargeamount) && isset($invoiceid)){
            $command = 'ApplyCredit';
            $postData = array(
                'invoiceid' => $invoiceid,
                'amount' => $chargeamount,
            );

            $results = localAPI($command, $postData);
            $this->response($results); 
        } 
    }  
    
    public function getAllCurrencies()
    {
        $command = 'GetCurrencies';
        $postData = array(
        );

        $results = localAPI($command, $postData);
        $this->response($results); 

    }
    
    public function getConsoleRoute()
    {
        $response =  autovm_get_config_cloud();
        if(!empty($response['error'])){
            echo($response['error']);
            return false;
        }

        if(!empty($response['message'])){
            echo($response['message']);
            return false;
        }
        
        if(isset($response['ConsoleRoute'])){
            $ConsoleRoute = $response['ConsoleRoute'];
        } else {
            echo('please enter the console link in module configuration');
        }

        $this->response($ConsoleRoute); 
    }

    public function readDecimals($option)
    {
        switch($option){
            case "option1":
                return 0;
            case "option2":
                return 1;
            case "option3":
                return 2;
            default:
                return 0;
        }
    }
    
    public function getModuleConfig()
    {
        $response =  autovm_get_config_cloud();
        
        if(!empty($response['error'])){
            return $response['error'];
        }

        if(!empty($response['message'])){
            return $response['message'];
        }
        
        $requiredKeys = [
            'AutovmDefaultCurrencyID',
            'AutovmDefaultCurrencySymbol',
            'PlaceCurrencySymbol',
            'ShowExchange',
            'ChargeModuleEnable',
            'ConsoleRoute',
            'TopupLink',
            'AdminUserSummeryPagePath',
            'minimumChargeInAutovmCurrency',
            'DefaultMonthlyDecimal',
            'DefaultHourlyDecimal',
            'DefaultBalanceDecimalWhmcs',
            'DefaultBalanceDecimalCloud',
            'DefaultChargeAmountDecimalWhmcs',
            'DefaultChargeAmountDecimalCloud',
            'DefaultCreditDecimalWhmcs',
            'DefaultCreditDecimalCloud',
            'DefaultMinimumDecimalWhmcs',
            'DefaultMinimumDecimalCloud',
            'DefaultRatioDecimal'
        ];
        
        $config = [];
        
        foreach ($requiredKeys as $key) {
            if (isset($response[$key])) {
                if ($key == 'DefaultMonthlyDecimal' || $key == 'DefaultHourlyDecimal' || $key == 'DefaultBalanceDecimalWhmcs' || $key == 'DefaultBalanceDecimalCloud' || $key == 'DefaultChargeAmountDecimalWhmcs' || $key == 'DefaultChargeAmountDecimalCloud' || $key == 'DefaultCreditDecimalWhmcs' || $key == 'DefaultCreditDecimalCloud' || $key == 'DefaultMinimumDecimalWhmcs' || $key == 'DefaultMinimumDecimalCloud' || $key == 'DefaultRatioDecimal') {
                    $config[$key] = $this->readDecimals($response[$key]);
                } else if($key == 'ShowExchange'){
                    if($response['ShowExchange'] == 'option1'){
                        $config[$key] = 'on';
                    } else {
                        $config[$key] = 'off';
                    }
                } else if($key == 'ChargeModuleEnable'){
                    if($response['ChargeModuleEnable'] == 'option1'){
                        $config[$key] = 'on';
                    } else {
                        $config[$key] = 'off';
                    }
                } else if($key == 'PlaceCurrencySymbol'){
                    if($response['PlaceCurrencySymbol'] == 'option1'){
                        $config[$key] = 'code';
                    } else if($response['PlaceCurrencySymbol'] == 'option2'){
                        $config[$key] = 'suffix';
                    } else {
                        $config[$key] = 'prefix';
                    }
                } else {
                    $config[$key] = $response[$key];                
                }
            } else {
                $text = "$key is lost";
                $this->response($text); 
            }
        }



        

        $this->response($config); 
        
    }
    
}

<?php

use WHMCS\Database\Capsule;

function product_MetaData()
{
    return ['DisplayName' => 'AutoVM Product'];
}

function product_ConfigOptions()
{
    $controller = new AVMController(null);

    // Send request
    $response = $controller->sendPoolsRequest();

    if (empty($response)) {

        return []; // We dont need to log anything here
    }

    $message = property_exists($response, 'message');

    if ($message) {

        return []; // We dont need to log anything here
    }

    $listOfPools = []; // Use this to show dropdown

    foreach ($response->data as $data) {
        if($data->status == "active"){
            $listOfPools[$data->id] = $data->name;
        }
    }

    
    return [
        'poolId' => ['FriendlyName' => 'Pool', 'Type' => 'dropdown', 'Options' => $listOfPools], 
        'memorySize' => ['FriendlyName' => 'Memory MB', 'Type' => 'text'], 
        'diskSize' => ['FriendlyName' => 'Disk GB', 'Type' => 'text'], 
        'cpuCore' => ['FriendlyName' => 'Core', 'Type' => 'text'], 
        'memoryLimit' => ['FriendlyName' => 'Memory Limit MB', 'Type' => 'text'], 
        'cpuLimit' => ['FriendlyName' => 'CPU Limit MHZ', 'Type' => 'text'], 
        'bandwidth' => ['FriendlyName' => 'deprecated1', 'Type' => 'text'], 
        'bandwidthTx' => ['FriendlyName' => 'deprecated2', 'Type' => 'text'], 
        'bandwidthRx' => ['FriendlyName' => 'deprecated3', 'Type' => 'text'], 
        'bandwidthDay' => ['FriendlyName' => 'deprecated4', 'Type' => 'text'],
        'traffic' => ['FriendlyName' => 'Traffic GB', 'Type' => 'text']
    ];

}

function product_find_template_identity($name)
{
    $controller = new AVMController(null);

    // Send request
    $response = $controller->sendTemplatesRequest();

    if (empty($response)) {

        return null; // We dont need to log anything here
    }

    $message = property_exists($response, 'message');

    if ($message) {

        return null; // We dont need to log anything here
    }

    $templateId = null;

    foreach ($response->data as $template) {

        if ($template->name == $name) $templateId = $template->id;
    }

    return $templateId;
}

function product_CreateAccount($params)
{
    $name = autovm_get_array('domain', $params);

    if (empty($name)) {

        $name = autovm_generate_string();
    }

    $client = autovm_get_array('clientsdetails', $params);

    if (empty($client)) {

        return 'Could not find client';
    }

    $email = autovm_get_array('email', $client);

    if (empty($email)) {

        return 'Could not find email';
    }

    $phone = autovm_get_array('phonenumber', $client);

    if (empty($phone)) {

        // Its not required
    }

    $service = autovm_get_array('model', $params);

    if (empty($service)) {

        return 'Could not find service';
    }

    $controller = new AVMController($service->id);

    // Find the machine identity
    $machineId = $controller->getMachineIdFromService();

    if ($machineId) {

        return 'Machine is already created';
    }

    $options = autovm_get_array('configoptions', $params);

    if (empty($options)) {

        return 'Could not find any options';
    }

     // Find the IP Verion
     $ipv = autovm_get_array('ipv', $options);

     if (empty($ipv)) {
         $ipv = 'ipv4';
     }
 
     if($ipv == 'ipv4'){
         $ipv4 = 1;
         $ipv6 = null;
     } else if($ipv == 'ipv6'){
         $ipv4 = null;
         $ipv6 = 1;
     } else if($ipv == 'both'){
         $ipv4 = 1;
         $ipv6 = 1;
     } else {
         $ipv4 = 1;
         $ipv6 = null;
     }


    // Find the template name
    $templateName = autovm_get_array('template', $options);

    if (empty($templateName)) {

        return 'Could not find the template name';
    }

    // Find the template identity
    $templateId = product_find_template_identity($templateName);

    if (empty($templateId)) {

        return 'Could not find the template identity';
    }

    // Find the pool identity
    $poolId = autovm_get_array('configoption1', $params);

    if (empty($poolId)) {

        return 'Could not find the pool identity';
    }

    // Find memory size
    $memorySize = autovm_get_array('configoption2', $params);

    if (empty($memorySize)) {

        return 'Could not find memory size';
    }

    // Find memory size
    $extraMemorySize = autovm_get_array('memory', $options);

    if (is_numeric($extraMemorySize)) {

        $memorySize = ($memorySize + $extraMemorySize);
    }

    // Find disk size
    $diskSize = autovm_get_array('configoption3', $params);

    if (empty($diskSize)) {

        return 'Could not find disk size';
    }

    // Find disk size
    $extraDiskSize = autovm_get_array('disk', $options);

    if (is_numeric($extraDiskSize)) {

        $diskSize = ($diskSize + $extraDiskSize);
    }

    // Find cpu core
    $cpuCore = autovm_get_array('configoption4', $params);

    if (empty($cpuCore)) {

        return 'Could not find cpu core';
    }

    // Find cpu core
    $extraCpuCore = autovm_get_array('cpu', $options);

    if (is_numeric($extraCpuCore)) {

        $cpuCore = ($cpuCore + $extraCpuCore);
    }

    // Find memory limit
    $memoryLimit = autovm_get_array('configoption5', $params);

    if (empty($memoryLimit)) {

        // Its not required
    }

    // Find memory limit
    $extraMemoryLimit = autovm_get_array('memoryLimit', $options);

    if (is_numeric($extraMemoryLimit)) {

        $memoryLimit = ($memoryLimit + $extraMemoryLimit);
    }

    // Find cpu limit
    $cpuLimit = autovm_get_array('configoption6', $params);

    if (empty($cpuLimit)) {

        // Its not required
    }

    // Find cpu limit
    $extraCpuLimit = autovm_get_array('cpuLimit', $options);

    if (is_numeric($extraCpuLimit)) {

        $cpuLimit = ($cpuLimit + $extraCpuLimit);
    }

    // Traffic
    $traffic = autovm_get_array('configoption11', $params);

    if (empty($traffic)) {
        
        // Its not required
    }

    // Remaining
    $remaining = $controller->getServiceRemaining();

    if (empty($remaining)) {

        // Its not required
    }

    // Duration
    $duration = $controller->getServiceDuration();

    if (empty($duration)) {

        return 'Could not find duration';
    }

    // Months
    $months = floor($duration/30);

    // Traffic
    if ($traffic) {
        $traffic = ($traffic * $months);
    }

    // Custom fields
    $customFields = autovm_get_array('customfields', $params);

    if (empty($customFields)) {

        // Its not required
    }

    // Find public key
    $publicKey = autovm_get_array('SSH', $customFields);

    if (empty($publicKey)) {

        // Its not required
    }

    // Send request
    $response = $controller->sendCreateRequest($poolId, $templateId, $memorySize, $memoryLimit, $diskSize, $cpuCore, $cpuLimit, $name, $email, $publicKey, $ipv4, $ipv6, $phone);

    if (empty($response)) {

        return 'Could not get response';
    }

    $message = property_exists($response, 'message');

    if ($message) {
        return $response->message;
    }
 
    // Machine details
    $machine = $response->data;

    // Add traffic to machine
    if ($traffic) {

        sleep(1); // Wait one second
        
        $trafficResponse = $controller->sendTrafficRequest($machine->id, $traffic, $remaining, $duration, 'main');

        if (empty($trafficResponse)) {
            return 'Could not create traffic';
        }

        $message = property_exists($trafficResponse, 'message');

        if ($message) {
            return $trafficResponse->message;
        }
    }

    // Add machine to service
    $params = [
        'order_id' => $service->id, 'machine_id' => $machine->id
    ];

    Capsule::table('autovm_order')
        ->insert($params);

    # IP address    
    list($reserve, $address) = [$machine->reserve, null];

    if ($reserve) {
        $address = $reserve->address->address;
    }

    // Update service
    $params = ['dedicatedip' => $address, 'domain' => $name];

    Capsule::table('tblhosting')
        ->whereId($service->id)
        ->update($params);

    return 'success';
}

function product_Renew($params)
{
    // Find service
    $service = autovm_get_array('model', $params);

    if (!$service) {
        return 'Could not find service';
    }

    $controller = new AVMController($service->id);

    // Can refresh traffic
    $canRefresh = $controller->canRefreshTraffic();

    if (!$canRefresh)
        return 'success';

    // Find machine
    $machineId = $controller->getMachineIdFromService();

    if (!$machineId) {
        return 'Could not find machine';
    }

    // Traffic
    $traffic = autovm_get_array('configoption11', $params);

    if (!$traffic)
        return 'success';

    // Remaining
    $remaining = $controller->getServiceRemaining();

    if (!$remaining) {
        // Its not required
    }

    // Duration
    $duration = $controller->getServiceDuration();

    if (!$duration) {
        // Its not required
    }

    // Calculate traffic
    if ($duration) {
        $traffic *= floor($duration/31);
    }

    // Create traffic
    $response = $controller->sendTrafficRequest($machineId, $traffic, $remaining, $remaining, 'refresh');

    if (empty($response)) {
        return 'Could not create traffic';
    }

    $message = property_exists($response, 'message');

    if ($message) {
        return $response->message;
    }

    return 'success';
}

function product_SuspendAccount($params)
{
    $service = autovm_get_array('model', $params);

    if (empty($service)) {

        return 'Could not find service';
    }

    $controller = new AVMController($service->id);

    // Find the machine identity
    $machineId = $controller->getMachineIdFromService();

    if (empty($machineId)) {

        return 'Could not find the machine identity';
    }

    // Send request
    $response = $controller->sendForceSuspendRequest($machineId);

    if (empty($response)) {

        return 'Could not get response';
    }

    $message = property_exists($response, 'message');

    if ($message) {
        return $response->message;
    }

    return 'success';
}

function product_UnsuspendAccount($params)
{
    $service = autovm_get_array('model', $params);

    if (empty($service)) {

        return 'Could not find service';
    }

    $controller = new AVMController($service->id);

    // Find the machine identity
    $machineId = $controller->getMachineIdFromService();

    if (empty($machineId)) {

        return 'Could not find the machine identity';
    }

    // Send request
    $response = $controller->sendForceUnsuspendRequest($machineId);

    if (empty($response)) {

        return 'Could not get response';
    }

    $message = property_exists($response, 'message');

    if ($message) {
        return $response->message;
    }

    return 'success';
}

function product_TerminateAccount($params)
{
    $service = autovm_get_array('model', $params);

    if (empty($service)) {

        return 'Could not find service';
    }

    $controller = new AVMController($service->id);

    // Find the machine identity
    $machineId = $controller->getMachineIdFromService();

    if (empty($machineId)) {

        return 'Could not find the machine identity';
    }

    // Send request
    $response = $controller->sendForceDestroyRequest($machineId);

    if (empty($response)) {

        return 'Could not get response';
    }

    $message = property_exists($response, 'message');

    if ($message) {
        return $response->message;
    }

    return 'success';
}

function product_log_request($action, $request = [], $response = [], $processed = [], $replace = [])
{
    $request = serialize($request);
    $response = serialize($response);
    $processed = serialize($processed);

    logModuleCall('AutoVM', $action, $request, $response, $processed, $replace);
}

function product_ChangePackage($params)
{
    $service = autovm_get_array('model', $params);

    if (empty($service)) {

        return 'Could not find service';
    }

    $controller = new AVMController($service->id);

    // Find the machine identity
    $machineId = $controller->getMachineIdFromService();

    if (empty($machineId)) {

        return 'Could not find the machine identity';
    }

    $options = autovm_get_array('configoptions', $params);

    if (empty($options)) {

        // Its not required
    }

    // Find memory size
    $memorySize = autovm_get_array('configoption2', $params);

    if (empty($memorySize)) {

        return 'Could not find memory size';
    }

    // Find memory size
    $extraMemorySize = autovm_get_array('memory', $options);

    if (is_numeric($extraMemorySize)) {

        $memorySize = ($memorySize + $extraMemorySize);
    }

    // Find disk size
    $diskSize = autovm_get_array('configoption3', $params);

    if (empty($diskSize)) {

        return 'Could not find disk size';
    }

    // Find disk size
    $extraDiskSize = autovm_get_array('disk', $options);

    if (is_numeric($extraDiskSize)) {

        $diskSize = ($diskSize + $extraDiskSize);
    }

    // Find cpu core
    $cpuCore = autovm_get_array('configoption4', $params);

    if (empty($cpuCore)) {

        return 'Could not find cpu core';
    }

    // Find cpu core
    $extraCpuCore = autovm_get_array('cpu', $options);

    if (is_numeric($extraCpuCore)) {

        $cpuCore = ($cpuCore + $extraCpuCore);
    }

    // Find memory limit
    $memoryLimit = autovm_get_array('configoption5', $params);

    if (empty($memoryLimit)) {

        // Its not required
    }

    // Find memory limit
    $extraMemoryLimit = autovm_get_array('memoryLimit', $options);

    if (is_numeric($extraMemoryLimit)) {

        $memoryLimit = ($memoryLimit + $extraMemoryLimit);
    }

    // Find cpu limit
    $cpuLimit = autovm_get_array('configoption6', $params);

    if (empty($cpuLimit)) {

        // Its not required
    }

    // Find cpu limit
    $extraCpuLimit = autovm_get_array('cpuLimit', $options);

    if (is_numeric($extraCpuLimit)) {

        $cpuLimit = ($cpuLimit + $extraCpuLimit);
    }

    // Traffic
    $traffic = autovm_get_array('configoption11', $params);

    if (empty($traffic)) {
        
        // Its not required
    }

    // Send request
    $response = $controller->sendUpgradeRequest($machineId, $memorySize, $memoryLimit, $diskSize, $cpuCore, $cpuLimit, $traffic);

    // Log request
    $request = [
        'machineId' => $machineId,
        'memorySize' => $memorySize,
        'memoryLimit' => $memoryLimit,
        'diskSize' => $diskSize,
        'cpuCore' => $cpuCore,
        'cpuLimit' => $cpuLimit,
        'traffic' => $traffic
    ];

    product_log_request('ChangePackage', $request, $response, $params);
    
    if (empty($response)) {

        return 'Could not get response';
    }

    $message = property_exists($response, 'message');

    if ($message) {
        return $response->message;
    }

    return 'success';
}

function product_update_machine_address($service, $controller, $machineId)
{
    $response = $controller->sendShowRequest($machineId);

    if (!$response) {
        return false; // Could not get response
    }

    $success = property_exists($response, 'data');

    if (!$success) {
        return false; // Could not find machine
    }

    $response = $response->data;

    // Find machine address
    $address = null;

    if ($response->reserve) {
        $address = $response->reserve->address->address;
    }

    if (!$address) return false;

    // Update address
    $params = ['dedicatedip' => $address];

    Capsule::table('tblhosting')
        ->whereId($service->id)
        ->update($params);

    return true;
}

function product_AdminServicesTabFields($params)
{
    $service = autovm_get_array('model', $params);

    if (empty($service)) {

        return []; // We dont need to log anything here
    }

    $controller = new AVMController($service->id);

    // Find the machine identity
    $machineId = $controller->getMachineIdFromService();

    // Update machine address
    if ($machineId) {
        product_update_machine_address($service, $controller, $machineId);
    }
        
    // Show admin form
    ob_start();

    require('admin/form.php');

    $form = ob_get_contents();

    ob_end_clean();

    // Show admin template
    ob_start();

    require('views/admin.php');

    $content = ob_get_contents();

    ob_end_clean();

    return ['AutoVM Form' => $form, 'AutoVM Content' => $content];
}

function product_AdminServicesTabFieldsSave($params)
{
    $service = autovm_get_array('model', $params);

    if (empty($service)) {

        return false; // We dont need to log anything here
    }

    $machineId = autovm_get_post('machineId');

    if (empty($machineId)) {

        return false; // We dont need to log anything here
    }

    $params = [
        'order_id' => $service->id, 'machine_id' => $machineId
    ];

    $order = Capsule::table('autovm_order')
        ->where('order_id', $service->id)
        ->first();

    if (!$order) {
        return false; // Could not find order
    }

    Capsule::table('autovm_order')
        ->where('order_id', $service->id)
        ->update($params);
}

function product_ClientArea($params)
{
    $service = autovm_get_array('model', $params);

    if (empty($service)) {

        return null; // We dont need to log anything here
    }

    $controller = new AVMController($service->id);

    // Find machine identity
    $machineId = $controller->getMachineIdFromService();

    // Update machine address
    if ($machineId) {
        product_update_machine_address($service, $controller, $machineId);
    }
        
    // Find client's details
    $client = autovm_get_array('clientsdetails', $params);

    if (empty($client)) {

        return null; // We dont need to log anything here
    }

    // Update machine's phone
    $phone = autovm_get_array('phonenumber', $client);

    if ($phone) {
        $controller->updateMachinePhone($phone);
    }

    // Show client template
    ob_start();

    require('views/client.php');

    $content = ob_get_contents();

    ob_end_clean();

    return $content;
}

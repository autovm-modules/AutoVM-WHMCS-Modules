<?php

use WHMCS\Database\Capsule;

function traffic_MetaData()
{
    return ['DisplayName' => 'AutoVM Traffic'];
}

function traffic_ConfigOptions()
{
    return ['traffic' => ['FriendlyName' => 'Traffic', 'Type' => 'text'], 'type' => ['FriendlyName' => 'Type', 'Type' => 'dropdown', 'Options' => ['main' => 'Main', 'refresh' => 'Refresh', 'plus' => 'Plus']], 'days' => ['FriendlyName' => 'Days', 'Type' => 'text']];
}

function traffic_create_database()
{
    $hasTable = Capsule::schema()
        ->hasTable('autovm_traffic');

    if ($hasTable) {
        return false; // Table exists
    }

    Capsule::schema()->create('autovm_traffic', function ($table) {

        $table->increments('id');
        $table->string('order_id');
        $table->string('traffic_id');
    });

    return true;
}

function traffic_CreateAccount($params)
{
    // Create traffic table
    traffic_create_database();

    // Find service
    $serviceId = autovm_get_array('serviceid', $params);

    if (empty($serviceId)) {

        return 'Could not find service';
    }

    $controller = new AVMController($serviceId);

    // Find machine
    $machineId = $controller->getMachineIdFromService();

    if (empty($machineId)) {

        return 'Could not find machine';
    }

    $traffic = autovm_get_array('configoption1', $params);

    if (empty($traffic)) {

        return 'Could not find traffic';
    }

    $type = autovm_get_array('configoption2', $params);

    if (empty($type)) {

        return 'Could not find type';
    }

    // Remaining
    $remaining = $controller->getServiceRemaining();

    if (empty($remaining)) {

        // Its not required
    }

    // Duration
    $duration = $controller->getServiceDuration();

    if (empty($duration)) {

        // Its not required
    }

    // Days
    $days = autovm_get_array('configoption3', $params);

    if ($days) {
        $remaining = $duration = $days;
    }

    // Send request
    $response = $controller->sendTrafficRequest($machineId, $traffic, $remaining, $duration, $type);

    if (empty($response)) {

        return 'Could not get response';
    }

    $message = property_exists($response, 'message');

    if ($message) {
        return $response->message;
    }

    $response = $response->data;

    // Find model
    $model = autovm_get_array('model', $params);

    if (!$model) {
        return 'Could not find model';
    }

    // Save traffic
    $params = [
        'order_id' => $model->orderId, 'traffic_id' => $response->id
    ];

    Capsule::table('autovm_traffic')
        ->insert($params);

    // Unsuspend
    $suspended = $controller->getServiceSuspended();

    if ($suspended) {

        $params = ['domainstatus' => 'Active'];

        Capsule::table('tblhosting')
            ->whereId($serviceId)
            ->update($params);
    }

    return 'success';
}

function traffic_TerminateAccount($params)
{
    // Find service
    $serviceId = autovm_get_array('serviceid', $params);

    if (empty($serviceId)) {

        return 'Could not find service';
    }

    $controller = new AVMController($serviceId);

    // Find machine
    $machineId = $controller->getMachineIdFromService();

    if (empty($machineId)) {

        return 'Could not find machine';
    }

    // Find model
    $model = autovm_get_array('model', $params);

    if (!$model) {
        return 'Could not find model';
    }

    // Find order details
    $order = Capsule::table('autovm_traffic')
        ->where('order_id', $model->orderId)
        ->first();

    // Make traffic passive
    $response = $controller->sendTrafficPassiveRequest($order->traffic_id);

    if (!$response) {
        return 'Could not get response';
    }

    $message = property_exists($response, 'message');

    if ($message) {
        return $response->message;
    }

    return true;
}

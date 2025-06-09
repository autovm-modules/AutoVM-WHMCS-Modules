<?php

function buy_resource_MetaData()
{
    return ['DisplayName' => 'AutoVM Buy Resource'];
}

function buy_resource_ConfigOptions()
{
    return ['type' => ['FriendlyName' => 'Type', 'Type' => 'dropdown', 'Options' => ['memorySize' => 'Memory', 'cpuCore' => 'Core', 'diskSize' => 'Disk']], 'value' => ['FriendlyName' => 'Value', 'Type' => 'text']];
}

function buy_resource_CreateAccount($params)
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

    // Find type
    $type = autovm_get_array('configoption1', $params);

    if (empty($type)) {

        return 'Could not find type';
    }

    // Find value
    $value = autovm_get_array('configoption2', $params);

    if (empty($value)) {

        return 'Could not find value';
    }

    // Send request
    $response = $controller->sendScaleRequest($machineId, $type, $value);

    if (empty($response)) {

        return 'Could not get response';
    }

    // Find message
    $message = property_exists($response, 'message');

    if ($message) {
        return $response->message;
    }

    return 'success';
}
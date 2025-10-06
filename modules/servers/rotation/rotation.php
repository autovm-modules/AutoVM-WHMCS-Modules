<?php

function rotation_MetaData()
{
    return ['DisplayName' => 'AutoVM Rotation'];
}

function rotation_CreateAccount($params)
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

    // Send request
    $response = $controller->sendRotationRequest($machineId);

    if (empty($response)) {

        return 'Could not get response';
    }

    $message = property_exists($response, 'message');

    if ($message) {
        return $response->message;
    }

    return 'success';
}
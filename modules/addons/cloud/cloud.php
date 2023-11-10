<?php

$path = dirname(__FILE__);

require $path . '/controller.php';

function cloud_config()
{
    $configarray = array(
        "name" => "AutoVM Cloud",
        "description" => "Cloud Module By AutoVM for WHMCS",
        "version" => "V05.08.05",
        "author" => "AutoVM.net",
    );
    return $configarray;
}

// Show in admin panel in addon menu page
function cloud_output($vars) {

    $version = $vars['version'];
    $text = '<h2> Version : ' . $version . '</h2>';
    echo($text);


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
    
}



function cloud_clientarea()
{
    // Find action
    $action = autovm_get_query('action');

    // Find the current logged in client
    $clientId = autovm_get_session('uid');

    if ($clientId) {

        $controller = new CloudController($clientId);

        return $controller->handle($action);
    }
}
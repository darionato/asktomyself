<?php
// Pull in the NuSOAP code
require_once('../lib/nusoap.php');
// Create the server instance
$server = new soap_server();
// Initialize WSDL support
$server->configureWSDL('askmewsdl', 'urn:askmewsdl');
$server->wsdl->schemaTargetNamespace = 'urn:askmewsdl';

// Register the method to expose
include('header_askme.php');

// Define the method as a PHP function
include('code_askme.php');

// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>

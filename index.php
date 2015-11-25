<?php
require_once 'vendor/restler.php';
require_once 'classes/Transaction.php';

use Luracast\Restler\Restler;

//remove .json from urls of all service methods
Resources::$placeFormatExtensionBeforeDynamicParts = false;

$r = new Restler();
$r->refreshCache();
$r->setSupportedFormats('JsonFormat');

$r->addAPIClass('Transactionservice');
$r->addApiClass('Resources'); //this produces the needed resources.json

$r->handle();
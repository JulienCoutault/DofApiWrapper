<?php

namespace DofApi\Examples;

require_once __DIR__ . '/../inc.php';

$api = new \DofApi\DofApi();

try {
    // Count
    error_log('There are ' . $api->consumablesCount() . ' consumables.');
    error_log('There are ' . $api->consumablescount() . ' consumables.');
    error_log('There are ' . $api->CONSUMABLESCOUNT() . ' consumables.');
    error_log('There are ' . $api->conSUmaBlescounT() . ' consumables.');


    // Get
    $obj = $api->getConsumable(2351);
    $obj = $api->GetcoNsumablE(2351);
    $obj = $api->getConsumable(2351);
    $obj = $api->getconsumable(2351);
    var_dump($obj);

    // Get all
    $objs = $api->getConsumables();
    error_log('There are ' . count($objs = $api->getConsumables()) . ' consumables.');
    error_log('There are ' . count($objs = $api->getconsumables()) . ' consumables.');
    error_log('There are ' . count($objs = $api->GETCONSUMABLES()) . ' consumables.');
    error_log('There are ' . count($objs = $api->GetcoNsumabLEs()) . ' consumables.');

} catch (\DofApi\Exception $e) {
    error_log('An error was occured');
}

?>

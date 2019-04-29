<?php

namespace DofApi\Examples;

require_once __DIR__ . '/../inc.php';

$api = new \DofApi\DofApi();

try {
    echo 'There are ' . $api->equipmentsCount() . ' equipments.';
} catch (\DofApi\Exception $e) {
    echo 'An error was occured';
}


?>

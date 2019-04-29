<?php

namespace DofApi\Examples;

require_once __DIR__ . '/../inc.php';

$api = new \DofApi\DofApi();

try {
    echo 'There are ' . $api->weaponsCount() . ' weapons.';
    echo 'There are ' . $api->weAponscouNt() . ' weapons.';
    echo 'There are ' . $api->weaponscount() . ' weapons.';
    echo 'There are ' . $api->WEAPONSCOUNT() . ' weapons.';
} catch (\DofApi\Exception $e) {
    echo 'An error was occured';
}

?>

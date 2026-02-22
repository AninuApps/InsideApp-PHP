<?php

// Exemplu de utilizare pentru SDK-ul InsideApp
require_once 'vendor/autoload.php';

use AninuApps\InsideApp\InsideApp;

// Creează instanța
$sdk = new InsideApp();

echo "Exemplu SDK InsideApp\n";
echo "====================\n\n";

// Obține versiunea SDK
echo "1. Versiunea SDK: " . $sdk->getVersion() . "\n";

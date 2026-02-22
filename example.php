<?php

// Exemplu de utilizare pentru SDK-ul InsideApp
require_once 'vendor/autoload.php';

use AninuApps\InsideApp\InsideApp;

// Creează instanța
$sdk = new InsideApp();

echo "Exemplu SDK InsideApp\n";
echo "====================\n\n";

// Folosește funcția dummy print
echo "1. Dummy print: ";
$sdk->dummyPrint();
echo "\n";

// Afișează mesaj personalizat
echo "2. Mesaj personalizat: ";
$sdk->printMessage("Salut de la InsideApp!");
echo "\n";

// Obține versiunea SDK
echo "3. Versiunea SDK: " . $sdk->getVersion() . "\n";
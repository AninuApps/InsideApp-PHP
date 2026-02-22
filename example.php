<?php

// Example usage of the InsideApp SDK
require_once 'vendor/autoload.php';

use AninuApps\InsideApp\InsideApp;

// Create instance
$sdk = new InsideApp();

echo "InsideApp SDK Example\n";
echo "=====================\n\n";

// Use dummy print function
echo "1. Dummy print: ";
$sdk->dummyPrint();
echo "\n";

// Print custom message
echo "2. Custom message: ";
$sdk->printMessage("Hello from InsideApp!");
echo "\n";

// Get SDK version
echo "3. SDK Version: " . $sdk->getVersion() . "\n";
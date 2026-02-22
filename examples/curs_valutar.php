<?php

/**
 * Exemplu pentru obținerea cursului valutar
 * Echivalentul metodei curs_valutar() din API-ul original
 */

require_once '../vendor/autoload.php';

use AninuApps\InsideAppPhp\InsideApp;

// Configurare credențiale (înlocuiește cu credențialele tale reale)
$username = 'username_tau_api';  
$password = 'parola_ta_api';

try {
    // Inițializare SDK
    $insideApp = new InsideApp($username, $password);
    
    // Apel API pentru cursul valutar
    $response = $insideApp->cursValutar();
    
    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "Eroare la obținerea cursului valutar: " . $e->getMessage() . "\n";
}
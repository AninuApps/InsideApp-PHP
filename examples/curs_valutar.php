<?php

/**
 * Exemplu pentru obținerea cursului valutar
 * Echivalentul metodei curs_valutar() din API-ul original
 */

require_once '../vendor/autoload.php';

use AninuApps\InsideApp\InsideApp;

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
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "nomenclator/cursvalutar",
     *   "data": {
     *     "output": [
     *       {
     *         "id": "1",
     *         "tag": "RON",
     *         "name": "Leu",
     *         "value": "1"
     *       },
     *       {
     *         "id": "2",
     *         "tag": "EUR",
     *         "name": "Euro",
     *         "value": "5.1033"
     *       },
     *       {
     *         "id": "3",
     *         "tag": "USD",
     *         "name": "Dolar SUA",
     *         "value": "4.6789"
     *       },
     *       {
     *         "id": "4",
     *         "tag": "GBP",
     *         "name": "Lira sterlină",
     *         "value": "5.9234"
     *       },
     *       {
     *         "id": "5",
     *         "tag": "CHF",
     *         "name": "Franc elvețian",
     *         "value": "5.4567"
     *       }
     *     ]
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la obținerea cursului valutar: " . $e->getMessage() . "\n";
}
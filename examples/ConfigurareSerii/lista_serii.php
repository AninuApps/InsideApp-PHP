<?php

/**
 * Exemplu pentru listarea seriilor de facturi
 * Echivalentul metodei serie_lista() din API-ul original
 */

require_once '../../vendor/autoload.php';

use AninuApps\InsideAppPhp\InsideApp;

// Configurare credențiale (înlocuiește cu credențialele tale reale)
$username = 'username_tau_api';  
$password = 'parola_ta_api';
$email = 'email@exemplu.ro';

try {
    // Inițializare SDK
    $insideApp = new InsideApp($username, $password);
    
    // Datele pentru listarea seriilor de facturi
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
    );
    
    // Apel API pentru listarea seriilor de facturi
    $response = $insideApp->serieLista($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "serie/lista",
     *   "data": {
     *     "output": [
     *       {
     *         "id": "3593883533883361388353388",
     *         "proforma": {
     *           "serie": "AHC",
     *           "nr_inceput": 1,
     *           "nr_curent": 228
     *         },
     *         "factura": {
     *           "serie": "ACD",
     *           "nr_inceput": 1,
     *           "nr_curent": 181
     *         },
     *         "chitanta": {
     *           "serie": "AXE",
     *           "nr_inceput": 1,
     *           "nr_curent": 27
     *         }
     *       },
     *       {
     *         "id": "35938835338835b35c8353388",
     *         "proforma": {
     *           "serie": "TA",
     *           "nr_inceput": 1,
     *           "nr_curent": 3
     *         },
     *         "factura": {
     *           "serie": "TC",
     *           "nr_inceput": 1,
     *           "nr_curent": 1
     *         },
     *         "chitanta": {
     *           "serie": "TX",
     *           "nr_inceput": 1,
     *           "nr_curent": 1
     *         }
     *       }
     *     ]
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la listarea seriilor de facturi: " . $e->getMessage() . "\n";
}
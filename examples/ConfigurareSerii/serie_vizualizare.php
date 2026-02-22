<?php

/**
 * Exemplu pentru vizualizarea detaliilor unei serii de facturi
 * Echivalentul metodei serie_vizualizare() din API-ul original
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
    
    // Datele pentru vizualizarea unei serii de facturi
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'id' => '36038935438935b362362389354389',
    );
    
    // Apel API pentru vizualizarea detaliilor seriei de facturi
    $response = $insideApp->serieVizualizare($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "serie/vizualizare",
     *   "data": {
     *     "output": {
     *       "id": "36038935438935b362362389354389",
     *       "proforma": {
     *         "serie": "AX",
     *         "nr_inceput": 2,
     *         "nr_curent": 3,
     *         "design": 2
     *       },
     *       "factura": {
     *         "serie": "BY",
     *         "nr_inceput": 6,
     *         "nr_curent": 7,
     *         "design": 3
     *       },
     *       "chitanta": {
     *         "serie": "CZ",
     *         "nr_inceput": 10,
     *         "nr_curent": 11
     *       },
     *       "logo": ""
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la vizualizarea seriei de facturi: " . $e->getMessage() . "\n";
}
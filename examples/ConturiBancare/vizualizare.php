<?php

/**
 * Exemplu pentru vizualizarea unui cont bancar din nomenclator
 * Echivalentul metodei conturibancare_vizualizare() din API-ul original
 */

require_once '../../vendor/autoload.php';

use AninuApps\InsideApp\InsideApp;

// Configurare credențiale (înlocuiește cu credențialele tale reale)
$username = 'username_tau_api';  
$password = 'parola_ta_api';
$email = 'email@exemplu.ro';

try {
    // Inițializare SDK
    $insideApp = new InsideApp($username, $password);
    
    // Datele pentru vizualizarea contului bancar
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'id' => '352387352387361387352387',
    );
    
    // Apel API pentru vizualizarea contului bancar
    $response = $insideApp->conturiBancareVizualizare($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "conturibancare/vizualizare",
     *   "data": {
     *     "output": {
     *       "id": "352387352387361387352387",
     *       "nume": "Cont ING Bank Test",
     *       "iban": "RO13XXXXXXXXX",
     *       "moneda": "RON",
     *       "swift": "",
     *       "descriere": ""
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la vizualizarea contului bancar: " . $e->getMessage() . "\n";
}

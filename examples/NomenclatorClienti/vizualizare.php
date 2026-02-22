<?php

/**
 * Exemplu pentru vizualizarea unui client din nomenclator
 * Echivalentul metodei clienti_vizualizare() din API-ul original
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
    
    // Datele pentru vizualizarea clientului
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'id' => '36738a35538a35c35d36036038a35538a',
    );
    
    // Apel API pentru vizualizarea clientului
    $response = $insideApp->clientiVizualizare($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "client/lista",
     *   "data": {
     *     "output": {
     *       "id": "36038935438935c35d3619354389",
     *       "tip": "J",
     *       "nume": "test",
     *       "cifcnp": "123456789",
     *       "contact": "",
     *       "email": "",
     *       "telefon": "",
     *       "adresa": {
     *         "tara": "a",
     *         "judet": "b",
     *         "oras": "c"
     *       }
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la vizualizarea clientului: " . $e->getMessage() . "\n";
}

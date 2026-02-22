<?php

/**
 * Exemplu pentru listarea clienților din nomenclator
 * Echivalentul metodei clienti_lista() din API-ul original
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
    
    // Datele pentru listarea clienților
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
    );
    
    // Apel API pentru listarea clienților
    $response = $insideApp->clientiLista($data_iApp);

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
     *     "output": [
     *       {
     *         "id": "36038935438935c35d3619354389",
     *         "tip": "J",
     *         "nume": "test",
     *         "cifcnp": "123456789",
     *         "contact": "",
     *         "email": "",
     *         "telefon": "",
     *         "adresa": {
     *           "tara": "a",
     *           "judet": "b",
     *           "oras": "c"
     *         },
     *         "status": "I"
     *       }
     *     ]
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la listarea clienților: " . $e->getMessage() . "\n";
}

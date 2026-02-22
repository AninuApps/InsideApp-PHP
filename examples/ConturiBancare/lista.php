<?php

/**
 * Exemplu pentru listarea conturilor bancare din nomenclator
 * Echivalentul metodei conturibancare_lista() din API-ul original
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
    
    // Datele pentru listarea conturilor bancare
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
    );
    
    // Apel API pentru listarea conturilor bancare
    $response = $insideApp->conturiBancareLista($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "conturibancare/lista",
     *   "data": {
     *     "output": [
     *       {
     *         "id": "3523873523870387352387",
     *         "nume": "Cont ING",
     *         "iban": "RO25XXXXXXX",
     *         "moneda": "EURO",
     *         "swift": "",
     *         "descriere": ""
     *       },
     *       {
     *         "id": "Cont BCR",
     *         "nume": "CCCC",
     *         "iban": "RO13XXXXXXX",
     *         "moneda": "RON",
     *         "swift": "",
     *         "descriere": ""
     *       }
     *     ]
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la listarea conturilor bancare: " . $e->getMessage() . "\n";
}

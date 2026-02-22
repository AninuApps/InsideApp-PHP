<?php

/**
 * Exemplu pentru listarea produselor/serviciilor din nomenclator
 * Echivalentul metodei produse_lista() din API-ul original
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
    
    // Datele pentru listarea produselor/serviciilor
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
    );
    
    // Apel API pentru listarea produselor/serviciilor
    $response = $insideApp->produseLista($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "produse/lista",
     *   "data": {
     *     "output": [
     *       {
     *         "id": "3593835338835b35e38835338",
     *         "nume": "Servicii online",
     *         "descriere": "",
     *         "um": "buc",
     *         "pret": 100,
     *         "moneda": "RON"
     *       },
     *       {
     *         "id": "360389543895b36036338954389",
     *         "nume": "Dezvoltare XYZ",
     *         "descriere": "o descriere",
     *         "um": "buc",
     *         "pret": 12,
     *         "moneda": "RON"
     *       }
     *     ]
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la listarea produselor/serviciilor: " . $e->getMessage() . "\n";
}

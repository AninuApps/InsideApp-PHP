<?php

/**
 * Exemplu pentru listarea firmelor din contul reseller
 * Echivalentul metodei firma_lista() din API-ul original
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
    
    // Datele pentru listarea firmelor
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        
    );
    
    // Apel API pentru listarea firmelor din contul reseller
    $response = $insideApp->firmaLista($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "firma/lista",
     *   "data": {
     *     "output": [
     *       {
     *         "id": "36038935438935c35d3619354389",
     *         "nume": "TECHNO SOLUTIONS SRL",
     *         "cif": "RO47852369",
     *         "adresa": {
     *           "tara": "Romania",
     *           "judet": "Bucuresti",
     *           "oras": "Sector 1"
     *         },
     *         "status": "A",
     *         "anaf_spv_status": "A"
     *       },
     *       {
     *         "id": "36089343893535d3638935389",
     *         "nume": "DIGITAL INNOVATIONS SRL",
     *         "cif": "RO35678124",
     *         "adresa": {
     *           "tara": "Romania",
     *           "judet": "Cluj",
     *           "oras": "Cluj-Napoca"
     *         },
     *         "status": "I",
     *         "anaf_spv_status": "I"
     *       }
     *     ]
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la listarea firmelor: " . $e->getMessage() . "\n";
}
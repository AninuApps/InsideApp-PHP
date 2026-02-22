<?php

/**
 * Exemplu pentru obținerea informațiilor despre CIF
 * Echivalentul metodei info_cif() din API-ul original
 */

require_once '../vendor/autoload.php';

use AninuApps\InsideAppPhp\InsideApp;

// Configurare credențiale (înlocuiește cu credențialele tale reale)
$username = 'username_tau_api';  
$password = 'parola_ta_api';
$email = 'email@exemplu.ro';

try {
    // Inițializare SDK
    $insideApp = new InsideApp($username, $password);
    
    // Datele pentru verificarea CIF-ului
    $data_iApp = array(
        'email_responsabil' => $email,              // obligatoriu
        'cif' => '49235450',                        // obligatoriu
    );
    
    // Apel API pentru informații CIF
    $response = $insideApp->infoCif($data_iApp);
    
    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "info/cif",
     *   "data": {
     *     "cif": "49235450",
     *     "output": {
     *       "nume": "ANINU APPS S.R.L.",
     *       "cif": "49235450",
     *       "regcom": "J2023004714355",
     *       "euid": "ROONRC.J35/4714/2023",
     *       "tva": "N",
     *       "caen": "6210",
     *       "telefon": "0770846823",
     *       "data_inregistrare": "2023-12-06",
     *       "adresa": {
     *         "tara": "RO",
     *         "judet_cod": "TM",
     *         "judet": "TIMIS",
     *         "oras": "Ghiroda",
     *         "adresa": "Sat Ghiroda, Str BERLIN, Nr. 14",
     *         "completa": "Sat Ghiroda, Str BERLIN, Nr. 14, Cod poștal 307200"
     *       },
     *       "activa": "Y",
     *       "actualizare": "2025-06-23 00:49",
     *       "stare": {
     *         "cod": "1048",
     *         "text": "INREGISTRAT"
     *       }
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la obținerea informațiilor CIF: " . $e->getMessage() . "\n";
}
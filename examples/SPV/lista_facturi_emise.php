<?php

/**
 * Exemplu pentru listarea facturilor emise prin SPV/eFactura
 * Echivalentul metodei eFactura_emise() din API-ul original
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
    
    // Datele pentru listarea facturilor emise prin SPV
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'start' => '2026-01-01',                    // obligatoriu (Y-m-d)
        'end' => date("Y-m-d"),                     // obligatoriu (Y-m-d)

    );
    
    // Apel API pentru listarea facturilor emise prin SPV
    $response = $insideApp->eFacturaEmise($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "e-factura/emise",
     *   "data": {
     *     "perioada": {
     *       "tStart": 1704060000,
     *       "tEnd": 1750712400,
     *       "dStart": "2024-01-01",
     *       "dEnd": "2025-06-24"
     *     },
     *     "raport": [
     *       {
     *         "factura": {
     *           "client_name": "DIGITAL SOLUTIONS SRL",
     *           "client_cif": "RO35678124",
     *           "total": "2500.00 RON"
     *         },
     *         "trimisa_de": "Sistem",
     *         "id_incarcare": 5106148303,
     *         "id_descarcare": 5023971571,
     *         "status": "CONFIRMAT",
     *         "mesaj": "Factura confirmată de beneficiar",
     *         "data_incarcare": "22 Feb 2026 (14:30)",
     *         "data_sync_iapp": "22 Feb 2026 (14:25)"
     *       },
     *       {
     *         "factura": {
     *           "client_name": "INNOVATE TECH SRL",
     *           "client_cif": "RO48756321",
     *           "total": "1850.00 RON"
     *         },
     *         "trimisa_de": "Sistem",
     *         "id_incarcare": 5106154021,
     *         "id_descarcare": 5030068275,
     *         "status": "CONFIRMAT",
     *         "mesaj": "Procesare completă în SPV",
     *         "data_incarcare": "21 Feb 2026 (16:45)",
     *         "data_sync_iapp": "21 Feb 2026 (16:40)"
     *       }
     *     ]
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la listarea facturilor emise prin SPV: " . $e->getMessage() . "\n";
}
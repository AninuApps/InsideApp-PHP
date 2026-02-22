<?php

namespace AninuApps\InsideApp;

/**
 * SDK oficial InsideApp PHP - Gestiune facturi și integrare completă cu SPV
 * 
 * Tot ce ai nevoie pentru facturarea în România:
 * - Emitere facturi proformă, fiscale, chitanțe
 * - Integrare completă ANAF SPV/eFactura automată
 * - Arhivă digitală cu toate facturile din SPV
 * - Gestionare clienți, produse, servicii, conturi bancare
 * - API Reseller: poți gestiona tot procesul de facturare pentru mai multe 
 *   firme direct din aplicația ta
 * 
 * Pentru suport și documentație:
 * - Email: support@iapp.ro
 * - Documentație: https://doc.iapp.ro  
 * - Portal Suport: https://developer.iapp.ro
 * - Referințe API: https://doc.iapp.ro/swagger
 */
class InsideApp
{
    /**
     * @var string Hash pentru autentificare Basic Auth
     */
    private $hash = '';
    
    /**
     * @var string URL-ul de bază al API-ului InsideApp
     */
    private $apiUrl = 'https://api.my.iapp.ro/';
    
    /**
     * @var int Timeout pentru requesturi în secunde
     */
    private $timeout = 300;

    /**
     * Inițializează SDK-ul InsideApp
     *
     * @param string $user Numele de utilizator (email)
     * @param string $password Parola
     * @throws \InvalidArgumentException Dacă credentiațele sunt goale
     */
    public function __construct(string $user, string $password)
    {
        if (empty($user)) {
            throw new \InvalidArgumentException('Username-ul nu poate fi gol');
        }
        if (empty($password)) {
            throw new \InvalidArgumentException('Parola nu poate fi golă');
        }
        
        $this->hash = base64_encode($user . ':' . $password);
    }

    /**
     * Execută un request HTTP către API
     *
     * @param string $endpoint Endpoint-ul API (ex: "emite/factura")
     * @param array $data Datele de trimis în request
     * @param bool $download Dacă să returneze conținutul pentru download
     * @param bool $hasFiles Dacă request-ul conține fișiere
     * @return array|false Răspunsul decodat JSON sau false în caz de eroare
     * @throws \RuntimeException În caz de eroare cURL
     */
    public function execute(string $endpoint, array $data = [], bool $download = false, bool $hasFiles = false)
    {
        if (!function_exists('curl_init')) {
            throw new \RuntimeException('Extensia cURL nu este disponibilă');
        }

        $url = rtrim($this->apiUrl, '/') . '/' . ltrim($endpoint, '/');
        $ch = $this->initCurl($url, $data, $hasFiles);

        if ($download) {
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_NOBODY, false);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErrno = curl_errno($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlErrno > 0) {
            throw new \RuntimeException("Eroare cURL: {$curlError} (Cod: {$curlErrno})");
        }

        return json_decode($response, true);
    }

    /**
     * Inițializează sesiunea cURL
     *
     * @param string $url URL-ul requestului
     * @param array $data Datele de trimis
     * @param bool $hasFiles Dacă requestul conține fișiere
     * @return resource Resursa cURL
     */
    private function initCurl(string $url, array $data, bool $hasFiles = false)
    {
        $headers = ["Authorization: Basic " . $this->hash];
        
        if ($hasFiles) {
            $headers[] = "Content-Type: multipart/form-data";
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $hasFiles ? $data : json_encode($data));
            if (!$hasFiles) {
                $headers[] = "Content-Type: application/json";
            }
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        return $ch;
    }

    /**
     * Obține versiunea SDK-ului
     *
     * @return string Versiunea curentă
     */
    public function getVersion(): string
    {
        return "1.20.0";
    }

    /**
     * Setează timeout-ul pentru requesturi
     *
     * @param int $timeout Timeout în secunde
     * @return self
     * @throws \InvalidArgumentException Dacă timeout-ul este negativ
     */
    public function setTimeout(int $timeout): self
    {
        if ($timeout < 0) {
            throw new \InvalidArgumentException('Timeout-ul nu poate fi negativ');
        }
        $this->timeout = $timeout;
        return $this;
    }

    // ==========================================
    // FACTURI PROFORMĂ
    // ==========================================

    /**
     * Emite o factură proformă
     *
     * @param array $data Datele facturii proformă
     * @return array Răspunsul API-ului
     */
    public function emiteProforma(array $data): array
    {
        return $this->execute("emite/proforma", $data);
    }

    /**
     * Emite o factură proformă (versiunea v2 cu funcționalități extinse)
     *
     * @param array $data Datele facturii proformă
     * @return array Răspunsul API-ului  
     */
    public function emiteProformaV2(array $data): array
    {
        return $this->execute("emite/proforma-v2", $data);
    }

    /**
     * Vizualizează detaliile unei facturi proformă
     *
     * @param array $data Parametrii de căutare (id factura)
     * @return array Detaliile facturii
     */
    public function viewProforma(array $data): array
    {
        return $this->execute("vizualizare/proforma", $data);
    }

    /**
     * Listează facturile proformă cu opțiuni de filtrare
     *
     * @param array $data Parametrii de filtrare
     * @return array Lista facturilor proformă
     */
    public function viewProforme(array $data = []): array
    {
        return $this->execute("vizualizare/proforme", $data);
    }

    /**
     * Anulează o factură proformă
     *
     * @param array $data Parametrii de anulare (id factura)
     * @return array Răspunsul API-ului
     */
    public function cancelProforma(array $data): array
    {
        return $this->execute("anuleaza/proforma", $data);
    }

    /**
     * Convertește o factură proformă în factură fiscală
     *
     * @param array $data Datele pentru conversie
     * @return array Răspunsul API-ului
     */
    public function factureazaProforma(array $data): array
    {
        return $this->execute("factureaza/proforma", $data);
    }

    // ==========================================
    // FACTURI FISCALE
    // ==========================================

    /**
     * Emite o factură fiscală
     *
     * @param array $data Datele facturii fiscale
     * @return array Răspunsul API-ului
     */
    public function emiteFactura(array $data): array
    {
        return $this->execute("emite/factura", $data);
    }

    /**
     * Emite o factură fiscală (versiunea v2 cu funcționalități extinse)
     *
     * @param array $data Datele facturii fiscale
     * @return array Răspunsul API-ului
     */
    public function emiteFacturaV2(array $data): array
    {
        return $this->execute("emite/factura-v2", $data);
    }

    /**
     * Vizualizează detaliile unei facturi fiscale
     *
     * @param array $data Parametrii de căutare (id factura)
     * @return array Detaliile facturii
     */
    public function viewFactura(array $data): array
    {
        return $this->execute("vizualizare/factura", $data);
    }

    /**
     * Listează facturile fiscale cu opțiuni de filtrare
     *
     * @param array $data Parametrii de filtrare
     * @return array Lista facturilor fiscale
     */
    public function viewFacturi(array $data = []): array
    {
        return $this->execute("vizualizare/facturi", $data);
    }

    /**
     * Anulează o factură fiscală
     *
     * @param array $data Parametrii de anulare (id factura)
     * @return array Răspunsul API-ului
     */
    public function cancelFactura(array $data): array
    {
        return $this->execute("anuleaza/factura", $data);
    }

    /**
     * Marchează o factură ca încasată
     *
     * @param array $data Datele despre încasare
     * @return array Răspunsul API-ului
     */
    public function incaseazaFactura(array $data): array
    {
        return $this->execute("incaseaza/factura", $data);
    }

    /**
     * Stornează o factură fiscală
     *
     * @param array $data Parametrii de stornare
     * @return array Răspunsul API-ului
     */
    public function storneazaFactura(array $data): array
    {
        return $this->execute("storneaza/factura", $data);
    }

    // ==========================================
    // CHITANȚE
    // ==========================================

    /**
     * Emite o chitanță
     *
     * @param array $data Datele chitanței
     * @return array Răspunsul API-ului
     */
    public function emiteChitanta(array $data): array
    {
        return $this->execute("emite/chitanta", $data);
    }

    /**
     * Vizualizează detaliile unei chitanțe
     *
     * @param array $data Parametrii de căutare (id chitanta)
     * @return array Detaliile chitanței
     */
    public function viewChitanta(array $data): array
    {
        return $this->execute("vizualizare/chitanta", $data);
    }

    /**
     * Listează chitanțele cu opțiuni de filtrare
     *
     * @param array $data Parametrii de filtrare  
     * @return array Lista chitanțelor
     */
    public function viewChitante(array $data = []): array
    {
        return $this->execute("vizualizare/chitante", $data);
    }

    /**
     * Anulează o chitanță
     *
     * @param array $data Parametrii de anulare (id chitanta)
     * @return array Răspunsul API-ului
     */
    public function anuleazaChitanta(array $data): array
    {
        return $this->execute("anuleaza/chitanta", $data);
    }

    /**
     * Șterge o chitanță
     *
     * @param array $data Parametrii de ștergere (id chitanta)
     * @return array Răspunsul API-ului
     */
    public function stergeChitanta(array $data): array
    {
        return $this->execute("sterge/chitanta", $data);
    }

    // ==========================================
    // ÎNCASĂRI
    // ==========================================

    /**
     * Listează încasările cu opțiuni de filtrare
     *
     * @param array $data Parametrii de filtrare
     * @return array Lista încasărilor
     */
    public function viewIncasari(array $data = []): array
    {
        return $this->execute("vizualizare/incasari", $data);
    }

    /**
     * Vizualizează detaliile unei încasări
     *
     * @param array $data Parametrii de căutare (id incasare)
     * @return array Detaliile încasării
     */
    public function viewIncasare(array $data): array
    {
        return $this->execute("vizualizare/incasare", $data);
    }

    /**
     * Șterge o încasare
     *
     * @param array $data Parametrii de ștergere (id incasare)
     * @return array Răspunsul API-ului
     */
    public function stergeIncasare(array $data): array
    {
        return $this->execute("sterge/incasare", $data);
    }

    // ==========================================
    // NOMENCLATOR CLIENȚI
    // ==========================================

    /**
     * Listează clienții cu opțiuni de filtrare
     *
     * @param array $data Parametrii de filtrare
     * @return array Lista clienților
     */
    public function clientiLista(array $data = []): array
    {
        return $this->execute("clienti/lista", $data);
    }

    /**
     * Vizualizează detaliile unui client
     *
     * @param array $data Parametrii de căutare (id client)
     * @return array Detaliile clientului
     */
    public function clientiVizualizare(array $data): array
    {
        return $this->execute("clienti/vizualizare", $data);
    }

    /**
     * Adaugă un client nou
     *
     * @param array $data Datele clientului nou
     * @return array Răspunsul API-ului
     */
    public function clientiAdauga(array $data): array
    {
        return $this->execute("clienti/adauga", $data);
    }

    /**
     * Modifică datele unui client existent
     *
     * @param array $data Datele actualizate ale clientului
     * @return array Răspunsul API-ului
     */
    public function clientiModifica(array $data): array
    {
        return $this->execute("clienti/modifica", $data);
    }

    /**
     * Șterge un client
     *
     * @param array $data Parametrii de ștergere (id client)
     * @return array Răspunsul API-ului
     */
    public function clientiSterge(array $data): array
    {
        return $this->execute("clienti/sterge", $data);
    }

    // ==========================================
    // NOMENCLATOR PRODUSE ȘI SERVICII
    // ==========================================

    /**
     * Listează produsele și serviciile cu opțiuni de filtrare
     *
     * @param array $data Parametrii de filtrare
     * @return array Lista produselor și serviciilor
     */
    public function produseLista(array $data = []): array
    {
        return $this->execute("produse/lista", $data);
    }

    /**
     * Vizualizează detaliile unui produs sau serviciu
     *
     * @param array $data Parametrii de căutare (id produs)
     * @return array Detaliile produsului
     */
    public function produseVizualizare(array $data): array
    {
        return $this->execute("produse/vizualizare", $data);
    }

    /**
     * Adaugă un produs sau serviciu nou
     *
     * @param array $data Datele produsului nou
     * @return array Răspunsul API-ului
     */
    public function produseAdauga(array $data): array
    {
        return $this->execute("produse/adauga", $data);
    }

    /**
     * Modifică datele unui produs sau serviciu existent
     *
     * @param array $data Datele actualizate ale produsului
     * @return array Răspunsul API-ului
     */
    public function produseModifica(array $data): array
    {
        return $this->execute("produse/modifica", $data);
    }

    /**
     * Șterge un produs sau serviciu
     *
     * @param array $data Parametrii de ștergere (id produs)
     * @return array Răspunsul API-ului
     */
    public function produseSterge(array $data): array
    {
        return $this->execute("produse/sterge", $data);
    }

    // ==========================================
    // CONFIGURARE SERII FACTURI
    // ==========================================

    /**
     * Listează seriile de facturi configurate
     *
     * @param array $data Parametrii de filtrare
     * @return array Lista seriilor
     */
    public function serieLista(array $data = []): array
    {
        return $this->execute("serie/lista", $data);
    }

    /**
     * Vizualizează detaliile unei serii de facturi
     *
     * @param array $data Parametrii de căutare (id serie)
     * @return array Detaliile seriei
     */
    public function serieVizualizare(array $data): array
    {
        return $this->execute("serie/vizualizare", $data);
    }

    /**
     * Obține opțiunile disponibile de design pentru facturi
     *
     * @param array $data Parametrii opționali
     * @return array Opțiunile de design
     */
    public function serieDesign(array $data = []): array
    {
        return $this->execute("serie/design", $data);
    }

    /**
     * Adaugă o serie nouă de facturi
     *
     * @param array $data Datele seriei noi (poate conține fișiere logo)
     * @return array Răspunsul API-ului
     */
    public function serieAdauga(array $data): array
    {
        return $this->execute("serie/adauga", $data, false, true);
    }

    /**
     * Modifică o serie existentă de facturi
     *
     * @param array $data Datele actualizate (poate conține fișiere logo)
     * @return array Răspunsul API-ului
     */
    public function serieModifica(array $data): array
    {
        return $this->execute("serie/modifica", $data, false, true);
    }

    /**
     * Șterge o serie de facturi
     *
     * @param array $data Parametrii de ștergere (id serie)
     * @return array Răspunsul API-ului
     */
    public function serieSterge(array $data): array
    {
        return $this->execute("serie/sterge", $data);
    }

    /**
     * Șterge logo-ul unei serii de facturi
     *
     * @param array $data Parametrii (id serie)
     * @return array Răspunsul API-ului
     */
    public function serieStergeLogo(array $data): array
    {
        return $this->execute("serie/sterge-logo", $data);
    }

    // ==========================================
    // CONTURI BANCARE
    // ==========================================

    /**
     * Listează conturile bancare cu opțiuni de filtrare
     *
     * @param array $data Parametrii de filtrare
     * @return array Lista conturilor bancare
     */
    public function conturiBancareLista(array $data = []): array
    {
        return $this->execute("conturibancare/lista", $data);
    }

    /**
     * Vizualizează detaliile unui cont bancar
     *
     * @param array $data Parametrii de căutare (id cont)
     * @return array Detaliile contului
     */
    public function conturiBancareVizualizare(array $data): array
    {
        return $this->execute("conturibancare/vizualizare", $data);
    }

    /**
     * Adaugă un cont bancar nou
     *
     * @param array $data Datele contului nou
     * @return array Răspunsul API-ului
     */
    public function conturiBancareAdauga(array $data): array
    {
        return $this->execute("conturibancare/adauga", $data);
    }

    /**
     * Modifică datele unui cont bancar existent
     *
     * @param array $data Datele actualizate ale contului
     * @return array Răspunsul API-ului
     */
    public function conturiBancareModifica(array $data): array
    {
        return $this->execute("conturibancare/modifica", $data);
    }

    /**
     * Șterge un cont bancar
     *
     * @param array $data Parametrii de ștergere (id cont)
     * @return array Răspunsul API-ului
     */
    public function conturiBancareSterge(array $data): array
    {
        return $this->execute("conturibancare/sterge", $data);
    }

    // ==========================================
    // CURS VALUTAR ȘI INFORMAȚII GENERALE
    // ==========================================

    /**
     * Obține cursurile valutare actuale
     *
     * @param array $data Parametrii opționali
     * @return array Cursurile valutare
     */
    public function cursValutar(array $data = []): array
    {
        return $this->execute("vizualizare/cursvalutar", $data);
    }

    /**
     * Obține informații despre o companie pe baza CIF-ului
     *
     * @param array $data Parametrii cu CIF-ul companiei
     * @return array Informațiile companiei
     */
    public function infoCif(array $data): array
    {
        return $this->execute("info/cif", $data);
    }

    // ==========================================
    // SPV / eFactura
    // ==========================================

    /**
     * Listează facturile emise din SPV cu opțiuni de filtrare
     *
     * @param array $data Parametrii de filtrare
     * @return array Lista facturilor emise
     */
    public function eFacturaEmise(array $data = []): array
    {
        return $this->execute("e-factura/emise", $data);
    }

    /**
     * Vizualizează detaliile unei facturi emise din SPV
     *
     * @param array $data Parametrii de căutare
     * @return array Detaliile facturii
     */
    public function eFacturaViewEmise(array $data): array
    {
        return $this->execute("e-factura/view-emise", $data);
    }

    /**
     * Descarcă o factură emisă din SPV (fișier XML/PDF)
     *
     * @param array $data Parametrii de descărcare
     * @return array Conținutul fișierului
     */
    public function eFacturaDescarcaEmise(array $data): array
    {
        return $this->execute("e-factura/descarca-emise", $data, true);
    }

    /**
     * Listează facturile primite de la furnizori din SPV
     *
     * @param array $data Parametrii de filtrare
     * @return array Lista facturilor de la furnizori
     */
    public function eFacturaFurnizori(array $data = []): array
    {
        return $this->execute("e-factura/furnizori", $data);
    }

    /**
     * Vizualizează detaliile unei facturi primite din SPV
     *
     * @param array $data Parametrii de căutare
     * @return array Detaliile facturii
     */
    public function eFacturaViewFurnizori(array $data): array
    {
        return $this->execute("e-factura/view-furnizori", $data);
    }

    /**
     * Descarcă o factură primită din SPV (fișier XML/PDF)
     *
     * @param array $data Parametrii de descărcare
     * @return array Conținutul fișierului
     */
    public function eFacturaDescarcaFurnizori(array $data): array
    {
        return $this->execute("e-factura/descarca-furnizori", $data, true);
    }

    /**
     * Încarcă manual un fișier XML în SPV
     *
     * @param array $data Datele cu fișierul XML
     * @return array Răspunsul API-ului
     */
    public function eFacturaUploadXml(array $data): array
    {
        return $this->execute("e-factura/upload-xml", $data, false, true);
    }

    /**
     * Verifică starea încărcării fișierelor XML în SPV
     *
     * @param array $data Parametrii de verificare
     * @return array Starea procesării
     */
    public function eFacturaUploadStatus(array $data): array
    {
        return $this->execute("e-factura/upload-status", $data);
    }

    // ==========================================
    // API RESELLER - Gestionare Mai Multe Firme
    // ==========================================

    /**
     * Listează companiile gestionate în portofoliul de reseller
     *
     * @param array $data Parametrii de filtrare
     * @return array Lista companiilor
     */
    public function firmaLista(array $data = []): array
    {
        return $this->execute("firma/lista", $data);
    }

    /**
     * Vizualizează detaliile unei companii gestionate
     *
     * @param array $data Parametrii de căutare (id companie)
     * @return array Detaliile companiei
     */
    public function firmaVizualizare(array $data): array
    {
        return $this->execute("firma/vizualizare", $data);
    }

    /**
     * Obține cheia API pentru o companie gestionată
     *
     * @param array $data Parametrii companiei
     * @return array Cheia API
     */
    public function firmaApi(array $data): array
    {
        return $this->execute("firma/api", $data);
    }

    /**
     * Resetează (regenerează) cheia API pentru o companie
     *
     * @param array $data Parametrii companiei
     * @return array Noua cheie API
     */
    public function firmaApiReset(array $data): array
    {
        return $this->execute("firma/api-reset", $data);
    }

    /**
     * Adaugă o companie nouă în portofoliul de reseller
     *
     * @param array $data Datele companiei noi
     * @return array Răspunsul API-ului
     */
    public function firmaAdauga(array $data): array
    {
        return $this->execute("firma/adauga", $data);
    }

    /**
     * Modifică datele unei companii gestionate
     *
     * @param array $data Datele actualizate ale companiei
     * @return array Răspunsul API-ului
     */
    public function firmaModifica(array $data): array
    {
        return $this->execute("firma/modifica", $data);
    }

    /**
     * Activează o companie dezactivată
     *
     * @param array $data Parametrii companiei
     * @return array Răspunsul API-ului
     */
    public function firmaActiveaza(array $data): array
    {
        return $this->execute("firma/activeaza", $data);
    }

    /**
     * Dezactivează (suspendă) o companie
     *
     * @param array $data Parametrii companiei
     * @return array Răspunsul API-ului
     */
    public function firmaDezactiveaza(array $data): array
    {
        return $this->execute("firma/dezactiveaza", $data);
    }

    /**
     * Obține link-ul de autorizare pentru configurarea semnăturii digitale SPV
     *
     * @param array $data Parametrii companiei
     * @return array Link-ul de autorizare
     */
    public function eFacturaAutorizare(array $data): array
    {
        return $this->execute("e-factura/autorizare", $data);
    }

    // ==========================================
    // METODE UTILE
    // ==========================================

    /**
     * Trimite manual o factură în SPV
     *
     * @param array $data Datele facturii de trimis
     * @return array Răspunsul API-ului
     */
    public function trimiteFacturaSpvManual(array $data): array
    {
        return $this->execute("e-factura/trimite-factura-spv", $data);
    }

    /**
     * Filtrează caracterele speciale dintr-un string (pentru compatibilitate XML)
     *
     * @param string $str String-ul de procesat
     * @return string String-ul filtrat
     */
    public static function unaccent(string $str): string
    {
        $transliteration = [
            'Ă' => 'A', 'Â' => 'A', 'Î' => 'I', 'Ș' => 'S', 'Ț' => 'T',
            'ă' => 'a', 'â' => 'a', 'î' => 'i', 'ș' => 's', 'ț' => 't',
            'À' => 'A', 'Á' => 'A', 'Ä' => 'A', 'Ç' => 'C', 'É' => 'E',
            'È' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Í' => 'I', 'Ì' => 'I',
            'Ï' => 'I', 'Ñ' => 'N', 'Ó' => 'O', 'Ò' => 'O', 'Ô' => 'O',
            'Ö' => 'O', 'Ú' => 'U', 'Ù' => 'U', 'Û' => 'U', 'Ü' => 'U',
            'à' => 'a', 'á' => 'a', 'ä' => 'a', 'ç' => 'c', 'é' => 'e',
            'è' => 'e', 'ê' => 'e', 'ë' => 'e', 'í' => 'i', 'ì' => 'i',
            'ï' => 'i', 'ñ' => 'n', 'ó' => 'o', 'ò' => 'o', 'ô' => 'o',
            'ö' => 'o', 'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u'
        ];
        
        return str_replace(array_keys($transliteration), array_values($transliteration), $str);
    }   
}

<?php 
// Controlla se i dati sono stati inviati
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dati ricevuti dal form
    $nome = $_POST['nome'] ?? '';  // Recupera il nome dal form
    $ordini = [
        "margherita" => intval($_POST['margherita'] ?? 0),
        "diavola" => intval($_POST['diavola'] ?? 0),
        "quattro_stagioni" => intval($_POST['quattro_stagioni'] ?? 0),
        "tartufata" => intval($_POST['tartufata'] ?? 0),
        "pizza_marinara" => intval($_POST['pizza_marinara'] ?? 0),
        "pizza_vegetariana" => intval($_POST['pizza_vegetariana'] ?? 0),
        "acqua_minerale" => intval($_POST['acqua_minerale'] ?? 0),
        "coca_cola" => intval($_POST['coca_cola'] ?? 0),
        "tiramisù" => intval($_POST['tiramisù'] ?? 0)
    ];

    // Prezzi delle voci
    $prezzi = [
        "margherita" => 8.00,
        "diavola" => 9.50,
        "quattro_stagioni" => 10.00,
        "tartufata" => 12.00,
        "pizza_marinara" => 7.50,
        "pizza_vegetariana" => 10.00,
        "acqua_minerale" => 2.00,
        "coca_cola" => 3.00,
        "tiramisù" => 6.50
    ];

    // Calcola il totale e crea un riepilogo
    $totale = 0;
    $riepilogo = [];
    foreach ($ordini as $item => $quantita) {
        if ($quantita > 0) {
            $costo = $quantita * $prezzi[$item];
            $totale += $costo;
            $riepilogo[] = [
                "nome" => ucfirst(str_replace("_", " ", $item)),
                "quantita" => $quantita,
                //"costo" => $costo
                "costo" => $prezzi[$item]
            ];
        }
    }

    // Aggiungi il nome dell'utente all'ordine
    $nuovo_ordine = [
        "nome" => $nome,  // Aggiungi il nome dell'utente
        "ordine" => $riepilogo,
        "totale" => $totale,
        "data" => date("Y-m-d H:i:s")
    ];

    // Percorso del file JSON
    $file_path = "ordinato.json";
    if (file_exists($file_path)) {
        $ordini_esistenti = json_decode(file_get_contents($file_path), true) ?? [];
    } else {
        $ordini_esistenti = [];
    }

    // Aggiungi il nuovo ordine alla lista
    $ordini_esistenti[] = $nuovo_ordine;

    // Scrivi l'array aggiornato nel file JSON
    file_put_contents($file_path, json_encode($ordini_esistenti, JSON_PRETTY_PRINT));

    // Reindirizza alla pagina di conferma
    header("Location: conferma.html");
    exit();
} else {
    // Redirige se si accede direttamente
    header("Location: ordinazioni.html");
    exit();
}
?>

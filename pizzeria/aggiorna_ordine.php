<?php
// Verifica se la richiesta è una POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ottieni i dati inviati
    $data = json_decode(file_get_contents("php://input"), true);
    $index = $data['index'];
    $ordineAggiornato = $data['ordine'];

    // Carica gli ordini dal file JSON
    $file_path = "ordinato.json";
    if (file_exists($file_path)) {
        $ordini = json_decode(file_get_contents($file_path), true);
        
        // Verifica se l'indice è valido
        if (isset($ordini[$index])) {
            // Aggiorna l'ordine
            $ordini[$index] = $ordineAggiornato;

            // Salva gli ordini aggiornati nel file JSON
            file_put_contents($file_path, json_encode($ordini, JSON_PRETTY_PRINT));

            // Risposta di successo
            echo json_encode(["success" => true]);
        } else {
            // Indice non valido
            echo json_encode(["success" => false, "message" => "Ordine non trovato."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "File ordini non trovato."]);
    }
}
?>
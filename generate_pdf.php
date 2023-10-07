<?php

// Adres URL strony, którą chcemy skonwertować na PDF
$url = 'http://e-wishes.pl/view.php?id=' . $server_id;

// Klucz API (dostępny po zarejestrowaniu na stronie html2pdf.app)
$apiKey = 'YOUR_API_KEY';

// Inicjalizacja cURL
$ch = curl_init();

// Ustawienie opcji cURL
curl_setopt($ch, CURLOPT_URL, 'https://api.html2pdf.app/v1/generate');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['url' => $url]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'x-api-key: ' . $apiKey
]);

// Wykonanie zapytania cURL
$response = curl_exec($ch);

// Sprawdzenie, czy wystąpił błąd
if (curl_errno($ch)) {
    echo 'Błąd: ' . curl_error($ch);
} else {
    // Ustawienie nagłówków odpowiedzi
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="downloaded.pdf"');
    
    // Wysłanie pliku PDF do przeglądarki
    echo $response;
}

// Zamknięcie cURL
curl_close($ch);
?>

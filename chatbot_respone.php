<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['message'])) {
    $userMessage = strtolower(trim($data['message']));

    // Process user message and respond
    $response = '';

    // Example data
    $partsShops = 'Shop A, Shop B, Shop C';
    $servicesShops = 'Shop A, Shop B, Shop C';
    $nearestShop = 'Shop A, located at Address X';

    if (strpos($userMessage, 'motorcycle parts') !== false) {
        $response = "Here are the shops that offer motorcycle parts in Lian Poblacion: $partsShops.";
    } elseif (strpos($userMessage, 'motorcycle service') !== false) {
        $response = "Here are the shops that offer motorcycle services in Lian Poblacion: $servicesShops.";
    } elseif (strpos($userMessage, 'nearest shop') !== false) {
        $response = "The nearest shop for motorcycle parts or services is $nearestShop.";
    } else {
        $response = 'Sorry, I did not understand your query. Please ask about motorcycle parts, services, or nearest shops.';
    }

    echo json_encode(['response' => $response]);
} else {
    echo json_encode(['response' => 'Invalid request']);
}
?>
`
<?php

// url
$url = 'http://test-remarked.loc/api/order/calculate';

// data
$deliveryDate = new DateTime('2026-01-01', new DateTimeZone('Europe/Moscow'));
$data = [
    "customer" => [
        "birth_date" => "1950-01-01",
        "gender" => "male"
    ],
    "delivery_date" => $deliveryDate->format(DATE_ATOM),
    "products" => [
        ["price" => 100.23, "count" => 5],
        ["price" => 200.15, "count" => 16]
    ]
];

// request
$options = [
    'http' => [
        'method'  => 'POST',
        'header'  =>
            "Content-Type: application/json\r\n" .
            "Accept: application/json\r\n",
        'content' => json_encode($data),
        'timeout' => 5
    ]
];
$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

// print_r($response);

// response
if ($response) {
    $result = json_decode($response, true);
    print_r($result);
}
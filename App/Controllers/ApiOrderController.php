<?php

namespace App\Controllers;

use App\Services\Response;
use App\Models\Order;

class ApiOrderController
{
    private Response $response;
    
    public function __construct()
    {
        $this->response = new Response();
    }
    
    public function calculate(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!$this->calculateIsValidated($data)) {
        	$this->response->error('Invalid input data');
        }
        
        $order = new Order($data);
        
        $this->response->success([
            'base_price' => $order->getBasePrice(),
            'final_price' => $order->getDiscountPrice()
        ]);
    }
    
    public function calculateIsValidated(array $data): bool
    {
        if (!isset($data['customer']['birth_date'], $data['customer']['gender'], $data['delivery_date'], $data['products'])) {
            return false;
        }
        
        if (!is_array($data['products']) || empty($data['products'])) {
            return false;
        }
        
        foreach ($data['products'] as $product) {
            if (!isset($product['price'], $product['count'])
                || !is_numeric($product['price']) || !is_numeric($product['count'])) {
                return false;
            }
        }
        
        return true;
    }
}

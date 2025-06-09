<?php

namespace App\Models;

use App\Services\Discount;

class Order
{
    private array $customer;
    private array $products;
    private \DateTime $deliveryDate;
    private float $basePrice = 0;
    private float $discountPrice;
    
    public function __construct($data)
    {
        $this->customer = $data['customer'];
        $this->products = $data['products'];
        $this->deliveryDate = new \DateTime($data['delivery_date']);
        $this->calculateBasePrice();
        $this->calculateDiscountPrice();
    }
    
    private function calculateDiscountPrice(): void
    {
        $discountPrice = (new Discount($this))->calculateDiscountPrice();
        $this->discountPrice = round($discountPrice, 2);
    }
    
    private function calculateBasePrice(): void
    {
        foreach ($this->products as $product) {
        	$this->basePrice += $product['count'] * $product['price'];
        }
        $this->basePrice = round($this->basePrice, 2);
    }
    
    public function getCustomerGender(): string
    {
        return $this->customer['gender'];
    }
    
    public function getCustomerAge(): int
    {
        $birth_date = new \DateTime($this->customer['birth_date']);
        $now = new \DateTime();
        return $now->diff($birth_date)->y;
    }
    
    public function getBasePrice(): float
    {
        return $this->basePrice;
    }
    
    public function getDiscountPrice(): float
    {
        return $this->discountPrice;
    }
    
    public function getProducts(): array
    {
        return $this->products;
    }

    public function getDeliveryDate(): \DateTime
    {
        return $this->deliveryDate;
    }
}
<?php

namespace App\Services;

use App\Models\Order;

class Discount
{
    public function __construct(
        private readonly Order $order,
        private readonly int   $ageDiscountCondMale = 63,
        private readonly int   $ageDiscountCondFemale = 58,
        private readonly float $ageDiscountValue = 0.05,
        private readonly int   $earlyOrderDiscountCond = 7,
        private readonly float $earlyOrderDiscountValue = 0.04,
        private readonly int   $countDiscountCond = 10,
        private readonly float $countDiscountValue = 0.03,
    ) { }
    
    public function calculateDiscountPrice(): float
    {
        $price = $this->order->getBasePrice();
        
        if ($this->isSenior()) {
            $price -= $price * $this->ageDiscountValue;
        }
        
        if ($this->isEarlyOrder()) {
            $price -= $price * $this->earlyOrderDiscountValue;
        }
    
        if ($this->isEnoughCount()) {
            $price -= $price * $this->countDiscountValue;
        }
        
        return $price;
    }
    
    private function isEnoughCount(): bool
    {
        foreach ($this->order->getProducts() as $product) {
        	if ($product['count'] >= $this->countDiscountCond) {
        		return true;
        	}
        }
        return false;
    }
    
    private function isEarlyOrder(): bool
    {
        $now = new \DateTime();
        $interval = $this->order->getDeliveryDate()->diff($now);
        return $interval->days >= $this->earlyOrderDiscountCond && $this->order->getDeliveryDate() > $now;
    }
    
    private function isSenior(): bool
    {
        $gender = $this->order->getCustomerGender();
        $age = $this->order->getCustomerAge();
        // в целом можно заморочиться и обернуть gender в Enum структуру
        return ($age >= $this->ageDiscountCondMale && $gender == 'male')
            || ($age >= $this->ageDiscountCondFemale && $gender == 'female');
    }
}
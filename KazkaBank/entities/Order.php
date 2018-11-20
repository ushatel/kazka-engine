<?php 

namespace KazkaBank\Entities; 

use System; 
use System\DatabaseEntity; 

class Order extends System\DatabaseEntity {

    protected $id; 

    protected $created = 0; 

    protected $customerId = 0; 

    protected $shopifyCustomerId = 0; 
    
    protected $shopifyOrderId = 0; 

    protected $price = 0; 

    protected $financialStatus = ''; 

    protected $fulfillmentStatus = ''; 

    protected function getTableName(): String {
        return "orders"; 
    }

    protected function getFields(): Array { 
        return [ 
            'id' => [ 'dbf' => 'id', 'dbt' => 'id' ], 
            'created' => [ 'dbf' => 'created', 'dbt' => 'timestamp'], 
            'customerId' => [ 'dbf' => 'customers_id', 'dbt' => 'int' ], 
            'shopifyCustomerId' => [ 'dbf' => 'shopify_client_id', 'dbt' => 'int' ], 
            'shopifyOrderId' => [ 'dbf' => 'shopify_order_id', 'dbt' => 'int' ], 
            'price' => [ 'dbf' => 'price', 'dbt' => 'decimal' ], 
            'financialStatus' => [ 'dbf' => 'financial_status', 'dbt' => 'string', 'stringLength' => 44 ], 
            'fulfillmentStatus' => [ 'dbf' => 'fulfillment_status', 'dbt' => 'string', 'stringLength' => 44 ]
        ];
    } 

    public function setCustomerId(int $customerId): Order {
        $this->customerId = $customerId; 
        return $this; 
    }
    
    public function setShopifyCustomerId(int $shopifyCustomerId): Order {
        $this->shopifyCustomerId = $shopifyCustomerId; 
        return $this; 
    } 

    public function setShopifyOrderId(int $shopifyOrderId): Order {
        $this->shopifyOrderId = $shopifyOrderId; 
        return $this; 
    }

    public function setPrice(float $price): Order { 
        $this->price = $price; 
        return $this; 
    }

    public function setFinancialStatus(string $financialStatus): Order {
        $this->financialStatus = $financialStatus; 
        return $this; 
    }

    public function setFulfillmentStatus(string $fulfillmentStatus): Order {
        $this->fulfillmentStatus = $fulfillmentStatus; 
        return $this; 
    }

}

?> 
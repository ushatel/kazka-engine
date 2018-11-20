<?php 

namespace KazkaBank\Entities; 

use System; 
use System\DatabaseEntity; 

class Customer extends DatabaseEntity { 

    protected $id; 

    protected $created = 0; 

    // Here could be later integrated IDoc extension to parse extra options 
    protected $name = ""; 

    protected $email = "";

    protected $shopifyCustomerId = 0; 

    protected function getTableName(): String {
        return 'customers'; 
    }

    protected function getFields(): Array {
        return [
            'id' => [ 'dbf' => 'id', 'dbt' => 'id' ], 
            'created' => [ 'dbf' => 'created', 'dbt' => 'timestamp' ], 
            'name' => [ 'dbf' => 'name', 'dbt' => 'string', 'stringLength' => 44  ], 
            'email' => [ 'dbf' => 'email', 'dbt' => 'string', 'stringLength' => 44  ]
        ]; 
    }

    public function getId() {
        return $this->id; 
    }

    public function setName(String $name): Customer {
        $this->name = $name; 
        return $this; 
    }

    public function setEmail(String $email): Customer {
        $this->email = $email; 
        return $this; 
    }

    public function setShopifyCustomerId(int $customerId): Customer {
        $this->shopifyCustomerId = $customerId; 
        return $this; 
    }

}

?> 
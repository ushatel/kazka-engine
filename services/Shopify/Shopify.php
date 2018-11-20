<?php

namespace Services\Shopify; 

use System; 

class Shopify extends System\Service {

    private const baseurl= "https://shopify.myshopify.com/admin/orders.json"; 
    private const key= "key"; 
    private const password= "pass"; 

    private $_lastDataset = null;

    public function load(): int {

        $curl = curl_init( Shopify::baseurl ); 

        curl_setopt( $curl, CURLOPT_USERPWD, self::key. ":". self::password );
        curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, TRUE); 
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false ); 
        curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0 ); 
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, TRUE); 

        //$result = json_decode(curl_exec($curl));

        $result = json_decode( curl_exec($curl) ); 

        if( $result ) {
            $this->_lastDataset = $result; 
        }

        /*
        foreach( $result->orders as $row ) { 
            echo "<pre>"; print_r( $row ); echo "</pre><br><br>"; 
        }
        */
      //print_r(curl_error($curl)); 
        curl_close($curl); 

        //print_r($result);

        return 1; 
    }

    private function parseResult() {

    }

    public function getLastDataset(): object {
        return $this->_lastDataset; 
    }

}

?> 
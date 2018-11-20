<?php 

namespace KazkaBank\Controllers; 

use System; 
use System\Database; 
use NexusMedia\Entities\Order; 
use NexusMedia\Entities\Customer; 
use Services\Shopify; 

class IndexController extends System\Controller {

    // empty action 
    public function actionIndex() {
        $this->render("/KazkaBank/facade/main.view.php"); // later view resolver goes here 
        //echo "Boungorno! Della Controla!"; 
    }

    public function actionLoad() { 

        echo "Buongiorno! Load!"; 
        $shopify = new \Services\Shopify\Shopify(); 
        if( $shopify->load() && $dataset = $shopify->getLastDataset()->orders) {

            Database::getDatabase()->truncateObject( new Order() ); 

            $customer_id = 0; 
            $customer_real_id = 0; 
            foreach( $dataset as $orderItem) { 
                echo "<pre>"; 
                //print_r( $orderItem );
                if( property_exists($orderItem, 'customer') && $orderItem->customer ) {
                    //print_r( $orderItem ); 

                    $order = new Order(); 

                    $order->setShopifyCustomerId((int)$orderItem->customer->id); 
                    $order->setShopifyOrderId((int)$orderItem->id); 
                    $order->setPrice((float)$orderItem->total_price); 
                    $order->setFinancialStatus((string)$orderItem->financial_status); 
                    $order->setFulfillmentStatus((string)$orderItem->fulfillment_status); 
print_r($orderItem); 

                    if($customer_id != $orderItem->customer->id && $orderItem->customer->id > 0) {

                        $selected = Database::getDatabase()->selectObject( new Customer(), " `email`='".Database::escape($orderItem->customer->email)."' OR `name`='".$orderItem->customer->first_name." ".$orderItem->customer->last_name."' LIMIT 1" ); 
                        $customer_id = $orderItem->customer->id; 

                        if( count($selected) < 1) {
                            $customer = new Customer(); 
                            $customer->setName( $orderItem->customer->first_name." ".$orderItem->customer->last_name ); 
                            $customer->setEmail( $orderItem->customer->email ); 

                            Database::getDatabase()->storeObject( $customer ); 

                            $customer_real_id = Database::getInsertId(); 
                        }
                        else {
                            $customer_real_id = (int)$selected[0]->getId(); 
                        }
                    }

                    $order->setCustomerId($customer_real_id); 

                    Database::getDatabase()->storeObject( $order ); 
                }
                echo "</pre>"; 
            }

        }

    }

}

?> 
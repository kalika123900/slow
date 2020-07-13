<?php
//display_error(E_ALL);
require_once(__DIR__.'/includes/index.php'); 
CONST SECURITY_DIR = __DIR__.'/security';

use \Ttskch\GoogleSheetsApi\Factory\GoogleClientFactory;
use \Ttskch\GoogleSheetsApi\Factory\ApiClientFactory;
class Slow {

    private $order_id;
    private $date;
    private $status;
    private $sheetid;
    
    function __construct(){
          $this->order_id = '1151';
          $this->date = '15-03-2020';
          $this->status = 'processing';
          $this->sheetid = '18GZN2XyzU9xqzocdERjIrlvy9zGjWzmnLUCFTFVfGYk';
          
        $googleClient = \Ttskch\GoogleSheetsApi\Factory\GoogleClientFactory::createServiceAccountClient(SECURITY_DIR.'/service-account.json');
              global $woocommerce;
              
              
              $api = \Ttskch\GoogleSheetsApi\Factory\ApiClientFactory::create($googleClient);
            
              $range = 'Sheet1!A1:P';
         
              $response = $api->getGoogleService()->spreadsheets_values->get($this->sheetid,$range);
              
              $values = $response->getValues();

              $valueRange= new Google_Service_Sheets_ValueRange();

              $query = new WC_Order_Query( array(
                  'limit' => 10,
                  'orderby' => 'date',
                  'order' => 'DESC',
                  'status' => 'processing',
              ) );
              $orders = $query->get_orders();
              $product_order = [];
              $product_order['Bajra Almond Cashew'] = 11;
              $product_order['Bajra Dark Chocolate Cookies'] = 12;
              $product_order['Prebiotic Jowar Zeera Cookies'] = 13;
              $product_order['Ragi Dark Chocolate Cookies'] = 15;
              $product_order['Oats and Millet Cookies'] = 14;
              foreach($orders as $order):
             
              $temp = [];
              $temp[11] = 0;
              $temp[12] = 0;
              $temp[13] = 0;
              $temp[14] = 0;
              $temp[15] = 0;

              $date = date('Y-m-d',strtotime($order->get_date_created()));
              $temp[0] = $date;
              $temp[1] = '#'.$order->get_id();
              $temp[2] = 'turnslow.com';
              $temp[3] = $order->get_billing_first_name().' '.$order->get_billing_last_name();
              $temp[4] = $order->get_billing_city();
              $orderItems = $order->get_items(); 
              foreach($orderItems as $item)
              {
                $temp[$product_order[$item->get_name()]]= $item->get_quantity();
              }
              echo "<pre>";
              print_r($temp);
              die();
              endforeach;
              die();
              $valueRange->setValues(["values" => ["a", "b"]]); // Add two values

              // Then you need to add some configuration
              $conf = ["valueInputOption" => "RAW"];

              $response = $api->getGoogleService()->spreadsheets_values->append($this->sheetid, $range, $valueRange,$conf);
              echo '<pre>';
              print_r($values); die();
            

    }
}
?>
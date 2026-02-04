<?
class Task {

    protected $task_name;

    function __construct($prod_id, $osub_id)
    {
        $this->task_name = $osub_id . $prod_id;
    }


}

class Tasks {

    protected $products;

    function __construct($order)
    {
        $this->products = get_products($order['order_ID']);
    }

    public function get_tasks($products){

        foreach ($products as $product ){

            $task = new Task($product['prod_id'], $product['osub_id']);
        }

    }

}



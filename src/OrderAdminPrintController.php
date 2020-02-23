<?php

namespace SilverShop;


use SilverShop\Model\Order;
use SilverStripe\GraphQL\Controller;
use SilverStripe\View\ArrayData;

class OrderAdminPrintController extends Controller
{
    private static $allowed_actions = [
        'printorder'
    ];

    public function printorder()
    {
        $id = $this->request->param('ID');

        if(!$id) {
            return $this->httpError(404);
        }

        $order = Order::get()->byId($id);

        if(!$order) {
            return $this->httpError(404);
        }

        if(!$order->canView()) {
            return $this->httpError(403);
        }

        return $this->customise(ArrayData::create([
            'Order' => $order
        ]))->renderWith('Includes/Order_ReceiptEmail');
    }
}

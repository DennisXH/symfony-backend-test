<?php
namespace Controllers;

class PurchasesController extends BaseController
{
    // purchase tokens are unique

    public function getAction(string $purchaseToken='')
    {
        // your code goes here
    }

    public function purchaseAction()
    {
        // You don't need to verify if the credit card number is valid
        // Assume any positive integer is a valid coin_package_id 

        $purchaseToken    = $this->post['purchase_token']; // this token must be unique on the table
        $coinPackageId    = $this->post['coin_package_id'];
        $creditCardNumber = $this->post['credit_card_number'];
        $creditCardExpiry = $this->post['credit_card_expiry'];
        $creditCardCvv    = $this->post['credit_card_cvv'];        

        // your code goes here
    }
}
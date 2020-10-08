<?php
namespace Controllers;

use App\Entity\Purchase;
use App\Entity\Session;
use App\Repositories\PurchaseRepository;
use App\Repositories\SessionRepository;

class PurchasesController extends BaseController
{
    /** @var integer */
    protected $userId;

    public function __construct($route)
    {
        parent::__construct($route);
    }

    protected function authUser()
    {
        /** @var SessionRepository $sessionRepository */
        $sessionRepository = $this->entityManager->getRepository(Session::class);
        $this->userId = $sessionRepository->getUserIdBySessionToken($this->sessionToken);
    }

    // purchase tokens are unique

    public function getAction(string $purchaseToken='')
    {
        $this->authUser();
        try {
            /** @var PurchaseRepository $purchaseRepository */
            $purchaseRepository = $this->entityManager->getRepository(Purchase::class);

            // list all user purchases
            if (empty($purchaseToken)) {
                $purchases = $purchaseRepository->getPurchasesByUserId($this->userId);
                $result = [];
                foreach ($purchases as $purchase) {
                    $result[] = $this->map($purchase);
                }

                return $result;
            }

            //return a specific purchase
            $purchase = $purchaseRepository->getPurchaseByPurchaseToken($purchaseToken);
            if (null == $purchase) {
                throw new \Exception('Invalid Token');
            }
            return $this->map($purchase);

        } catch (\Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }

    public function purchaseAction()
    {
        // You don't need to verify if the credit card number is valid
        // Assume any positive integer is a valid coin_package_id 
        $this->authUser();
        $purchaseToken    = $this->post['purchase_token']; // this token must be unique on the table
        $coinPackageId    = $this->post['coin_package_id'];
        $creditCardNumber = $this->post['credit_card_number'];
        $creditCardExpiry = $this->post['credit_card_expiry'];
        $creditCardCvv    = $this->post['credit_card_cvv'];

        try {
            $purchase = new Purchase();
            $purchase->setUserId($this->userId);
            $purchase->setCoinPackageId($coinPackageId);
            $purchase->setPurchaseToken($purchaseToken);
            $purchase->setCreatedAt(new \DateTime('now'));
            $purchase->setCurrency('USD');

            $this->entityManager->persist($purchase);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return $this->badRequest($e->getMessage());
        }

        return [
            'http_code' => 200,
            'success' => true
        ];
    }

    protected function map(Purchase $purchase)
    {
        return [
            'purchase_token' => $purchase->getPurchaseToken(),
            'created_at' => toDateTimeString($purchase->getCreatedAt()),
            'currency' => $purchase->getCurrency(),
            'coin_package_id' => $purchase->getCoinPackageId()
        ];
    }
}
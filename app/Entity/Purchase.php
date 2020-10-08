<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repositories\PurchaseRepository")
 * @ORM\Table(name="purchases")
 */
class Purchase
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $purchase_token;
    /**
     * @ORM\Column(type="integer")
     */
    protected $user_id;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @ORM\Column(type="integer")
     */
    protected $coin_package_id;

    /**
     * @ORM\Column(type="string", length=3, options={"fixed" = true})
     */
    protected $currency;

    /**
     * @return mixed
     */
    public function getPurchaseToken()
    {
        return $this->purchase_token;
    }

    /**
     * @param mixed $purchase_token
     */
    public function setPurchaseToken($purchase_token): void
    {
        $this->purchase_token = $purchase_token;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getCoinPackageId()
    {
        return $this->coin_package_id;
    }

    /**
     * @param mixed $coin_package_id
     */
    public function setCoinPackageId($coin_package_id): void
    {
        $this->coin_package_id = $coin_package_id;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency): void
    {
        $this->currency = $currency;
    }
}
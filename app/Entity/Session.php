<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repositories\SessionRepository")
 * @ORM\Table(name="sessions")
 */
class Session
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $token;
    /**
     * @ORM\Column(type="string")
     */
    protected $user_id;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $start_datetime;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $end_datetime;

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param integer $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getStartDatetime()
    {
        return $this->start_datetime;
    }

    /**
     * @param \DateTime $start_datetime
     */
    public function setStartDatetime($start_datetime)
    {
        $this->start_datetime = $start_datetime;
    }

    /**
     * @return mixed
     */
    public function getEndDatetime()
    {
        return $this->end_datetime;
    }

    /**
     * @param mixed $end_datetime
     */
    public function setEndDatetime($end_datetime)
    {
        $this->end_datetime = $end_datetime;
    }
}
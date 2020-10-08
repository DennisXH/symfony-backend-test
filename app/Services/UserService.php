<?php
namespace App\Services;

use App\Entity\Session;
use App\Entity\User;
use App\Repositories\SessionRepository;
use Doctrine\ORM\EntityManager;

final class UserService
{
    public function createNewSession(User $user, $expiredInDay = 7): Session
    {
        $session = new Session();
        $session->setUserId($user->getId());
        $session->setToken(generateToken());
        $now = new \DateTime('now');
        $end = clone $now;
        $session->setStartDatetime($now);
        $session->setEndDatetime(
            $end->add(new \DateInterval('P' . $expiredInDay . 'D' ))
        );

        return $session;
    }

    public function getCurrentSession(EntityManager $em, User $user)
    {
        //find and return non expired session
        /** @var SessionRepository $sessionRepository */
        $sessionRepository = $em->getRepository(Session::class);
        $currentSession = $sessionRepository->getOneByDate(new \DateTime('now'));

        //create a new session if expired or doesn't exist
        if (null == $currentSession) {
            $currentSession = $this->createNewSession($user);
        }

        return $currentSession;
    }
}
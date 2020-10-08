<?php
namespace Controllers;

use App\Entity\User;
use App\Services\UserService;
use Doctrine\ORM\EntityManager;

class UsersController extends BaseController
{
    // Session length = 30 minutes
    // Emails are unique
    // Session tokens are unique and used to identify a user
    // the max length of all fields here is 100 characters

    public function loginAction()
    {
        $email = $this->post['email'];
        $password = $this->post['password'];
        $search = $this->entityManager->getRepository(User::class)->findBy(['email' => $email]);

        if (empty($search)) {
            return $this->notFoundRequest();
        }

        /** @var User $user */
        $user = $search[0];
        if (!password_verify(hash_hmac("sha256", $password, $_ENV['USER_PASSWORD_SECRET']), $user->getPassword())) {
            return $this->unauthorizedRequest();
        }

        $service = new UserService();
        try {
            $session = $service->getCurrentSession($this->entityManager, $user);
        } catch (\Exception $e) {
            return $this->badRequest($e->getMessage());
        }

        return [
            'http_code' => 200,
            'success' => true,
            'session_token' => $session->getToken()
        ];
    }

    public function signUpAction()
    {
        $email = $this->post['email'];
        $password = $this->post['password'];
        $firstName = $this->post['first_name'];
        $lastName = $this->post['last_name'];
        //Form Validation
        //create a new user
        //create a session token
        $user = new User();
        $service = new UserService();
        try {
            $this->emailValidation($email, $this->entityManager);
            $user->setEmail($email);
            $user->setPassword($this->hashPassword($password));
            $user->setFirstName($firstName);
            $user->setLastName($lastName);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $session = $service->createNewSession($user);
            $this->entityManager->persist($session);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return $this->badRequest($e->getMessage());
        }

        return [
            'http_code' => 200,
            'success' => true,
            'session_token' => $session->getToken()
        ];
    }

    /**
     * @param string $email
     * @param EntityManager $entityManager
     * @throws \Exception
     */
    protected function emailValidation(string $email, EntityManager $entityManager)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Invalid Email');
        }

        $result = $entityManager->getRepository(User::class)->findBy(['email' => $email]);

        if (count($result) > 0) {
            throw new \Exception('Duplicated Email');
        }
    }

    protected function hashPassword(string $password)
    {
        $pwd_peppered = hash_hmac("sha256", $password, $_ENV['USER_PASSWORD_SECRET']);
        return password_hash($pwd_peppered, PASSWORD_BCRYPT);
    }
}
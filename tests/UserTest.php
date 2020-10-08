<?php
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testValidDBUserSession()
    {
        $session = new \App\Entity\Session();
        $em = Mockery::mock('em');
        $em->shouldReceive('getRepository->getOneByDate')
            ->once()
            ->andReturn($session);

        $user = new \App\Entity\User();
        $service = new \App\Services\UserService();

        $this->assertEquals($session,$service->getCurrentSession($em, $user));
    }

    public function testCreateNewUserSession()
    {
        $newSession = new \App\Entity\Session();
        $newSession->setUserId(1);
        $user = new \App\Entity\User();
        $em = Mockery::mock('em');
        $em->shouldReceive('getRepository->getOneByDate')
            ->once()
            ->andReturn(null);

        $mockService = Mockery::mock(\App\Services\UserService::class)->makePartial();
        $mockService->shouldReceive('createNewSession')
            ->with($user)
            ->andReturn($newSession);

        $this->assertEquals($newSession,$mockService->getCurrentSession($em, $user));
    }
}
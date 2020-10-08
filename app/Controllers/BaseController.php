<?php
namespace Controllers;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class BaseController
{
    public $post = [];
    
    protected $user           = null;
    protected $route          = [];
    protected $sessionToken   = '';
    protected $entityManager;

    public function __construct($route)
    {
        $this->route = $route;
        $this->post  = $_POST;
        $this->getEntityManager();
    }

    public function startApp()
    {
        $this->sessionToken = $_SERVER['HTTP_AUTHENTICATION'] ?? '';
    }

    public function badRequest(string $message = '')
    {
        $message = $message ?: 'Generic error.';

        return [
            'http_code' => 'bad_request',
            'message'   => $message,
            'success'   => false
        ];
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     */
    protected function getEntityManager()
    {
        $isDevMode = false;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;
        $dbParams = [
            'driver'   => 'pdo_mysql',
            'user'     => $_ENV['DATABASE_USERNAME'],
            'password' => $_ENV['DATABASE_PASSWORD'],
            'dbname'   => $_ENV['DATABASE_NAME'],
            'host'     => $_ENV['DATABASE_HOST'],
            'port'     => $_ENV['DATABASE_PORT']
        ];
        $config = Setup::createAnnotationMetadataConfiguration(
            [__DIR__ . '/app/Entity'],
            $isDevMode,
            $proxyDir,
            $cache,
            $useSimpleAnnotationReader
        );

        $this->entityManager = EntityManager::create($dbParams, $config);
    }
}
<?php
namespace Controllers;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class BaseController
{
    public $post = [];
    
    protected $user           = null;
    protected $route          = [];
    protected $sessionToken   = '';

    public function __construct($route)
    {
        $this->route = $route;
        $this->post  = $_POST;
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
     * @return EntityManager The created EntityManager.
     */
    public function getEntityManager()
    {
        $paths = array(__DIR__."/app/Entity");
        $isDevMode = true;
        $dbParams = array(
            'driver'   => 'pdo_mysql',
            'user'     => $_ENV['DATABASE_USERNAME'],
            'password' => $_ENV['DATABASE_PASSWORD'],
            'dbname'   => $_ENV['DATABASE_NAME'],
            'host'     => $_ENV['DATABASE_HOST'],
            'port'     => $_ENV['DATABASE_PORT']
        );

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        return EntityManager::create($dbParams, $config);
    }
}
<?php
namespace Controllers;

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
}
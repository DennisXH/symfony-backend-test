<?php
namespace Controllers;

class UsersController extends BaseController
{
    // Session length = 30 minutes
    // Emails are unique
    // Session tokens are unique and used to identify a user
    // the max length of all fields here is 100 characters

    public function loginAction()
    {
        $email    = $this->post['email'];
        $password = $this->post['password'];

        // your code goes here
    }

    public function signUpAction()
    {
        $email     = $this->post['email'];
        $password  = $this->post['password'];
        $firstName = $this->post['first_name'];
        $lastName  = $this->post['last_name'];

        // your code goes here
    }
}
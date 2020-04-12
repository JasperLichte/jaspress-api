<?php

namespace api\actions\auth;

use api\actions\Action;
use api\ApiResponse;
use auth\exceptions\UnknownUserException;
use auth\exceptions\WrongPasswordException;
use auth\Login;
use auth\models\User;
use util\exceptions\LogicException;

class RegisterAction extends AuthAction
{

    public function run(): ApiResponse
    {
        $user = (new User())->deserialize($this->req->getAllPost());
        if ($user->isEmpty()) {
            return $this->res->setErrorMessage('User cannot be empty')->status(400);
        }

        if (User::loadByEmail($this->db, $user->getEmail()) != null) {
            return $this->res->setErrorMessage("User '" . $user->getEmail() . "' exists already")->status(401);
        }

        try {
            User::storeNew($this->db, $user);
            $user = (new Login($this->db, $user))->perform();
        } catch(UnknownUserException | WrongPasswordException | LogicException $e) {
            return $this->res->exception($e)->status(401);
        }

        return $this->res->setSuccessMessage('Successfully registered')->withData(['user' => $user]);
    }

}

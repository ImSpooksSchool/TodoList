<?php
/**
 * Created by Nick on 08 Mar 2020.
 * Copyright © ImSpooks
 */


namespace controller;

class AccountController extends AbstractController {

    public function index(array $data): bool {
        return $this->login($data);
    }

    public function login(array $data): bool {
        $this->render("account", "LoginView", $this->account, $data);
        return true;
    }

    public function register(array $data): bool {
        $this->render("account", "RegisterView", $this->account, $data);
        return true;
    }

    public function logout(array $data): bool {
        $_SESSION["msg"] = "You logged out successfully.";
        unset($_SESSION["account"]);

        $this->render("account", "LoginView", $this->account, $data);
        return true;
    }
}
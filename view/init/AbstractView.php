<?php
/**
 * Created by Nick on 08 Mar 2020.
 * Copyright © ImSpooks
 */


namespace view\init;


use handlers\ConnectionHandler;
use objects\Account;

abstract class AbstractView {

    protected $messages = ["success" => [], "error" => []];

    public abstract function render(Account $account, array $data, ConnectionHandler $connectionHandler): void;

    public function updateMessages(): void {
        $_SESSION["msg"] = $this->messages;
    }

    public function addError(string $error, bool $boolean = true) {
        if ($boolean)
            array_push($this->messages["error"], $error);
    }

    public function getErrors(): array {
        return $this->messages["error"];
    }

    public function addSuccess(string $succes, bool $boolean = true) {
        if ($boolean)
            array_push($this->messages["success"], $succes);
    }

    public function getSuccess(): array {
        return $this->messages["success"];
    }
}
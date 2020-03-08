<?php
/**
 * Created by Nick on 08 Mar 2020.
 * Copyright © ImSpooks
 */


namespace view\init;


use objects\Account;

abstract class AbstractView {

    protected $messages = ["success" => [], "warning" => []];

    public abstract function render(Account $account, array $data): void;

    public function updateMessages(): void {
        $_SESSION["msg"] = $this->messages;
    }

    public function addWarning(string $error, bool $boolean = true) {
        if ($boolean)
            array_push($this->messages["warning"], $error);
    }

    public function getWarnings(): array {
        return $this->messages["warning"];
    }

    public function addSuccess(string $succes, bool $boolean = true) {
        if ($boolean)
            array_push($this->messages["success"], $succes);
    }

    public function getSuccess(): array {
        return $this->messages["success"];
    }
}
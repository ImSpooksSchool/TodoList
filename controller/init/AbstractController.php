<?php
/**
 * Created by Nick on 17 feb. 2020.
 * Copyright © ImSpooks
 */

namespace controller;

use objects\Account;
use view\init\AbstractView;

abstract class AbstractController {

    protected Account $account;
    public function __construct() {
        if (isset($_SESSION["account"])) {
            $this->account = Account::deserialize($_SESSION["account"]);
        } else {
            $this->account = new Account(-1, "", "", []);
        }
    }


    /**
     * @param object $instance
     * @param string $function
     * @param array $data
     * @return mixed
     */
    public function generateContent(object $instance, string $function, array $data): bool {
        return $instance::$function($data);
    }

    public abstract function index(array $data): bool;

    public function render(string $folder, String $className, $data): void {
        /** @var $view AbstractView */


        require_once ROOT . "view/template/header.php";

        $class = "view\\" . str_replace("/", "\\", $folder) . "\\" . $className;
        require_once ROOT . $class . ".php";
        $view = new $class();
        $view->render($this->account, $data);

        require_once ROOT . "view/template/footer.php";
    }
}
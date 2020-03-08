<?php
/**
 * Created by Nick on 17 feb. 2020.
 * Copyright © ImSpooks
 */

namespace handlers;

use controller\AbstractController;
use Error;

class ContentHandler {

    private static bool $initialized = false;
    private static ContentHandler $instance;

    public static function getInstance(): ContentHandler {
        if (!self::$initialized) {
            self::$instance = new self();
            self::$initialized = true;

            require_once(ROOT . "util/Utils.php");
            require_once(ROOT . "util/Enum.php");
            require_once(ROOT . "handlers/ConnectionHandler.php");
            require_once(ROOT . "objects/Serializable.php");
            require_once(ROOT . "objects/TodoStatus.php");
            require_once(ROOT . "objects/TodoItem.php");
            require_once(ROOT . "objects/TodoList.php");
            require_once(ROOT . "objects/Account.php");
            require_once(ROOT . "view/init/AbstractView.php");

        }
        return self::$instance;
    }

    public function route(string $data = "") {
        $url = [];
        if (isset($data) && strlen($data) > 0) {
            $tmp_url = explode("/", trim(filter_var($data, FILTER_SANITIZE_URL), "/"));
            $url["controller"] = isset($tmp_url[0]) ? ucwords($tmp_url[0] . "Controller") : "TodoListController";
            $url["action"] = isset($tmp_url[1]) ? $tmp_url[1] : "index";
            unset($tmp_url[0], $tmp_url[1]);
            $url["args"] = array_values($tmp_url);
        } else {
            $url["controller"] = "TodoListController";
            $url["action"] = "index";
            $url["args"] = [];
        }

        // If account is not set
        if (!isset($_SESSION["account"])) {
            $url["controller"] = "AccountController";
            if (strtolower($url["action"]) != "login" && strtolower($url["action"]) != "register")
                $url["action"] = "login";
            $url["args"] = [];
        }

        if ($url != null && isset($url["controller"])) {
            if (file_exists(ROOT . "/controller/" . $url["controller"] . ".php")) {
                require_once(ROOT . "/controller/init/AbstractController.php");
                require_once(ROOT . "/controller/" . $url["controller"] . ".php");

                $url["controller"] = "controller\\" . $url["controller"];

                /** @var AbstractController $instance */
                $instance = new $url["controller"]();

                try {
                    if ($instance->generateContent($instance, strtolower($url["action"]), $url["args"])) {
                        return;
                    }
                } catch (Error $e) {
                    throw $e;
                }
            }
        }

        // not found
    }
}
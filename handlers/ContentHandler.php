<?php
/**
 * Created by Nick on 17 feb. 2020.
 * Copyright © ImSpooks
 */

namespace handlers;

use controller\IController;
use controller\MainController;

class ContentHandler {

    private static bool $initialized = false;
    private static ContentHandler $instance;

    public static function getInstance(): ContentHandler {
        if (!self::$initialized) {
            self::$instance = new self();
            self::$initialized = true;

            require_once(ROOT . "util/Enum.php");
            require_once(ROOT . "handlers/ConnectionHandler.php");
            require_once(ROOT . "objects/Serializable.php");
            require_once(ROOT . "objects/TodoStatus.php");
            require_once(ROOT . "objects/TodoItem.php");
            require_once(ROOT . "objects/TodoList.php");

        }
        return self::$instance;
    }

    public function route() {
        $url = [];
        echo "get = " . json_encode($_GET) . "<br>";
        if (isset($_GET["redirect"])) {
            $tmp_url = explode("/", trim(filter_var($_GET["redirect"], FILTER_SANITIZE_URL), "/"));
            $url["controller"] = isset($tmp_url[0]) ? ucwords($tmp_url[0] . "Controller") : "MainController";
            $url["action"] = isset($tmp_url[1]) ? $tmp_url[1] : "index";
            unset($tmp_url[0], $tmp_url[1]);
            $url["args"] = array_values($tmp_url);
        }
        else {
            $url["controller"] = "MainController";
            $url["action"] = "index";
            $url["args"] = [];
        }

        echo "url = " . json_encode($url) . "<br>";

        if ($url != null && isset($url["controller"])) {
            if (file_exists(ROOT . "/controller/" . $url["controller"] . ".php")) {
                require_once(ROOT . "/controller/IController.php");
                require_once(ROOT . "/controller/" . $url["controller"] . ".php");

                echo "controller = " . $url["controller"] . "<br>";
                $url["controller"] = "controller\\" .  $url["controller"];

                /** @var IController $instance */
                $instance = new $url["controller"]();

                if ($instance->generateContent($instance, strtolower($url["action"]), $url["args"])) {
                    return;
                }
            }
        }

        // not found
    }
}
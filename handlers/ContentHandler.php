<?php
/**
 * Created by Nick on 17 feb. 2020.
 * Copyright © ImSpooks
 */

namespace handlers;

use controller\IController;

class ContentHandler {

    private static bool $initialized = false;
    private static ContentHandler $instance;

    public static function getInstance(): ContentHandler {
        if (!self::$initialized) {
            self::$instance = new self();
            self::$initialized = true;

            require_once(ROOT . "util/Enum.php");
            require_once(ROOT . "objects/Serializable.php");
            require_once(ROOT . "objects/TodoStatus.php");
            require_once(ROOT . "objects/TodoItem.php");
            require_once(ROOT . "objects/TodoList.php");

        }
        return self::$instance;
    }

    public function route() {
        if (isset($_GET["redirect"])) {

        }
        else {

        }
    }
}
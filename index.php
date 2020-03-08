<?php

session_start();

use handlers\ContentHandler;
use objects\Account;
use objects\TodoItem;
use objects\TodoList;
use objects\TodoStatus;

define("ROOT", __DIR__ . DIRECTORY_SEPARATOR);
require_once(ROOT . "handlers/ContentHandler.php");

ContentHandler::getInstance()->route();

$obj = new Account(0, "Nick", "nickversluis446@gmail.com", [new TodoList("Test", [new TodoItem("Title", "Desc", TodoStatus::NOT_STARTED())])]);
echo json_encode($obj->serialize()) . "\n<br>";

$deserialized = Account::deserialize($obj->serialize());
echo json_encode($deserialized->serialize()) . "\n<br>";
?>


<?php
require_once "template/header.php";

use handlers\ContentHandler;
use objects\TodoItem;
use objects\TodoList;
use objects\TodoStatus;

define("ROOT", __DIR__ . DIRECTORY_SEPARATOR);
require_once(ROOT . "handlers/ContentHandler.php");

ContentHandler::getInstance()->route();

$obj = new TodoList("Test", [new TodoItem("Title", "Desc", TodoStatus::NOT_STARTED())]);
//echo json_encode($obj->serialize()) . "\n";
?>



<?php require_once "template/footer.php"?>


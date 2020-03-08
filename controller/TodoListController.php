<?php
/**
 * Created by Nick on 17 feb. 2020.
 * Copyright © ImSpooks
 */

namespace controller;

use objects\TodoList;

class TodoListController extends AbstractController {

    public function index(array $data): bool {
        $this->render("todolist", "ListView", $data);
        return true;
    }

    public function list(array $data): bool {
        $this->index($data);
        return true;
    }

    public function add(array $data): bool {
        $this->render("todolist", "ListAdd", $data);
        return true;
    }

    public function edit(array $data): bool {
        $this->render("todolist", "ListEdit", $data);
        return true;
    }

    public function remove(array $data): bool {
        if (count($this->account->getTodoLists()) > intval($data[0])) {
            $this->account->removeTodoLists($this->account->getTodoLists()[intval($data[0])]);
            $this->account->update();

            $_SESSION["msg"] = ["success" => []];
            $_SESSION["msg"]["success"] = ["List removed"];
        }
        $this->index([]);
        return true;
    }

    public function additem(array $data): bool {
        echo "1<br>";
        $this->render("todolist/item", "ItemAdd", $data);
        echo "2<br>";
        return true;
    }

    public function item(array $data): bool {
        $function = $data[0];
        array_shift($data);

        switch ($function) {
            case "edit":
                $this->render("todolist/item", "ItemEdit", $data);
                break;
            case "remove": {
                /** @var TodoList $todoList */
                if (count($this->account->getTodoLists()) > 0) {
                    $todoList = $this->account->getTodoLists()[intval($data[0])];
                    if (count($todoList->getItems()) > 0) {
                        $todoList->removeItem($todoList->getItems()[intval($data[1])]);
                        $this->account->update();
                    }


                    $_SESSION["msg"] = ["success" => []];
                    $_SESSION["msg"]["success"] = ["Item removed"];
                }
                $this->index([]);
                return true;
            }
        }
        return true;
    }
}
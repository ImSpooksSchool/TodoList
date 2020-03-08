<?php
/**
 * Created by Nick on 08 Mar 2020.
 * Copyright © ImSpooks
 */

namespace objects;


use handlers\ConnectionHandler;

class Account implements Serializable {

    private int $id;
    private string $name;
    private string $email;
    private array $todoLists;

    /**
     * Account constructor.
     * @param int $id
     * @param string $name
     * @param string $email
     * @param array $todoList
     */
    public function __construct(int $id, string $name, string $email, array $todoList) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->todoLists = $todoList;
    }


    public function serialize(): array {

        $data = [];

        $data["id"] = $this->id;
        $data["name"] = $this->name;
        $data["email"] = $this->email;

        $todoLists = [];
        /** @var $list TodoList*/
        foreach ($this->todoLists as $list) {
            array_push($todoLists, $list->serialize());
        }

        $data["todoLists"] = $todoLists;
        return $data;
    }

    public static function deserialize(array $input): Account {
        $id = $input["id"];
        $name = $input["name"];
        $email = $input["email"];

        $todoLists = [];
        foreach ($input["todoLists"] as $item) {
            array_push($todoLists, TodoList::deserialize($item));
        }

        return new Account($id, $name, $email, $todoLists);
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getTodoLists(): array {
        return $this->todoLists;
    }

    public function getSerializedTodoLists(): array {
        $todoLists = [];
        /** @var $list TodoList*/
        foreach ($this->todoLists as $list) {
            array_push($todoLists, $list->serialize());
        }
        return $todoLists;
    }

    public function addTodoList(TodoList $todoList): void {
        array_push($this->todoLists, $todoList);
    }

    public function removeTodoLists(TodoList $todoList): void {
        if (in_array($todoList, $this->todoLists)) {
            unset($this->todoLists[array_search($todoList, $this->todoLists)]);
        }
    }

    public function hasTodoList(string $name): bool {
        /** @var $todoList TodoList*/
        foreach ($this->todoLists as $todoList) {
            if (strtolower($todoList->getTitle()) === strtolower($name)) {
                return true;
            }
        }
        return false;
    }

    public function update(): void {
        $_SESSION["account"] = self::serialize();

        ConnectionHandler::getInstance()->sendQuery("UPDATE user SET todoLists=:todoLists WHERE id=:id", [
            "todoLists" => json_encode($this->getSerializedTodoLists()),
            "id" => $this->getId()
        ]);
    }

    public function isValid(): bool {
        return $this->id != -1;
    }


}
<?php
/**
 * Created by Nick on 08 Mar 2020.
 * Copyright © ImSpooks
 */

namespace objects;


class Account implements Serializable {

    private int $id;
    private string $name;
    private string $email;
    private array $todoLists;
    private string $message = "";

    /**
     * Account constructor.
     * @param int $id
     * @param string $name
     * @param string $email
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

        $data["message"] = $this->message;
        return $data;
    }

    public static function deserialize(array $input): Serializable {
        $id = $input["id"];
        $name = $input["name"];
        $email = $input["email"];

        $todoLists = [];
        foreach ($input["todoLists"] as $item) {
            array_push($todoLists, TodoList::deserialize($item));
        }

        $account = new Account($id, $name, $email, $todoLists);
        $account->setMessage($input["message"]);
        return $account;
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

    public function getMessage(): string {
        return $this->message;
    }

    public function setMessage(string $message): void {
        $this->message = $message;
    }

    public function getTodoLists(): array {
        return $this->todoLists;
    }

    public function setTodoLists(array $todoLists): void {
        $this->todoLists = $todoLists;
    }
}
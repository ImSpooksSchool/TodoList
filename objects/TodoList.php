<?php
/**
 * Created by Nick on 17 feb. 2020.
 * Copyright © ImSpooks
 */

namespace objects;

class TodoList implements Serializable {

    private array $items;

    private string $title;

    public function __construct(string $title, array $items = []) {
        $this->items = $items;
        $this->title = $title;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function getItems(): array {
        return $this->items;
    }

    public function setItems(array $items): void {
        $this->items = $items;
    }

    public function getSerializedItems(): array {
        $todoLists = [];
        /** @var $list TodoItem*/
        foreach ($this->items as $list) {
            array_push($todoLists, $list->serialize());
        }
        return $todoLists;
    }

    public function addItem(TodoItem $todoList): void {
        array_push($this->items, $todoList);
    }

    public function removeItem(TodoItem $todoList): void {
        if (in_array($todoList, $this->items)) {
            unset($this->items[array_search($todoList, $this->items)]);
        }
    }

    public function hasItem(string $name): bool {
        /** @var $todoItem TodoItem*/
        foreach ($this->items as $todoItem) {
            if (strtolower($todoItem->getTitle()) === strtolower($name)) {
                return true;
            }
        }
        return false;
    }

    public function serialize(): array {
        $data = [];

        $data["title"] = $this->title;
        $data["items"] = [];

        /** @var TodoItem $item */
        foreach ($this->items as $item) {
            array_push($data["items"], $item->serialize());
        }

        return $data;
    }

    public static function deserialize(array $input): TodoList {
        $title = $input["title"];

        $items = [];
        foreach ($input["items"] as $item) {
            array_push($items, TodoItem::deserialize($item));
        }

        return new TodoList($title, $items);
    }
}
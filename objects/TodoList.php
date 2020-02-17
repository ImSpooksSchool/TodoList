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

    public static function deserialize(string $input): TodoList {
        $json = json_decode($input);
    }
}
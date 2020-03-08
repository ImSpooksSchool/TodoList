<?php
/**
 * Created by Nick on 17 feb. 2020.
 * Copyright © ImSpooks
 */

namespace objects;

class TodoItem implements Serializable {

    private string $title;
    private string $description;
    private TodoStatus $status;

    /**
     * TodoItem constructor.
     * @param string $title
     * @param string $description
     * @param TodoStatus $status
     */
    public function __construct(string $title, string $description, TodoStatus $status) {
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void {
        $this->description = $description;
    }

    /**
     * @return TodoStatus
     */
    public function getStatus(): TodoStatus {
        return $this->status;
    }

    /**
     * @param TodoStatus $status
     */
    public function setStatus(TodoStatus $status): void {
        $this->status = $status;
    }

    public function serialize(): array {
        $data = [];
        $data["title"] = $this->title;
        $data["description"] = $this->description;
        $data["status"] = $this->status->getValue();
        return $data;
    }

    public static function deserialize(array $input): TodoItem {
        return new TodoItem($input["title"], $input["description"], TodoStatus::getFromId($input["status"]));
    }


}
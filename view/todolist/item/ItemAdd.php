<?php

namespace view\todolist\item;

use handlers\ContentHandler;
use objects\Account;
use objects\TodoItem;
use objects\TodoList;
use objects\TodoStatus;
use view\init\AbstractView;

/**
 * Created by Nick on 08 Mar 2020.
 * Copyright © ImSpooks
 */


class ItemAdd extends AbstractView {

    public function render(Account $account, array $data): void {
        if (count($account->getTodoLists()) <= intval($data[0])) {
            ContentHandler::getInstance()->route("todolist");
            return;
        }

        /** @var TodoList $todoList */
        if (isset($_POST["add"])) {
            $todoList = $account->getTodoLists()[intval($data[0])];

            if (!$todoList->hasItem($_POST["title"])) {

                $todoList->addItem(new TodoItem($_POST["title"], $_POST["description"], TodoStatus::getFromId(intval($_POST["status"]))));
                $account->update();

                $this->addSuccess("Item added");
                $this->updateMessages();
                header("Location: " . URL);
                return;
            }
            else {
                $this->addWarning(sprintf("There is already exists an item with the name \"%s\"", $_POST["title"]));
            }
            $this->updateMessages();
        }
        ?>

        <form id="addForm" method="post" action="<?= URL ?>/todolist/additem/<?=$data[0]?>">
            <h1>Add item</h1>

            <div class="form-group">
                <label for="title">Title</label>
                <input id="title" type="text" class="form-control" name="title" placeholder="Title" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" type="text" class="form-control" name="description" placeholder="Description"></textarea>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" class="form-control" name="status" form="addForm">
                    <option value="0">Not started</option>
                    <option value="1">Started</option>
                    <option value="2">Finished</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="add">Add</button>
            </div>
        </form>
        <?php
    }
}
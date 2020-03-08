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


class ItemEdit extends AbstractView {

    public function render(Account $account, array $data): void {
        if (count($account->getTodoLists()) <= intval($data[0])) {
            ContentHandler::getInstance()->route("todolist");
            return;
        }

        /** @var TodoList $todoList */
        $todoList = $account->getTodoLists()[intval($data[0])];

        if (count($todoList->getItems()) <= intval($data[1])) {
            ContentHandler::getInstance()->route("todolist");
            return;
        }

        /** @var TodoItem $todoItem */
        $todoItem = $todoList->getItems()[intval($data[1])];

        if (isset($_POST["edit"])) {
            $todoItem->setTitle($_POST["title"]);
            $todoItem->setDescription($_POST["description"]);
            $todoItem->setStatus(TodoStatus::getFromId(intval($_POST["status"])));
            $account->update();

            $this->addSuccess("Item edited");
            $this->updateMessages();
            header("Location: " . URL);
            return;
        }
        ?>

        <form id="addForm" method="post" action="<?= URL ?>/todolist/item/edit/<?=$data[0]?>/<?=$data[1]?>">
            <h1>Edit list</h1>

            <div class="form-group">
                <label for="title">Title</label>
                <input id="title" type="text" class="form-control" name="title" placeholder="Title" value="<?=$todoItem->getTitle()?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" type="text" class="form-control" name="description" placeholder="Description"><?=$todoItem->getDescription()?></textarea>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" class="form-control" name="status" form="addForm">
                    <option value="0" <?php if ($todoItem->getStatus()->getValue() == 0) echo "selected"?>>Not started</option>
                    <option value="1" <?php if ($todoItem->getStatus()->getValue() == 1) echo "selected"?>>Started</option>
                    <option value="2" <?php if ($todoItem->getStatus()->getValue() == 2) echo "selected"?>>Finished</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-info" name="edit">Edit</button>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#removeModal">Remove item</button>
            </div>
        </form>

        <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to remove this item?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <a id="removeButton" type="button" class="btn btn-primary" href="<?= URL ?>/todolist/item/remove/<?=$data[0]?>/<?=$data[1]?>">Remove list</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
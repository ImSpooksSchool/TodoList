<?php

namespace view\todolist;

use handlers\ContentHandler;
use objects\Account;
use objects\TodoList;
use view\init\AbstractView;

/**
 * Created by Nick on 08 Mar 2020.
 * Copyright © ImSpooks
 */


class ListEdit extends AbstractView {

    public function render(Account $account, array $data): void {
        if (count($account->getTodoLists()) <= intval($data[0])) {
            ContentHandler::getInstance()->route("todolist");
            return;
        }

        /** @var TodoList $todoList */
        $todoList = $account->getTodoLists()[intval($data[0])];

        if (isset($_POST["edit"])) {
            $todoList->setTitle($_POST["title"]);
            $account->update();

            $this->addSuccess("Item edited");
            $this->updateMessages();
            header("Location: " . URL);
            return;
        }
        ?>

        <form id="addForm" method="post" action="<?= URL ?>/todolist/edit/<?=$data[0]?>">
            <h1>Edit list</h1>

            <div class="form-group">
                <label for="title">title</label>
                <input id="title" type="text" class="form-control" name="title" placeholder="Title" value="<?=$todoList->getTitle()?>" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-info" name="edit">Edit</button>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#removeModal">Remove list</button>
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
                        <p>Are you sure to remove this list?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <a id="removeButton" type="button" class="btn btn-primary" href="<?= URL ?>/todolist/remove/<?=$data[0]?>">Remove list</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
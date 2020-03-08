<?php

namespace view\todolist;

use objects\Account;
use objects\TodoList;
use view\init\AbstractView;

/**
 * Created by Nick on 08 Mar 2020.
 * Copyright © ImSpooks
 */


class ListAdd extends AbstractView {

    public function render(Account $account, array $data): void {
        if (isset($_POST["add"])) {
            if (!$account->hasTodoList($_POST["title"])) {

                $account->addTodoList(new TodoList($_POST["title"]));
                $account->update();

                $this->addSuccess("TodoList added");
                $this->updateMessages();
                header("Location: " . URL);
                return;
            }
            else {
                $this->addWarning(sprintf("There is already exists a list with the name \"%s\"", $_POST["title"]));
            }
            $this->updateMessages();
        }
        ?>

        <form method="post" action="<?= URL ?>/todolist/add">
            <h1>Add list</h1>

            <div class="form-group">
                <label for="title">title</label>
                <input id="title" type="text" class="form-control" name="title" placeholder="Title" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="add">Add</button>
            </div>
        </form>
        <?php
    }
}
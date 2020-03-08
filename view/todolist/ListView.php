<?php

namespace view\todolist;

use objects\Account;
use objects\TodoItem;
use objects\TodoList;
use view\init\AbstractView;

/**
 * Created by Nick on 08 Mar 2020.
 * Copyright © ImSpooks
 */


class ListView extends AbstractView {

    public function render(Account $account, array $data): void {
        /** @var TodoList $todoList */
        /** @var TodoItem $item */

        for ($sub = 0; $sub < count($account->getTodoLists()); $sub += 3) {
            ?>
            <div class="row">
            <?php
            for ($i = 0; $i < 3; $i++) {
                if (count($account->getTodoLists()) > $sub + $i) {
                    $todoList = $account->getTodoLists()[$sub + $i];

                    ?>
                    <div class="col-sm container card">
                        <h5 class=" card-title"><?=$todoList->getTitle()?></h5>

                        <?php
                        for ($j = 0; $j < count($todoList->getItems()); $j++) {
                            $item = $todoList->getItems()[$j];
                            ?>
                            <details class="card-body border rounded">
                                <summary class="card-title"><?=$item->getTitle()?></summary>
                                <p class="card-text"><?=$item->getDescription()?></p>
                                <p class="card-text">Status: <?=$item->getStatus()->getKey()?></p>

                                <div class="row">
                                    <a href="<?= URL ?>/todolist/item/edit/<?=$i?>/<?=$j?>" class="col-sm btn btn-success">Edit Item</a>
                                </div>
                            </details>
                            <?php
                        }
                        ?>

                        <div class="row">
                            <a href="<?= URL ?>/todolist/edit/<?=$i?>" class="col-sm btn btn-success">Edit</a>
                            <a href="<?= URL ?>/todolist/additem/<?=$i?>" class="col-sm btn btn-primary">Add item</a>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            </div>
            <?php
        }
        ?>
        <a href="<?= URL ?>/todolist/add" class="col-sm btn btn-primary">Add list</a>
        <?php
    }
}
<?php
/**
 * Created by Nick on 08 Mar 2020.
 * Copyright © ImSpooks
 */

namespace view\account;

use handlers\ConnectionHandler;
use objects\Account;
use objects\TodoList;
use view\init\AbstractView;

class LoginView extends AbstractView {

    function render(Account $account, array $data, ConnectionHandler $connectionHandler): void {
        if ($account->isValid()) {
            header("Location: " . URL);
            return;
        }

        if (isset($_POST["login_user"])) {

            $email = $_POST["email"];
            $password = $_POST["password"];

            $password = base64_encode(hash("sha256", $password));

//            echo json_encode($this->connectionHandler->sendQuery("SELECT * FROM members WHERE id=:id", ["id" => 1])) . "<br>";

            $this->addError("Email is required", empty($email));
            $this->addError("Password is required", empty($password));

            if (count($this->getErrors()) == 0) {
                $result = $connectionHandler->sendQuery("SELECT * FROM user WHERE email=:email AND password=:password", [
                        "email" => $email,
                        "password" => $password
                ]);

                if ($result->rowCount() == 1) {
                    $data = $result->fetch();

                    $todoLists = [];

                    foreach (json_encode($data["todoLists"]) as $todoList) {
                        array_push($todoLists, TodoList::deserialize($todoList));
                    }

                    $account = new Account($data["id"], $data["email"], $data["username"], $todoLists);

                    $_SESSION["account"] = $account->serialize();
                    $this->addSuccess("You are now logged in!");
                    $this->updateMessages();
                    header("Location: " . URL);
                    return;
                } else {
                    $this->addError("Account not found.");
                }
            }

            $this->updateMessages();
            $_POST = [];
            $this->render($account, $data, $connectionHandler);
            return;
        }

        ?>

        <form class="box" method="post" action="<?= URL ?>/account/login">
            <h1>Login</h1>

            <div class="input-group">
                <input type="text" name="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="login_user">Login</button>
            </div>
            <p>
                Not yet registered? <a href="<?= URL ?>/account/register">Register</a>!
            </p>
        </form>

        <?php
    }
}
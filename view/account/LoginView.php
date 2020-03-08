<?php
/**
 * Created by Nick on 08 Mar 2020.
 * Copyright © ImSpooks
 */

namespace view\account;

use handlers\ConnectionHandler;
use handlers\ContentHandler;
use objects\Account;
use objects\TodoList;
use view\init\AbstractView;

class LoginView extends AbstractView {

    function render(Account $account, array $data): void {
        if ($account->isValid()) {
            $this->addWarning("You are already logged in.");
            $this->updateMessages();
            ContentHandler::getInstance()->route("todolist/index");
            return;
        }

        if (isset($_POST["login_user"])) {

            $email = $_POST["email"];
            $password = $_POST["password"];

            $password = base64_encode(hash("sha256", $password));

//            echo json_encode(ConnectionHandler::getInstance()->sendQuery("SELECT * FROM members WHERE id=:id", ["id" => 1])) . "<br>";

            $this->addWarning("Email is required", empty($email));
            $this->addWarning("Password is required", empty($password));

            if (count($this->getWarnings()) == 0) {
                $result = ConnectionHandler::getInstance()->sendQuery("SELECT * FROM user WHERE email=:email AND password=:password", [
                        "email" => $email,
                        "password" => $password
                ]);

                if ($result->rowCount() == 1) {
                    $data = $result->fetch();

                    $todoLists = [];

                    foreach (json_decode($data["todoLists"], true) as $todoList) {
                        array_push($todoLists, TodoList::deserialize($todoList));
                    }

                    $account = new Account($data["id"], $data["email"], $data["username"], $todoLists);

                    $_SESSION["account"] = $account->serialize();

                    $this->addSuccess("You are now logged in!");
                    $this->updateMessages();
                    header("Location: " . URL);
                    return;
                } else {
                    $this->addWarning("Account not found.");
                }
            }

            $this->updateMessages();
            $_POST = [];
            $this->render($account, $data);
            return;
        }

        ?>

        <form method="post" action="<?= URL ?>/account/login">
            <h1>Login</h1>

            <div class="form-group">
                <input type="text" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="login_user">Login</button>
            </div>
            <p>
                Not yet registered? <a href="<?= URL ?>/account/register">Register</a>!
            </p>
        </form>

        <?php
    }
}
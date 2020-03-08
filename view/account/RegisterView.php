<?php
/**
 * Created by Nick on 08 Mar 2020.
 * Copyright © ImSpooks
 */


namespace view\account;


use handlers\ConnectionHandler;
use handlers\ContentHandler;
use objects\Account;
use view\init\AbstractView;

class RegisterView extends AbstractView {

    function render(Account $account, array $data): void {
        if ($account->isValid()) {
            $this->addWarning("You are already logged in.");
            $this->updateMessages();
            ContentHandler::getInstance()->route("todolist/index");
            return;
        }

        $username = isset($data["username"]) ? $data["username"] : "";
        $email = isset($data["email"]) ? $data["email"] : "";

        if (isset($_POST["reg_user"])) {
            $username =  $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $confirmedPassowrd = $_POST["confirmPassword"];

            $this->addWarning("Username is required", empty($username));
            $this->addWarning("Email is required", empty($email));
            $this->addWarning("Password is required", empty($password));
            $this->addWarning("The two passwords do not match", $password != $confirmedPassowrd);

            $user = ConnectionHandler::getInstance()->sendQuery("SELECT * FROM `user` WHERE username=:username OR email=:email", [
                    "username" => $username,
                    "email" => $email
            ])->fetch();

            if ($user) {
                $this->addWarning("Username already exists", $user["username"] === $username);
                $this->addWarning("Email is already registered", $user["email"] === $email);
            }

            if (count($this->getWarnings()) == 0) {
                $password = base64_encode(hash("sha256", $password));//encrypt the password before saving in the database

                $id = ConnectionHandler::getInstance()->sendQuery("SHOW TABLE STATUS LIKE 'user'")->fetch()["Auto_increment"];
                echo "ID = " . $id . "\n<br>";

                ConnectionHandler::getInstance()->sendQuery("INSERT INTO user (email, username, password) VALUES (:email, :username, :password)", [
                        "email" => $email,
                        "username" => $username,
                        "password" => $password
                ]);


                $account = new Account($id, $email, $username, []);
                $_SESSION["account"] = $account->serialize();
                $this->addSuccess("You are now logged in!");
                $this->updateMessages();
                header("Location: " . URL);
                return;
            }

            $this->updateMessages();

            $data["username"] = $username;
            $data["email"] = $email;

            $_POST = [];
            $this->render($account, $data);
            return;
        }

        ?>

        <form method="post" action="<?= URL ?>/account/register">
            <h1>Register</h1>

            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $username; ?>">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="example@gmail.com" value="<?php echo $email; ?>">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Confirm Password" name="confirmPassword">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="reg_user">Register</button>
            </div>
            <p>
                Already registered? <a href="<?= URL ?>/account/login">Log in</a>!
            </p>
        </form>
        <?php
    }
}
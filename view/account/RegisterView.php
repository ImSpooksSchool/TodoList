<?php
/**
 * Created by Nick on 08 Mar 2020.
 * Copyright © ImSpooks
 */


namespace view\account;


use handlers\ConnectionHandler;
use objects\Account;
use view\init\AbstractView;

class RegisterView extends AbstractView {

    function render(Account $account, array $data, ConnectionHandler $connectionHandler): void {
        if ($account->isValid()) {
            header("Location: " . URL);
            return;
        }
        $username = isset($data["username"]) ? $data["username"] : "";
        $email = isset($data["email"]) ? $data["email"] : "";

        if (isset($_POST["reg_user"])) {
            $username =  $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $confirmedPassowrd = $_POST["confirmPassword"];

            $this->addError("Username is required", empty($username));
            $this->addError("Email is required", empty($email));
            $this->addError("Password is required", empty($password));
            $this->addError("The two passwords do not match", $password != $confirmedPassowrd);

            $user = $connectionHandler->sendQuery("SELECT * FROM `user` WHERE username=:username OR email=:email", [
                    "username" => $username,
                    "email" => $email
            ])->fetch();

            if ($user) {
                $this->addError("Username already exists", $user["username"] === $username);
                $this->addError("Email is already registered", $user["email"] === $email);
            }

            if (count($this->getErrors()) == 0) {
                $password = base64_encode(hash("sha256", $password));//encrypt the password before saving in the database

                $id = $connectionHandler->sendQuery("SHOW TABLE STATUS LIKE 'user'")->fetch()["Auto_increment"];
                echo "ID = " . $id . "\n<br>";

                $connectionHandler->sendQuery("INSERT INTO user (email, username, password) VALUES (:email, :username, :password)", [
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
            $this->render($account, $data, $connectionHandler);
            return;
        }

        ?>

        <form class="box" method="post" action="<?= URL ?>/account/register">
            <h1>Register</h1>

            <div class="input-group">
                <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>">
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="example@gmail.com" value="<?php echo $email; ?>">
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="password">
            </div>
            <div class="input-group">
                <input type="password" placeholder="Confirm Password" name="confirmPassword">
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="reg_user">Register</button>
            </div>
            <p>
                Already registered? <a href="<?= URL ?>/account/login">Log in</a>!
            </p>
        </form>
        <?php
    }
}
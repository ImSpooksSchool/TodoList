<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <style>
        #container {
            display: grid;
            grid-template: "header"
                           "messages"
                           "content"
                           "footer"
        }

        #header {
            grid-area: header;
        }
        #messages {
            grid-area: messages;
        }
        #content {
            grid-area: content;
        }
        #footer {
            grid-area: footer;
        }
    </style>
</head>
<body>

<div id="container" class="container">
    <div id="header">
        <?php

        use objects\Account;

        if (isset($_SESSION["account"])) {
            $account = Account::deserialize($_SESSION["account"]);
            ?>

            <div>
                <p>Welcome, <?=$account->getName();?></p>
                <a href="<?= URL ?>/account/logout" class="col-sm btn btn-danger">Logout</a>
            </div>
            <?php
        }

        ?>
    </div>

    <div id="content" class="container">

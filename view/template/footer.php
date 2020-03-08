
        <div id="messages">
            <?php
            if (isset($_SESSION["msg"])) {
                foreach ($_SESSION["msg"] as $type => $data) {
                    foreach ($data as $message) {
                        echo "<div style=\"margin-top: 15px;\" class=\"alert alert-" . $type . "\" role=\"alert\">". $message ."</div>";
                    }
                }
                unset($_SESSION["msg"]);
            }
            ?>
        </div>

        <div id="footer">
            &copy; ImSpooks
        </div>


    </div>
</div>
</body>
</html>
<?php

require_once __DIR__ . "/../helpers/dbWrapper.php";

class CheckEmail {
    public function execute() {
        if (empty($_GET["email"])) {
            exit();
        }
        $email = $_GET["email"];
        $result = DB::run("SELECT * FROM `emails` WHERE `email` = '$email'")->num_rows;
        echo json_encode(boolval($result));
    }
}

(new CheckEmail)->execute();
<?php

require_once __DIR__ . "/../helpers/dbWrapper.php";

class DeleteEmail {
    public function execute(){
        if (isset($_GET["id"]) && !empty($_GET["id"])) {
            $id = $_GET["id"];
            var_dump($_GET["q"]);
            // DB::run("DELETE FROM `emails` WHERE `id` = $id");
            // header("Location: /admin");
        } else {
            // header("Location: /");
        }
    }
}

(new DeleteEmail)->execute();
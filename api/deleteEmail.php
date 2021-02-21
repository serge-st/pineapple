<?php

require_once __DIR__ . "/../helpers/dbWrapper.php";

class DeleteEmail {
    public function execute(){

        if (isset($_POST["id"]) && !empty($_POST["id"])) {
            $id = $_POST["id"];
            DB::run("DELETE FROM `emails` WHERE `id` = $id");
            $redirect = !empty($_POST["query"]) ? "?" . $_POST["query"] : "";
            header("Location: /admin$redirect");
        } else {
            header("Location: /");
        }
    }
}

(new DeleteEmail)->execute();
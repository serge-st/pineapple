<?php

require_once __DIR__ . "/../helpers/dbWrapper.php";

class InsertEmail {
    public function execute(){
        $data = json_decode(file_get_contents('php://input'), true);
        extract($data);
        DB::run("INSERT INTO `emails` (`email`, `provider`) VALUES ('$email', '$provider')");
    }
}

(new InsertEmail)->execute();
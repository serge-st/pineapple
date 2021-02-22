<?php

require_once __DIR__ . "/../helpers/dbWrapper.php";

class ExportCSV {
    public function execute() {
        $sql = "SELECT `created_date`, `email`, `provider` FROM `emails` WHERE `id` IN (";
        foreach(explode(",", $_POST["ids"]) as $id){
            $sql .= "'" . $id . "',";
        }
        $sql = rtrim($sql, ",") . ")";
        $result = DB::run($sql)->fetch_all(MYSQLI_ASSOC);
        $fp = fopen('export_emails.csv', 'w');
        fputcsv($fp, array("created_date","email","provider"));
        foreach($result as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);
        
        $file = "./export_emails.csv";
        header('Content-Description: File Transfer');
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename=' . "emails" . date("d_m_y_H-i-s", strtotime('1 hour')) . ".csv");
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        unlink('./export_emails.csv');
    }
}

(new ExportCSV)->execute();
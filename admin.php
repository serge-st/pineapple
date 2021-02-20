<?php

require_once __DIR__ . "/helpers/dbWrapper.php";

// $allData = DB::run("SELECT `created_date`, `email`, `provider` FROM `emails` ORDER BY `created_date` ASC")->fetch_all(MYSQLI_ASSOC);

$columns = array("created_date", "email", "provider");
$column = isset($_GET["column"]) && in_array(strtolower($_GET["column"]), $columns) ? strtolower($_GET["column"]) : $columns[0];
$sortOrder = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

$sql = "SELECT `created_date`, `email`, `provider` FROM `emails` ORDER BY `$column` $sortOrder";
$requestedData = DB::run($sql);

var_dump($sql);
var_dump($column);
var_dump($sortOrder);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="./static/styleSheets/Css/adminStyles.css">
    <title>Admin Page</title>
</head>
<body>
    <div>
        <table class="table">
        <thead>
            <tr>
            <th scope="col">Created On</th>
            <th scope="col">Email</th>
            <th scope="col">Provider</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <?php foreach($requestedData as $user) {?>
            <td><?=$user["created_date"]?></td>
            <td><?=$user["email"]?></td>
            <td><?=$user["provider"]?></td>
            </tr>
            <?php } ?>
        </tbody>
        </table>
    </div>   
</body>
</html>
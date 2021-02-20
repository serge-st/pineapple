<?php

require_once __DIR__ . "/helpers/dbWrapper.php";
// list of email providers
$providers = DB::run("SELECT DISTINCT `provider` from `emails`")->fetch_all();

// !!! NOTE !!! REWRITE FILTER CREATION IN HELPERS IN OOP STYLE
$columns = array("created_date", "email", "provider");
$column = isset($_GET["column"]) && in_array(strtolower($_GET["column"]), $columns) ? strtolower($_GET["column"]) : $columns[0];
$sortOrder = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

$up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sortOrder); 
$asc_or_desc = $sortOrder == 'ASC' ? 'desc' : 'asc';

// PROVIDER SELECTION
if (isset($_GET["provider"]) && !empty($_GET["provider"])){
    $selectedProvider = $_GET["provider"];
    $sql = "SELECT `id`, `created_date`, `email`, `provider` FROM `emails` WHERE `provider` = '$selectedProvider' ORDER BY `$column` $sortOrder";
} else {
    $sql = "SELECT `id`, `created_date`, `email`, `provider` FROM `emails` ORDER BY `$column` $sortOrder";
}

$requestedData = DB::run($sql);

var_dump($_GET);
var_dump($sql);
var_dump($column);
var_dump($sortOrder);
var_dump($up_or_down);
var_dump($asc_or_desc);

// SELECT `id`, `created_date`, `email`, `provider` FROM `emails` WHERE `provider` = 'gmail' ORDER BY `created_date` ASC



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <link rel="stylesheet" href="./static/styleSheets/Css/adminStyles.css">
    <title>Admin Page</title>
</head>
<body>
    <div class="main-container">
        <!-- TABLE WITH PROVIDER NAMES -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" colspan="<?=count($providers)?>">Sort By Provider:</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <?php foreach($providers as $provider) {?>
                    <td><a class="underline" href=""><?=$provider[0]?></a></td>
                    <?php } ?>
                </tr>
            </tbody>
        </table>
        
        <!-- TABLE WITH EMAILS -->
        <table class="table data-table">
        <thead>
            <tr>
            <th scope="col"><input type="checkbox" name="selectAll" id="selectAll"></th>

            <th scope="col"><a href="/admin?column=created_date&order=<?= $asc_or_desc; ?>">Created On<i class="fas fa-sort<?= $column == 'created_date' ? '-' . $up_or_down : ''; ?>"></i></a></th>

            <th scope="col"><a href="/admin?column=email&order=<?= $asc_or_desc; ?>">Email<i class="fas fa-sort<?= $column == 'email' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th scope="col"><a href="/admin?column=provider&order=<?= $asc_or_desc; ?>">Provider<i class="fas fa-sort<?= $column == 'provider' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($requestedData as $user) {?>
                <tr>
                <td><input type="checkbox" name="selectUser<?=$user['id']?>" id="selectUser<?=$user['id']?>"></td>
                <td><?=$user["created_date"]?></td>
                <td><?=$user["email"]?></td>
                <td><?=$user["provider"]?></td>
                <td><a href="/api/deleteEmail.php?id=<?=$user['id']?>"><i class="fas fa-user-minus"></i></a></td>
                </tr>
            <?php } ?>
        </tbody>
        </table>
    </div>   
</body>
</html>
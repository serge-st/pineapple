<?php

require_once __DIR__ . "/helpers/dbWrapper.php";
// list of email providers
$providers = DB::run("SELECT DISTINCT `provider` FROM `emails` ORDER BY `provider` ASC")->fetch_all();

// !!! NOTE !!! REWRITE FILTER CREATION IN HELPERS IN OOP STYLE
$columns = array("created_date", "email", "provider");
$column = isset($_GET["column"]) && in_array(strtolower($_GET["column"]), $columns) ? strtolower($_GET["column"]) : $columns[0];
$sortOrder = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

$up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sortOrder); 
$asc_or_desc = $sortOrder == 'ASC' ? 'desc' : 'asc';

// BASIC SETUP
$sql = "SELECT `id`, `created_date`, `email`, `provider` FROM `emails`";

// CREATE LINKS FOR EMAIL TABLE HEADER FILTERS
$createdDateLink = "/admin?column=created_date&order=$asc_or_desc";
$emailLink = "/admin?column=email&order=$asc_or_desc";
$providerLink = "/admin?column=provider&order=$asc_or_desc";

if (!empty($_GET["provider"]) && !empty($_GET["emailSearch"])){
    $selectedProvider = $_GET["provider"];
    $selectedEmail = $_GET["emailSearch"];
    $email = "%" . $_GET["emailSearch"] . "%";
    $sql .= " WHERE `provider` = '$selectedProvider' AND `email` LIKE '$email'";

    $createdDateLink .= "&provider=$selectedProvider&emailSearch=$selectedEmail";
    $emailLink .= "&provider=$selectedProvider&emailSearch=$selectedEmail";
    $providerLink .= "&provider=$selectedProvider&emailSearch=$selectedEmail";
    
} elseif (!empty($_GET["provider"])){
    // PROVIDER SELECTION
    $selectedProvider = $_GET["provider"];
    $sql .= " WHERE `provider` = '$selectedProvider'";

    // CREATE LINKS FOR EMAIL TABLE HEADER FILTERS
    $createdDateLink .= "&provider=$selectedProvider";
    $emailLink .= "&provider=$selectedProvider";
    $providerLink .= "&provider=$selectedProvider";
} elseif (!empty($_GET["emailSearch"])){
    // EMAIL SEARH
    $email = "%" . $_GET["emailSearch"] . "%";
    $selectedEmail = $_GET["emailSearch"];
    $sql .= " WHERE `email` like '$email'";
    var_dump("SQL BEFORE: " . $sql);

    // CREATE LINKS FOR EMAIL TABLE HEADER FILTERS
    $createdDateLink .= "&emailSearch=$selectedEmail";
    $emailLink .= "&emailSearch=$selectedEmail";
    $providerLink .= "&emailSearch=$selectedEmail";

    var_dump($createdDateLink);
}


// FROMING FINAL SQL QUERY:
$sql .= " ORDER BY `$column` $sortOrder";
var_dump("FINAL SQL: " . $sql);
$requestedData = DB::run($sql);


// var_dump($_SERVER["REQUEST_URI"]);
// var_dump($_SERVER);
// var_dump($_SERVER["QUERY_STRING"]);

// var_dump(isset($selectedProvider) ? "/admin?column=created_date&order=$asc_or_desc" . "&provider=" . $selectedProvider : "/admin?column=created_date&order=$asc_or_desc");
// var_dump("/admin?column=created_date&order=$asc_or_desc");


// if (isset($_GET["provider"]) && !empty($_GET["provider"])) {
//     var_dump($_GET["provider"]);
// } 
// var_dump($sql);
// var_dump($column);
// var_dump($sortOrder);
// var_dump($up_or_down);
// var_dump($asc_or_desc);

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
        <!-- SEARCH FIELD -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Search Email:</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <form action="/admin" method="GET">
                            <input type="text" placeholder="provider" name="provider" value="<?= isset($selectedProvider) ? $selectedProvider : "" ?>">
                            <input type="text" name="emailSearch">
                            <button type="submit" >Search</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- TABLE WITH PROVIDER NAMES -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" colspan="<?=1 . count($providers)?>">Sort By Provider:</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a class="underline" href="/admin">All</a></td>
                    <?php foreach($providers as $provider) {?>
                    <td><a class="underline" href="/admin<?= "?provider=" .  $provider[0];?>"><?=$provider[0]?></a></td>
                    <?php } ?>
                </tr>
            </tbody>
        </table>
        
        <!-- TABLE WITH EMAILS -->
        <table class="table data-table">
        <thead>
            <tr>
            <th scope="col"><input class="select-all-checkbox" type="checkbox" name="selectAll" id="selectAll"></th>

            <th scope="col"><a href="<?= $createdDateLink; ?>">Created Date<i class="fas fa-sort<?= $column == 'created_date' ? '-' . $up_or_down : ''; ?>"></i></a></th>

            <th scope="col"><a href="<?= $emailLink; ?>">Email<i class="fas fa-sort<?= $column == 'email' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th scope="col"><a href="<?= $providerLink; ?>">Provider<i class="fas fa-sort<?= $column == 'provider' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($requestedData as $user) {?>
                <tr>
                <td><input class="user-checkbox" type="checkbox" name="selectUser<?=$user['id']?>" id="selectUser<?=$user['id']?>"></td>
                <td><?=$user["created_date"]?></td>
                <td><?=$user["email"]?></td>
                <td><?=$user["provider"]?></td>
                <!-- <td><a href="/api/deleteEmail.php?id=<?=$user['id']?>&q='<?= $_SERVER["QUERY_STRING"];?>'"><i class="fas fa-user-minus"></i></a></td> -->

                <td>
                    <form action="/api/deleteEmail" method="post">
                    <input type="hidden" name="query" value="<?= $_SERVER["QUERY_STRING"];?>">
                        <button class="delete-btn" type="submit" name="id" value="<?= $user['id'] ;?>"><i class="fas fa-user-minus"></i></button>
                    </form>
                </td>
                </tr>
            <?php } ?>
        </tbody>
        </table>
    </div>   
</body>
</html>
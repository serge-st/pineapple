<?php

require_once __DIR__ . "/helpers/dbWrapper.php";
// GET LIST OF EMAIL PROVIDERS
$providers = DB::run("SELECT DISTINCT `provider` FROM `emails` ORDER BY `provider` ASC")->fetch_all();

// EMAIL FILTERS
$columns = array("created_date", "email", "provider");
$column = isset($_GET["column"]) && in_array(strtolower($_GET["column"]), $columns) ? strtolower($_GET["column"]) : $columns[0];
$sortOrder = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';

$up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sortOrder); 
$asc_or_desc = $sortOrder == 'ASC' ? 'desc' : 'asc';

// BASIC QUERY SETUP
$sql = "SELECT `id`, `created_date`, `email`, `provider` FROM `emails`";

// CREATE LINKS FOR EMAIL TABLE HEADER FILTERS
$createdDateLink = "/admin?column=created_date&order=$asc_or_desc";
$emailLink = "/admin?column=email&order=$asc_or_desc";
$providerLink = "/admin?column=provider&order=$asc_or_desc";

if (!empty($_GET["provider"]) && !empty($_GET["emailSearch"])){
    // SEARCH AND PROVIDER SELECTION TOGETHER
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

    $createdDateLink .= "&provider=$selectedProvider";
    $emailLink .= "&provider=$selectedProvider";
    $providerLink .= "&provider=$selectedProvider";
} elseif (!empty($_GET["emailSearch"])){
    // EMAIL SEARH
    $email = "%" . $_GET["emailSearch"] . "%";
    $selectedEmail = $_GET["emailSearch"];
    $sql .= " WHERE `email` like '$email'";

    $createdDateLink .= "&emailSearch=$selectedEmail";
    $emailLink .= "&emailSearch=$selectedEmail";
    $providerLink .= "&emailSearch=$selectedEmail";
}

// FROMING FINAL SQL QUERY:
$sql .= " ORDER BY `$column` $sortOrder";
$requestedData = DB::run($sql);

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
    
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>

    <title>Admin Page</title>
</head>
<body>
    <div class="main-container" id="root">

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
                            <input type="hidden" name="provider" value="<?= isset($selectedProvider) ? $selectedProvider : "" ?>">
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
                    <td><a class="underline" href="/admin<?= "?provider=" .  $provider[0];?><?=!empty($_GET['emailSearch']) ? "&emailSearch=" . $_GET['emailSearch'] : "" ;?>"><?=$provider[0]?></a></td>
                    <?php } ?>
                </tr>
            </tbody>
        </table>
        
        <!-- TABLE WITH EMAILS -->
        <table class="table data-table">
        <thead>
            <tr>
            <th scope="col"><input @click="selectAll" v-model="allCheckboxesSelected" class="select-all-checkbox" type="checkbox" name="selectAll" id="selectAll"></th>

            <th scope="col"><a href="<?= $createdDateLink; ?>">Created Date<i class="fas fa-sort<?= $column == 'created_date' ? '-' . $up_or_down : ''; ?>"></i></a></th>

            <th scope="col"><a href="<?= $emailLink; ?>">Email<i class="fas fa-sort<?= $column == 'email' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th scope="col"><a href="<?= $providerLink; ?>">Provider<i class="fas fa-sort<?= $column == 'provider' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($requestedData as $user) {?>
                <tr>
                <td>
                    <email-checkbox @pass-id="processSelected" id="<?=$user['id']?>" ref="<?=$user['id']?>" available-count="<?=$user['id']?>"></email-checkbox>
                </td>
                <td><?=$user["created_date"]?></td>
                <td><?=$user["email"]?></td>
                <td><?=$user["provider"]?></td>


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

        <!-- EXPORT TO CSV -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Export Checked Emails To CSV:</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <form action="/api/exportCSV.php" method="POST">
                            <!-- PASS SELECTED EMAIL IDS -->
                            <input type="hidden" name="ids" v-model="selectedCheckboxes">

                            <button type="submit" :disabled="!selectedCheckboxes.length">EXPORT</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>   
    <script src="./js/admin/admin.js"></script>
</body>
</html>
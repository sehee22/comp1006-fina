<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
<div>

    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="default.php">Travel Bug</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                require_once('db.php');

                $sql = "SELECT * FROM regions;";
                $cmd = $db->prepare($sql);
                $cmd->execute();
                $regions = $cmd->fetchAll();

                //loop through results to create links to region page
                foreach ($regions as $region) {
                    echo '<li><a href="destinations.php?regionId=' . $region['regionId'] . '">' . $region['name'] . '</a></li>';
                }
                echo '<li><a href="destination_api.php">API</a></li>';
                ?>
            </ul>
        </div>
    </nav>
</div>

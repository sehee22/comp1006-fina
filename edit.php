<?php
$title = "Destination Details";
require('header.php');


// initialize variables
$name = null;
$location = null;
$description = null;
$photo = null;
$regionId = null;
$region = null;
$destinationId = null;


// was an existing id passed to this page? If so, select the matching record from the DB
if (!empty($_GET['destinationId']))
{
    $destinationId = $_GET['destinationId'];

    //connect
    require('db.php');

    // set up and execute the query
    $sql = "SELECT * FROM destinations WHERE destinationId = :destinationId";
    $cmd = $db->prepare($sql);
    $cmd->bindParam(':destinationId', $destinationId, PDO::PARAM_INT);
    $cmd->execute();
    $dst = $cmd->fetch();

    // store each column value in a variable
    $name = $dst['name'];
    $location = $dst['location'];
    $description = $dst['description'];
    $regionId = $dst['regionId'];
    $photo = $dst['photo'];

    // region info
    $sql = "";
    $sql = "SELECT * FROM regions WHERE regionId =" . $regionId;
    $cmd = $db->prepare($sql);
    $cmd->bindParam(':regionId', $regionId, PDO::PARAM_INT);
    $cmd->execute();
    $rsn = $cmd->fetch();

    // store
    $region = $rsn['name'];

    // disconnect
    $db = null;
}
?>

<h1>Destination Details</h1>


<form method="post" action="update.php" enctype="multipart/form-data">
    <fieldset>
        <label for="name" class="col-md-1">Name: </label>
        <input name="name" id="name" required value="<?php echo $name; ?>" />
    </fieldset>
    <fieldset>
        <label for ="location" class="col-md-1">Location: </label>
        <input name="location" id="location" required value="<?php echo $location; ?>" />
    </fieldset>
    <fieldset>
        <label for ="description" class="col-md-1">Description: </label>
        <textarea name="description" id="description" required><?php echo $description; ?></textarea>
    </fieldset>
    <fieldset>
        <label for="rst_tp" class="col-md-1">Type: </label>
        <select name="rst_tp" id="rst_tp">
            <?php

            //connect
            require('db.php');

            // set up query
            $sql = "SELECT name FROM regions";
            $cmd = $db->prepare($sql);
            $cmd->bindParam(':regionId', $regionId, PDO::PARAM_INT);

            // fetch the results
            $cmd->execute();
            $region = $cmd->fetchAll();

            // loop through and create a new option tag for each type
            foreach ($region as $r)
            {
                if ($r['name'] == $region)
                {
                    echo "<option selected> {$r['name']}</option>";
                }
                else
                {
                    echo "<option>{$r['name']}</option>";
                }
            }


            // disconnect
            $db = null;
            ?>
        </select>
    </fieldset>
    <fieldset>
        <label for="photo" class="col-md-1">Photo:</label>
        <input type="file" name="photo" id="photo" />
    </fieldset>
    <div class="col-md-offset-1">
        <?php
        if (isset($photo)) {
            echo "<img src=\"img/$photo\" alt=\"Destination Photo\" />";
        }
        ?>
    </div>
    <button class="col-md-offset-1 btn btn-primary">Save</button>
    <input type="hidden" name ="destinationId", id="destinationId" value=<?php echo $destinationId; ?>" />


</form>

<?php require('footer.php'); ?>
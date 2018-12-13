<?php
$title = "Region Detail";

require('header.php');
require('db.php');


if (is_numeric($_GET['regionId'])) {
    $regionId = $_GET['regionId'];


    //set up query
    $sql = "SELECT * FROM destinations WHERE regionId = :regionId";
    $cmd = $db->prepare($sql);
    $cmd->bindParam(':regionId', $regionId, PDO::PARAM_INT);
    $cmd->execute();
    $regionId = $cmd->fetchAll();

    echo '<table class="table table-striped table-hover sortable"><thead><th>Name</th><th>Location</th><th>Photo</th><th>Edit</th></thead>';


    foreach ($regionId as $r) {
        echo "<tr>
                        <td> {$r['name']} </td>
                        <td> {$r['location']} </td>";
        if (isset($r['photo']))
        {
            echo "<td><img src=\"img/{$r['photo']}\" alt=\"Destination Photo\" width=\"100px\" /></td>";
        } else
        {
            echo "<td></td>";
        }
        echo "<td><a href=\"edit.php?destinationId={$r['destinationId']}\">Edit</a></td>";

        echo "</tr>";
    }
    // close the table
    echo '</table>';

    // disconnect
    $db = null;
}
else
{
    header('location:default.php');
}
?>

<?php require('footer.php'); ?>
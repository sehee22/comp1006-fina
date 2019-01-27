<?php
$title = "Destination API";

require('header.php');

// connect
require('db.php');
// set up the query
$sql = "SELECT * FROM destinations";
// check for an id parameter
$destinationId = null;
$name = null;
if (isset($_GET['destinationId']))
{
    $sql .= " WHERE destinationId = :destinationId";
    $destinationId = $_GET['destinationId'];
}
if (isset($_GET['name']))
{
    $sql .= " WHERE name = :name";
    $name = $_GET['name'];
}
// execute the query & return the results as an array
$cmd = $db->prepare($sql);
if (isset($destinationId))
{
    $cmd->bindParam(':destinationId', $destinationId, PDO::PARAM_INT);
}
if (isset($name))
{
    $cmd->bindParam(':name', $name, PDO::PARAM_STR, 255);
}
$cmd->execute();
$destinations = $cmd->fetchAll(PDO::FETCH_ASSOC);
// return the results as json
echo json_encode($destinations);
// disconnect
$db = null;

?>

<?php require('footer.php'); ?>
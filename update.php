<?php
require('header.php');

// introduce variables to store the form input variables
$name = $_POST ['name'];
$location = $_POST ['location'];
$description = $_POST ['description'];
$destinationId = $_POST['destinationId'];
//$regionId = $_POST['regionId'];

//$region = $_POST['region'];
$photo = null;

// validate each input
$ok = true;

if (empty($name))
{
    echo "Name is Required. <br />";
    $ok = false;
}
if (empty($location))
{
    echo "Location is Required. <br />";
    $ok = false;
}
/*
if ($region == '-Select-')
{
    echo "Region is Required. </br>";
    $ok = false;
}
*/
// check and validate photo upload
if (isset($_FILES['photo']))
{
    $photoFile = $_FILES['photo'];

    if ($photoFile['size'] > 0)
    {
        // generate unique file name
        $photo = session_id() . "-" . $photoFile['name'];

        // check file type
        $fileType = null;
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileType = finfo_file($finfo, $photoFile['tmp_name']);

        // allow only jpeg & png
        if (($fileType != "image/jpeg") && ($fileType != "image/jpg"))
        {
            echo 'Please upload a valid JPG photo<br />';
            $ok = false;
        }
        else
        {
            // save the file
            move_uploaded_file($photoFile['tmp_name'], "img/{$photo}");
        }
    }

}
// connect to the database with server, username, password, dbname
// only save if no validation errors
if ($ok)
{
    // PDO : PHP Database Object (regardless the database, we can use any type database system
    require('db.php');

    $sql = "UPDATE destinations SET name = :name, location = :location, description = :description, photo = :photo WHERE destinationId = :destinationId";
    // set up and execute an INSERT command

    $cmd = $db->prepare($sql);
    $cmd->bindParam(':name', $name, PDO::PARAM_STR, 255);
    $cmd->bindParam(':location', $location, PDO::PARAM_STR, 255);
    $cmd->bindParam(':description', $description, PDO::PARAM_STR, 2000);
    $cmd->bindParam(':photo', $photo, PDO::PARAM_STR, 255);
    $cmd->bindParam(':destinationId', $destinationId, PDO::PARAM_INT);
    //$cmd->bindParam(':regionId', $regionId, PDO::PARAM_INT);


    $cmd->execute();

    // disconnect!!! after inserting, disconnect from the database
    $db = null;

    header('location:default.php');
}

?>

<?php require('footer.php'); ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once ("../../files/settings.php");
    $conn = new mysqli($host, $user, $pswd, $dbnm);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //drop table
    $sql = "DROP TABLE status";

    if (mysqli_query($conn, $sql)) {
        $success = "Table dropped successfully";
    } else {
        $failure = "Error dropping table: " . mysqli_error($conn);
    }

    //close connection
    mysqli_close($conn);
} else {
    //if invalid go to about
    header("Location: about.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset DB</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body>
    <header class="bg-info text-white p-4">
        <div class="container text-center">

            <h1 class="display-4 mb-0">
                Status Posting System
            </h1>
        </div>
    </header>
    <div class="content text-center mt-4">
        <?php
        if (isset($failure)) {
            echo '<div class="alert alert-danger" role="alert">' . $failure . '</div>';
        } elseif (isset($success)) {
            echo '<div class="alert alert-success" role="alert">' . $success . '</div>';
        }
        ?>
        <a href="index.html" class="btn btn-secondary mr-2">Return to Home Page</a>
    </div>
</body>

</html>
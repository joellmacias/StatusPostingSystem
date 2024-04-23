<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once ("../../files/settings.php");
    $conn = new mysqli($host, $user, $pswd, $dbnm);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //query to check if the table exists
    $tableExistsQuery = "SHOW TABLES LIKE 'status'";
    $tableExistsResult = mysqli_query($conn, $tableExistsQuery);

    //create table if it doesn't exist
    if (mysqli_num_rows($tableExistsResult) == 0) {
        $createTableQuery = "CREATE TABLE status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status_code VARCHAR(5) UNIQUE NOT NULL,
    status_text TEXT NOT NULL,
    share_option ENUM('University', 'Class', 'Private') NOT NULL,
    status_date DATE NOT NULL,
    allow_likes BOOLEAN NOT NULL DEFAULT 0,
    allow_comments BOOLEAN NOT NULL DEFAULT 0,
    allow_shares BOOLEAN NOT NULL DEFAULT 0
)";
        mysqli_query($conn, $createTableQuery);

    }

    //Input data from form
    $status_code = $_POST['status_code'];
    $status_text = $_POST['status'];
    $share_option = isset($_POST['share']) ? $_POST['share'] : null;
    $status_date = $_POST['date'];
    $allow_likes = isset($_POST['allow_likes']) ? 1 : 0;
    $allow_comments = isset($_POST['allow_comments']) ? 1 : 0;
    $allow_shares = isset($_POST['allow_share']) ? 1 : 0;

    //date validation 
    $date_validation = explode('-', $status_date);

    if (count($date_validation) !== 3) {
        $error_message = "The date is in the wrong format! Please enter the date in the format of DD/MM/YYYY.";
    }

    $year = $date_validation[0];
    $month = $date_validation[1];
    $day = $date_validation[2];

    //status code validation
    if (!preg_match("/^S\d{4}$/", $status_code)) {
        $error_message = "Wrong format! The status code must start with an “S” followed by four digits, like “S0001.";
    }
    //check if status is in the database
    elseif ($conn->query("SELECT * FROM status WHERE status_code = '$status_code'")->num_rows > 0) {
        $error_message = "The status code already exists. Please try another one!";
    }
    //status text validation
    elseif (!preg_match("/^[a-zA-Z0-9\s,.!?]*$/", $status_text) || $status_text == "") {
        $error_message = "Your status is in a wrong format! The status can only contain
        alphanumericals and spaces, comma, period, exclamation point and question mark
        and cannot be blank!";
    }
    //check date validation
    elseif (!checkdate($month, $day, $year)) {
        $error_message = "The date is in the wrong format! Please enter the date in the format of DD/MM/YYYY.";
    }
    //load into the database
    else {
        $sql = "INSERT INTO status (status_code, status_text, share_option, status_date, allow_likes, allow_comments, allow_shares) VALUES ('$status_code', '$status_text', '$share_option', '$status_date', '$allow_likes', '$allow_comments', '$allow_shares')";
        if (mysqli_query($conn, $sql)) {
            $confirmation_message = "Congratulations! The status has been posted!";
        } else {
            $error_message = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    //close database connection
    mysqli_close($conn);

} else {
    //if request is not valid send back to poststatusform
    header("Location: poststatusform.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        if (isset($error_message)) {
            echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
        } elseif (isset($confirmation_message)) {
            echo '<div class="alert alert-success" role="alert">' . $confirmation_message . '</div>';
        }
        ?>
        <a href="poststatusform.php" class="btn btn-primary mr-2">Return to Post Status Form</a>
        <a href="index.html" class="btn btn-secondary mr-2">Return to Home Page</a>
    </div>
</body>

</html>
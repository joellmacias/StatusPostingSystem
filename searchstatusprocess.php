<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    require_once ("../../files/settings.php");
    $conn = new mysqli($host, $user, $pswd, $dbnm);

    //check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //check if table exists
    $tableExistsQuery = "SHOW TABLES LIKE 'status'";
    $tableExistsResult = mysqli_query($conn, $tableExistsQuery);
    $status_text = $_GET['status'];

    //table doesnt exist, go to post 
    if (mysqli_num_rows($tableExistsResult) == 0) {
        $error_message = "No status found in the system. Please go to the post status page to post one.";
    }

    //check if status text is empty including whitespace
    elseif (trim($status_text) == "") {
        $error_message = "The search string is empty. Please enter a keyword to search.";
    }
    //search for status from status text
    else {
        $sql = "SELECT * FROM status WHERE status_text LIKE '%$status_text%'";
        $result = mysqli_query($conn, $sql);

        //status not found
        if (mysqli_num_rows($result) == 0) {
            $error_message = "Status not found. Please try a different keyword.";
        }

    }
    //close the database connection
    mysqli_close($conn);
} else {
    //if invalid go to search status
    header("Location: searchstatusform.html");
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
    <div class="content">
        <header class="bg-info text-white p-4">
            <div class="container text-center">

                <h1 class="display-4 mb-0">
                    Status Posting System
                </h1>
            </div>
        </header>
        <?php
        // Check if there is an error message
        if (isset($error_message)) {
            echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
        } elseif (isset($result) && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="card mb-3">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title"><strong>Status:</strong> ' . $row["status_text"] . '</h5>';
                echo '<p class="card-text"><strong>Status Code:</strong> ' . $row["status_code"] . '</p>';
                echo '<p class="card-text"><strong>Share:</strong> ' . $row["share_option"] . '</p>';
                echo '<p class="card-text"><strong>Date Posted:</strong> ' . $row["status_date"] . '</p>';
                echo '<p class="card-text"><strong>Permission:</strong> ';
                echo '<ul>';
                if ($row["allow_likes"] == 1) {
                    echo '<li>Allow Like</li>';
                }
                if ($row["allow_shares"] == 1) {
                    echo '<li>Allow Share</li>';
                }
                if ($row["allow_comments"] == 1) {
                    echo '<li>Allow Comment</li>';
                }
                echo '</ul>';
                echo '</div>';
                echo '</div>';
            }
        } 
        ?>
        <div class="content text-center mt-4">
            <a href="poststatusform.php" class="btn btn-primary mr-2">Return to Post Status Form</a>
            <a href="searchstatusform.html" class="btn btn-secondary mr-2">Return to Search Status Form</a>
            <a href="index.html" class="btn btn-info">Return to Home Page</a>
        </div>
    </div>

</body>

</html>
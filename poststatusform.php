<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Status Formt</title>
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
    <div class="container form-container text-center mt-4">
        <form action="poststatusprocess.php" method="post">
            <label for="status_code"><strong>Status Code:</strong></label>
            <input type="text" name="status_code" id="stcode" required>
            <br>
            <label for="status"><strong>Status:</strong></label>
            <input type="text" name="status" id="st" required>
            <br>
            <label for="share"><strong>Share:</strong></label>
            <input type="radio" name="share" value="University" required>University
            <input type="radio" name="share" value="Class">Class
            <input type="radio" name="share" value="Private">Private
            <br>
            <label for="date"><strong>Date:</strong></label>
            <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
            <br>
            <label for="permission"><strong>Permission:</strong></label>
            <input type="checkbox" name="allow_likes" id="allow_likes">
            <label for="allow_likes">Allow Like</label>
            <input type="checkbox" name="allow_comments" id="allow_comments">
            <label for="allow_comments">Allow Comment</label>
            <input type="checkbox" name="allow_share" id="allow_share">
            <label for="allow_share">Allow Share</label>
            <br>
            <input type="submit" class="btn btn-primary" value="Submit">
            <br>
            <a href="index.html" class="btn btn-secondary mt-4">Return to Home Page</a>
        </form>
</body>
</div>

</html>
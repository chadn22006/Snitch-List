<!-- 
Copyright (c) 2025 Chad Nelson (chadn22006@gmail.com)

#Permission is hereby granted, free of charge, to any person obtaining a #copy of this software and associated documentation files (the "Software"), #to deal in the Software without restriction, including without limitation #the rights to use, copy, modify, merge, publish, distribute, sublicense, #and/or sell copies of the Software, and to permit persons to whom the #Software is furnished to do so, subject to the following conditions:

#The above copyright notice and this permission notice shall be included in #all copies or substantial portions of the Software.

#Translation: Ofcourse you can use this for you project! Just make sure to #say where you got this from :)

#THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR #IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, #FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE #AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER #LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING# #FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER #DEALINGS IN THE SOFTWARE. 
-->





<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "records";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$age = $_POST['age'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$why = $_POST['why'];
$other = $_POST['other'];
$spicture = $_FILES['spicture']['name'];
$spicture_tmp = $_FILES['spicture']['tmp_name'];
$spicture_path = "uploads/" . basename($spicture);

// Move profile picture to uploads directory
move_uploaded_file($spicture_tmp, $spicture_path);

// Insert person details
$sql = "INSERT INTO people (name, age, city, state, zip, why, other, spicture) VALUES ('$name', '$age', '$city', '$state', '$zip', '$why', '$other', '$spicture_path')";
$conn->query($sql);
$person_id = $conn->insert_id;

// Handle file uploads
foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
    $file_name = $_FILES['files']['name'][$key];
    $file_tmp = $_FILES['files']['tmp_name'][$key];
    $file_path = "uploads/" . basename($file_name);

    // Move file to uploads directory
    move_uploaded_file($file_tmp, $file_path);

    // Insert file details into the database
    $sql = "INSERT INTO files (person_id, file_path, original_name) VALUES ('$person_id', '$file_path', '$file_name')";
    $conn->query($sql);
}



$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
    <script>
        // Countdown timer
        let countdown = 10;
        function updateCountdown() {
            document.getElementById('countdown').innerText = countdown;
            countdown--;
            if (countdown < 0) {
                window.location.href = 'index.html'; // Replace with your destination URL
            }
        }

        // Start countdown on page load
        window.onload = function() {
            setInterval(updateCountdown, 1000);
        }
    </script>
</head>
<body>
    <p>Submission successful! Redirecting in <span id="countdown">10</span> seconds...</p>
</body>
</html>

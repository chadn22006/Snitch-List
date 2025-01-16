<!-- 
Copyright (c) 2025 Chad Nelson (chadn22006@gmail.com)

#Permission is hereby granted, free of charge, to any person obtaining a #copy of this software and associated documentation files (the "Software"), #to deal in the Software without restriction, including without limitation #the rights to use, copy, modify, merge, publish, distribute, sublicense, #and/or sell copies of the Software, and to permit persons to whom the #Software is furnished to do so, subject to the following conditions:

#The above copyright notice and this permission notice shall be included in #all copies or substantial portions of the Software.

#Translation: Ofcourse you can use this for you project! Just make sure to #say where you got this from :)

#THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR #IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, #FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE #AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER #LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING# #FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER #DEALINGS IN THE SOFTWARE. 
-->




<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Connect to the database (make sure to replace with your own connection parameters)
    $mysqli = new mysqli("localhost", "root", "", "records");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Fetch person details
    $person_query = "SELECT * FROM people WHERE id = $id";
    $person_result = $mysqli->query($person_query);

    if ($person_result && $person_result->num_rows > 0) {
        $person = $person_result->fetch_assoc();
    } else {
        echo "No person found with ID: $id";
        exit;
    }

    // Fetch uploaded files
    $files_query = "SELECT * FROM files WHERE person_id = $id";
    $files_result = $mysqli->query($files_query);

    if (!$files_result) {
        echo "Query Error: " . $mysqli->error;
        exit;
    }
} else {
    echo "Invalid ID";
    exit;
}
?>

<h1><?php echo $person['name']; ?></h1>
<p>Age: <?php echo $person['age']; ?></p>
<p>Location: <?php echo $person['city']; ?>, <?php echo $person['state']; ?> <?php echo $person['zip']; ?></p>
<p>Why (Why is this person a snitch?): <?php echo $person['why']; ?></p>
<p>Other Important Details/notes: <?php echo $person['other']; ?></p>
<img src="<?php echo $person['spicture']; ?>" alt="Snitch Picture" class="img-fluid mb-3">

<h2>Uploaded Files:</h2>
<ul>
    <?php while ($file = $files_result->fetch_assoc()) { ?>
        <li><a href="<?php echo $file['file_path']; ?>" download><?php echo $file['original_name']; ?></a></li>
    <?php } ?>
</ul>

<?php
$mysqli->close();
?>

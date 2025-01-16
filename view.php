<?php
// Your code above

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snitch Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Button to Open the Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#personDetailsModal">
        View Person Details
    </button>

    <!-- The Modal -->
    <div class="modal fade" id="personDetailsModal" tabindex="-1" role="dialog" aria-labelledby="personDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="personDetailsModalLabel"><?php echo $person['name']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Age: <?php echo $person['age']; ?></p>
                    <p>Location: <?php echo $person['city']; ?>, <?php echo $person['state']; ?> <?php echo $person['zip']; ?></p>
                    <p>Why: <?php echo $person['why']; ?></p>
                    <p>Other details/notes: <?php echo $person['other']; ?></p>
                    <img src="<?php echo $person['spicture']; ?>" alt="Snitch Picture" class="img-fluid mb-3">

                    <h2>Uploaded Files:</h2>
                    <ul>
                        <?php while ($file = $files_result->fetch_assoc()) { ?>
                            <li><a href="<?php echo $file['file_path']; ?>" download><?php echo $file['original_name']; ?></a></li>
                        <?php } ?>
                    </ul>

                    <hr>
                    <!-- Form inside the modal -->
                    <form action="submit.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Age:</label>
                            <input type="number" class="form-control" id="age" name="age" required>
                        </div>
                        <div class="form-group">
                            <label for="city">City:</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="state">State:</label>
                            <input type="text" class="form-control" id="state" name="state" required>
                        </div>
                        <div class="form-group">
                            <label for="zip">ZIP Code:</label>
                            <input type="text" class="form-control" id="zip" name="zip" required>
                        </div>
                        <div class="form-group">
                            <label for="why">Why:</label>
                            <textarea class="form-control" id="why" name="why" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="other">Other:</label>
                            <textarea class="form-control" id="other" name="other" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="spicture">Snitch Picture (optional):</label>
                            <input type="file" class="form-control-file" id="spicture" name="spicture" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="files">Upload Proof (optional):</label>
                            <input type="file" class="form-control-file" id="files" name="files[]" multiple>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$mysqli->close();
?>

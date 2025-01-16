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

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, age FROM people ORDER BY name";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of People</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: black;
        }
        h2 {
            color: white;
        }
        .list-group-item {
            color: blue;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>List of People</h2>
        <ul class="list-group">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <li class="list-group-item text-primary">
                    <a href="#" class="person-link" data-id="<?php echo $row['id']; ?>"><?php echo $row['name']; ?> (Age: <?php echo $row['age']; ?>)</a>
                </li>
            <?php } ?>
        </ul>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="personDetailsModal" tabindex="-1" role="dialog" aria-labelledby="personDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="personDetailsModalLabel">Person Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body-content">
                    <!-- Person details will be loaded here via Ajax -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.person-link').on('click', function(e) {
                e.preventDefault();
                var personId = $(this).data('id');
                
                $.ajax({
                    url: 'get_person_details.php',
                    method: 'GET',
                    data: { id: personId },
                    success: function(response) {
                        $('#modal-body-content').html(response);
                        $('#personDetailsModal').modal('show');
                    },
                    error: function() {
                        alert('An error occurred while fetching person details.');
                    }
                });
            });
        });
    </script>
</body>

</html>

<?php $conn->close(); ?>

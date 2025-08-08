<?php
include '../database/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Packages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Manage Packages</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Package ID</th>
                    <th>Package Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $package_query = "SELECT * FROM packages";
                $result = $conn->query($package_query);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['package_id'] . "</td>";
                    echo "<td>" . $row['package_name'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>";
                    echo "<form method='POST' style='display:inline-block;' action='edit_package.php'>";
                    echo "<input type='hidden' name='package_id' value='" . $row['package_id'] . "'>";
                    echo "<button type='submit' class='btn btn-primary'>Edit</button>";
                    echo "</form>";
                    echo "<form method='POST' style='display:inline-block;' action='delete_package.php'>";
                    echo "<input type='hidden' name='package_id' value='" . $row['package_id'] . "'>";
                    echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
include './config.php';
$query = "SELECT e.picPath as pic, e.employeeNumber as id, e.firstName AS employeeFName, e.lastName AS employeeLName, e.email AS employeeEmail, e.jobTitle AS employeeJobTitle, o.addressLine1 AS add1, o.addressLine2 AS add2, o.city AS city, o.state AS state, o.country AS country, r.firstName AS reportsFName, r.lastName AS reportsLName, r.jobTitle AS reportsJobTitle FROM employees e NATURAL JOIN offices o LEFT JOIN employees r ON (e.reportsTo=r.employeeNumber);";
$exec = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>task1</title>
    <link rel="stylesheet" href="./index.css">
    <style>
        button {
            padding: 0;
            border: none;
            background: none;
        }

        .btn {
            min-width: 100px;
            margin-bottom: 15px;

        }
    </style>

</head>

<body>
    <?php
    // For Alert Box
    $submit = "";
    if (!empty($_REQUEST['submit'])) {
        $submit = $_REQUEST['submit'];
    }
    if ($submit == "true") {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Employee added Successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    }
    if ($submit == "false") {
    ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Warning!</strong> Employee not added.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    }
    if ($submit == "delete") {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Employee deleted Successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    }
    if ($submit == "notdel") {
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Danger!</strong> Employee not deleted.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    }
    if ($submit == "update") {
    ?>
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Employee details updated.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    }
    // End Alert Box
    ?>
    <div class="container my-4">
        <h1 style=" margin: auto; width: fit-content; color: blue; ">Employee Details</h1>
        <a class="btn btn-primary" href="./add.php">Add New Employee</a>
        <table>
            <thead>
                <tr>
                    <td>Profile Picture</td>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Job Title</td>
                    <td>Emp Office Address</td>
                    <td>Reports To</td>
                    <td>Update</td>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($result = mysqli_fetch_assoc($exec)) {
                ?>
                    <tr>
                        <td>
                            <form action="./session.php" method="post" style="display:inline-block; width:min-content;">
                                <input style="display: none" type="text" name="editId" value="<?php echo $result['id'] ?>">
                                <input hidden type="text" name="picPath" value="<?php echo $result['pic']; ?>">
                                <input hidden type="text" name="name" value="<?php echo $result['employeeFName'] . ' ' . $result['employeeLName']; ?>">
                                <button name='editButton' type="submit"><img src="<?php echo ($result['pic'] == null) ? './user.png' : $result['pic'] ?>" alt="Profile Picture"></button>
                            </form>
                        </td>
                        <td>
                            <?php echo $result['employeeFName'] . ' ' . $result['employeeLName'] ?>
                        </td>
                        <td>
                            <?php echo $result['employeeEmail'] ?>
                        </td>
                        <td>
                            <?php echo $result['employeeJobTitle'] ?>
                        </td>
                        <td>
                            <?php
                            echo $result['add1'] . ' ' . $result['add2'] . '<br>' . $result['city'] . ', ' . $result['state'] . ', ' . $result['country'];
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $result['reportsFName'] . ' ' . $result['reportsLName'] . ',' . $result['reportsJobTitle'];
                            ?>
                        </td>
                        <td class="formbutton">
                            <form action="./session.php" method="post" style="display:inline-block; width:min-content;">
                                <input style="display: none" type="text" name="editId" value="<?php echo $result['id'] ?>">
                                <input hidden type="text" name="picPath" value="<?php echo $result['pic']; ?>">
                                <input hidden type="text" name="name" value="<?php echo $result['employeeFName'] . ' ' . $result['employeeLName']; ?>">
                                <button class="btn btn-warning" name='editButton' type="submit">Edit</button>
                            </form>
                            <form action="./session.php" method="post" style="display:inline-block; width:min-content;">
                                <input hidden type="text" name="deleteId" value="<?php echo $result['id'] ?>">
                                <input hidden type="text" name="picPath" value="<?php echo $result['pic']; ?>">
                                <button class="btn btn-danger" name='deleteButton' type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</body>

</html>
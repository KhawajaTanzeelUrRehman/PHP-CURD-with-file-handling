<?php
session_start();
include './config.php';
if (isset($_SESSION['accessedId'])) {
    $id = $_SESSION['accessedId'];
    $picPath = $_SESSION['picPath'];
    $name = $_SESSION['name'];
    $query = "SELECT * FROM employees WHERE employeeNumber=$id";
    $exec = mysqli_query($connection, $query);
    $result = mysqli_fetch_assoc($exec);
}
if (isset($_POST['update'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $extension = $_POST['extension'];
    $officeCode = $_POST['officeCode'];
    $email = $_POST['email'];
    $reportsTo = $_POST['reportsTo'];
    $jobTitle = $_POST['jobTitle'];
    $employeeNumber = $_POST['id1'];
    $picPath = $_POST['picPath'];


    if (!empty($_FILES["picture"]["name"])) {
        // Get file info
        $fileName = basename($_FILES["picture"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            $image = $_FILES['picture']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));

            $img_ex = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $new_img_name = uniqid();
            $new_img_name = $new_img_name . '.' . $img_ex_lc;

            $img_upload_path = './profilePictures/' . $new_img_name;
            move_uploaded_file($_FILES['picture']['tmp_name'], $img_upload_path);

            $queryUpdate = "UPDATE employees SET  firstName= '$fname', lastName='$lname', email= '$email', reportsTo= '$reportsTo', jobTitle= '$jobTitle', extension='$extension', officeCode='$officeCode', picPath = '$img_upload_path' WHERE employeeNumber=$employeeNumber";
            $execUpdate = mysqli_query($connection, $queryUpdate);
            unlink($picPath);
            session_unset();
            session_destroy();
            header("Location: ./index.php?submit=update");
        }
    } else {
        $queryUpdate = "UPDATE employees SET  firstName= '$fname', lastName='$lname', email= '$email', reportsTo= '$reportsTo', jobTitle= '$jobTitle', extension='$extension', officeCode='$officeCode' WHERE employeeNumber=$employeeNumber";
        $execUpdate = mysqli_query($connection, $queryUpdate);
        session_unset();
        session_destroy();
        header("Location: ./index.php?submit=update");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Update an Employee</title>
    <style>
        .img img {
            width: 150px;
            height: 100%;
            object-fit: fill;
            border: 2px solid black;
            box-shadow: 2px 3px 6x black;
            margin-bottom: 15px;
        }

        a {
            margin-bottom: 20px;
            float: right;
        }
    </style>
</head>

<body>
    <div class="container my-4">
        <h1 style=" margin:20px auto; width: fit-content; color: blue; "><?php echo $name ?>'s Updating dashboard</h1>
        <a href="./index.php" class="btn btn-primary">Home</a>
        <form id="myform2" method="post" action="update.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="fname" class="form-label fw-bold">First Name</label>
                <input type="text" name="fname" id="fname" required="required" class="form-control " aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php echo $result['firstName'] ?>">
            </div>

            <div class="mb-3">
                <label for="fname" class="form-label fw-bold">Last Name</label>
                <input type="text" name="lname" id="lname" required="required" class="form-control " aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php echo $result['lastName'] ?>">
            </div>

            <div class="mb-3">
                <label for="extension" class="form-label fw-bold">Extension</label>
                <input type="text" name="extension" id="extension" required="required" class="form-control " aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php echo $result['extension'] ?>">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <input type="email" name="email" id="email" required="required" class="form-control " aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php echo $result['email'] ?>">
            </div>

            <div class="mb-3">
                <label for="officeCode" class="form-label fw-bold">Office Code</label>
                <input type="number" name="officeCode" id="officeCode" min=1 max=7 required="required" class="form-control " aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php echo $result['officeCode'] ?>">
            </div>

            <div class="mb-3">
                <label for="reportsTo" class="form-label fw-bold">Reports To</label>
                <select name="reportsTo" id="reportsTo" required="required" class="form-select form-select-md" aria-label=".form-select-sm example">
                    <?php
                    $query1 = "SELECT firstName, lastName, employeeNumber from employees";
                    $exec1 = mysqli_query($connection, $query1);
                    while ($result1 = mysqli_fetch_assoc($exec1)) {
                    ?>
                        <option <?php if ($result['reportsTo'] == $result1['employeeNumber']) {
                                    echo 'selected';
                                } else {
                                } ?> value=<?php echo $result1['employeeNumber'] ?>><?php echo $result1['firstName'] . ' ' . $result1['lastName'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="jobTitle" class="form-label fw-bold">Job Title</label>
                <input type="text" name="jobTitle" id="jobTitle" required="required" class="form-control " aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php echo $result['jobTitle'] ?>">
            </div>



            <div class="mb-3">
                <label for="input-group-text" class="form-label fw-bold">Upload Profile Picture</label>
                <input onChange="updatePicture()" type="file" id="picture" name="picture" accept="image/*" class="form-control " aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
            </div>
            <div class="img" class="mb-3">
                <img id="profile" src="<?php echo ($picPath) ? $picPath : './user.png' ?>" alt="profile picture">
            </div>

            <input hidden type="text" name="picPath" value="<?php echo $picPath; ?>">
            <input hidden type="number" name="id1" id="id1" value="<?php echo $result['employeeNumber'] ?>">
            <button class="form-control btn btn-primary" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name='update' type="submit">Update</button>
        </form>
    </div>
    <script>
        var updatePicture = () => {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("picture").files[0]);

            oFReader.onload = function(oFREvent) {
                document.getElementById("profile").src = oFREvent.target.result;
            };
        }
    </script>
</body>

</html>
<?php
require_once 'config.php';
include 'session-checker.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnsave'])) {
    // Check existing equipment
    $sql = "SELECT * FROM tblequipments WHERE assetnumber = ? OR serialnumber = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        $param_assetnumber = $_POST['txtassetnumber'];
        $param_serialnumber = $_POST['txtserialnumber'];
        mysqli_stmt_bind_param($stmt, "ss", $param_assetnumber, $param_serialnumber);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 0) {
                $sql = "INSERT INTO tblequipments (assetnumber, serialnumber, equipmenttype, manufacturer, yearmodel, description, branch, department, status, createdby, datecreated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                if ($stmt = mysqli_prepare($link, $sql)) {
                    $assetnumber = $_POST['txtassetnumber'];
                    $serialnumber = $_POST['txtserialnumber'];
                    $equipmenttype = $_POST['txtequipmenttype'];
                    $manufacturer = $_POST['txtmanufacturer'];
                    $yearmodel = $_POST['txtyearmodel'];
                    $description = $_POST['txtdescription'];
                    $branch = $_POST['txtbranch'];
                    $department = $_POST['txtdepartment'];
                    $status = "WORKING";
                    $createdby = $_SESSION['username'];
                    $datecreated = date("d/m/Y");

                    mysqli_stmt_bind_param($stmt, "sssssssssss", $assetnumber, $serialnumber, $equipmenttype, $manufacturer, $yearmodel, $description, $branch, $department, $status, $createdby, $datecreated);
                    if (mysqli_stmt_execute($stmt)) {
                        $msg = "Equipment added successfully";
                        header("Location: equipment-management.php?updatemsg=" . urlencode($msg));
                        exit();
                    } else {
                        $msg = "Error adding equipment";
                    }
                }
            } else {
                $msg = "Asset number or Serial number already exists";
            }
        }
    } else {
        $msg = "Error on Create equipment statement: " . mysqli_connect_error();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/modern-normalize.css">
    <link rel="stylesheet" href="css/add-equipment.css">
    <title>Add Equipment - AU TECHNICAL SUPPORT MANAGEMENT SYSTEM</title>
</head>
<body>
    <div class="wrapper">
        <header>
            <h1>AU TSMS</h1>
            <div class="session section">
                <?php
                if ($_SESSION['username']) {
                    echo $_SESSION['username'] . " | ";
                    echo $_SESSION['usertype'];
                } else {
                    header("location: login.php");
                }
                ?>
            </div>
        </header>
        <div class="main-content">
            <div class="page-title">
                <h1>Add Equipment</h1><br>
                <p style="text-align: center;">Fill in the details to add a new equipment</p>
            </div>
            <div id="php_error" class="error">
                <?php
                if (!empty($msg)) {
                    echo "<div class='msg' style='color: red;'>$msg</div>";
                }
                ?>
            </div>
            <div class="form section">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <input type="text" name="txtassetnumber" placeholder="Asset Number" required><br>
                    <input type="text" name="txtserialnumber" placeholder="Serial Number" required><br>
                    <select name="txtequipmenttype" required>
                        <option value="">--Select Equipment Type--</option>
                        <option value="Monitor">Monitor</option>
                        <option value="CPU">CPU</option>
                        <option value="Keyboard">Keyboard</option>
                        <option value="Mouse">Mouse</option>
                        <option value="AVR">AVR</option>
                        <option value="MAC">MAC</option>
                        <option value="Printer">Printer</option>
                        <option value="Projector">Projector</option>
                    </select><br>
                    <input type="text" name="txtmanufacturer" placeholder="Manufacturer" required><br>
                    <input type="number" name="txtyearmodel" placeholder="Year Model" min="1900" max="2025" step="1" required pattern="\d{4}" title="Please enter a valid 4-digit year"><br>
                    <textarea name="txtdescription" placeholder="Description" required></textarea><br>
                    <select name="txtbranch" required>
                        <option value="">--Select Branch--</option>
                        <option value="Branch1">Branch1</option>
                        <option value="Branch2">Branch2</option>
                        <!-- Add all branches of AU -->
                    </select><br>
                    <select name="txtdepartment" required>
                        <option value="">--Select Department--</option>
                        <option value="Department1">Department1</option>
                        <option value="Department2">Department2</option>
                        <!-- Add all colleges and offices of AU -->
                    </select><br>
                    <button name="btnsave" type="submit">Save</button>
                    <a href="equipment-management.php">Cancel</a>
                </form>
            </div>
        </div>
        <footer>
            <p>&copy; <span id="year"></span> AU Technical Support Management System. All Rights Reserved.</p>
        </footer>
    </div>
    <script>
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>
</body>
</html>
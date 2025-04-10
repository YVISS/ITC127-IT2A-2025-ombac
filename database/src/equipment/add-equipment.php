<?php

require_once '../core/config.php';
include '../core/session-checker.php';

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
    <link rel="stylesheet" href="../../css/general/modern-normalize.css">
    <link rel="stylesheet" href="../../css/general/session.css">
    <link rel="stylesheet" href="../../css/general/wrapper.css">
    <link rel="stylesheet" href="../../css/equipment/update-equipment.css">
    <title>Equipment Management Page - AU TECHNICAL SUPPORT MANAGEMENT SYSTEM</title>
</head>

<body>
    <div class="wrapper">
        <div class="wrapper-container">
            <header class="wrapper_header">
                <div class="page-title">
                    <img src="../../src/images/au_logo.png" alt="Arellano University Logo">

                    <h1>AU Technical Support Management System</h1>
                </div>
            </header>
            <div class="main-content">
                <div class="card">
                    <div class="page-title">
                        <h1>Add Equipment</h1>
                        <p style="text-align: center;">Fill in the details to add a new equipment</p>
                    </div>
                    <div id="php_error" class="error">
                        <?php
                        if (!empty($msg)) {
                            echo "<div class='msg' style='color: red;'>$msg</div>";
                        }
                        ?>
                    </div>
                    <div class="form">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                            <div class="form__aseetnumber">
                                <h2>Asset Number</h2>
                                <input type="text" name="txtassetnumber" placeholder="Asset Number" required>
                            </div>

                            <div class="form__serialnumber">
                                <h2>Serial Number</h2>
                                <input type="text" name="txtserialnumber" placeholder="Serial Number" required>
                            </div>

                            <div class="form__type">
                                <h2>Equipment Type</h2>
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
                                </select>
                            </div>

                            <div class="form__manufacturer">
                                <h2>Manufacturer</h2>
                                <input type="text" name="txtmanufacturer" placeholder="Manufacturer" required>
                            </div>

                            <div class="form__year">
                                <h2>Year Model</h2>
                                <input type="number" name="txtyearmodel" placeholder="Year Model" min="1900" max="2025" step="1" required pattern="\d{4}" title="Please enter a valid 4-digit year">
                            </div>

                            <div class="form__description">
                                <h2>Description</h2>
                                <textarea name="txtdescription" placeholder="Description" required></textarea>
                            </div>

                            <div class="form__branch">
                                <h2>Branch</h2>
                                <select name="txtbranch" required>
                                    <option value="">--Select Branch--</option>
                                    <option value="Branch1">Branch1</option>
                                    <option value="Branch2">Branch2</option>
                                    <!-- Add all branches of AU -->
                                </select>
                            </div>

                            <div class="form__department">
                                <h2>Department</h2>
                                <select name="txtdepartment" required>
                                    <option value="">--Select Department--</option>
                                    <option value="Department1">Department1</option>
                                    <option value="Department2">Department2</option>
                                    <!-- Add all colleges and offices of AU -->
                                </select>
                            </div>
                            <div class="form__btns">
                                <button name="btnsave" type="submit">Save</button>
                                <a href="equipment-management.php">Cancel</a>
                            </div>
                    </div>


                    </form>
                </div>
            </div>
        </div>

        <footer>
            <p>&copy; Copyright <span id="year"> </span> AU Technical Support Management System. All Rights Reserved.
            </p>
        </footer>
    </div>

    </div>
</body>
<script>
    document.getElementById("year").textContent = new Date().getFullYear();

    function togglePassword() {
        let passwordInput = document.getElementById("password");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            let eye = document.getElementById('togglePassIcon').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EEEEE"><path d="m644-428-58-58q9-47-27-88t-93-32l-58-58q17-8 34.5-12t37.5-4q75 0 127.5 52.5T660-500q0 20-4 37.5T644-428Zm128 126-58-56q38-29 67.5-63.5T832-500q-50-101-143.5-160.5T480-720q-29 0-57 4t-55 12l-62-62q41-17 84-25.5t90-8.5q151 0 269 83.5T920-500q-23 59-60.5 109.5T772-302Zm20 246L624-222q-35 11-70.5 16.5T480-200q-151 0-269-83.5T40-500q21-53 53-98.5t73-81.5L56-792l56-56 736 736-56 56ZM222-624q-29 26-53 57t-41 67q50 101 143.5 160.5T480-280q20 0 39-2.5t39-5.5l-36-38q-11 3-21 4.5t-21 1.5q-75 0-127.5-52.5T300-500q0-11 1.5-21t4.5-21l-84-82Zm319 93Zm-151 75Z"/></svg>';
        } else {
            passwordInput.type = "password";
            let eye = document.getElementById('togglePassIcon').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EEEEE"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>';
        }
    }
</script>

</html>
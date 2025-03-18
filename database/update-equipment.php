<?php
require_once "config.php";
include "session-checker.php";
include "errors.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$updatemsg = '';
$errormsg = '';
if (isset($_POST['btnsave'])) {
    $sql = "UPDATE tblequipments SET serialnumber =?, equipmenttype =?, manufacturer =?, yearmodel =?, description =?, branch =?, department =?, status =? WHERE assetnumber=?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssssss", $_POST['txtserialnumber'], $_POST['txtequipmenttype'], $_POST['txtmanufacturer'], $_POST['txtyearmodel'], $_POST['txtdescription'], $_POST['txtbranch'], $_POST['txtdepartment'], $_POST['rbstatus'], $_GET['assetnumber']);
        if (mysqli_stmt_execute($stmt)) {
            $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, performedby, performedto) VALUES (?,?,?,?,?,?)";
            if ($stmt = mysqli_prepare($link, $sql)) {
                $date = date('d/m/Y');
                $time = date("h:i:sa");
                $action = "Update";
                $module = "Equipment Management";
                mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $_SESSION['username'], $_GET['assetnumber']);
                if (mysqli_stmt_execute($stmt)) {
                    $updatemsg = "Equipment Updated";
                    header("location: equipment-management.php?updatemsg=" . urlencode($updatemsg));
                    exit();
                }
            } else {
                $errormsg = "ERROR: Inserting logs";
                header("location: equipment-management.php?errormsg=" . urlencode($errormsg));
                exit();
            }
        }
    } else {
        $errormsg = "<font color = 'red'>ERROR: Updating Equipment</font>";
        header("location: equipment-management.php?errormsg=" . urlencode($errormsg));
        exit();
    }
} else { //load current data
    if (isset($_GET['assetnumber']) && !empty(trim($_GET['assetnumber']))) {
        $sql = "SELECT * FROM tblequipments WHERE assetnumber = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $_GET['assetnumber']);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                $equipment = mysqli_fetch_array($result, MYSQLI_ASSOC);
            }
        } else {
            echo "<font color = 'red'>ERROR: Loading Equipment</font>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/modern-normalize.css">
    <link rel="stylesheet" href="css/update-equipment.css">
    <title>Update Equipment - AU TECHNICAL SUPPORT MANAGEMENT SYSTEM</title>
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
                <h1>Update Equipment</h1><br>
                <p style="text-align: center;">Change the value on this form and submit to update the equipment</p>
            </div>
            <div class="form section">
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST">
                    <div class="formUserInfo">
                        <h2>Equipment Information</h2>
                        <div class="assetnumberInfo">
                            <span class="assetnumber">Asset Number:</span> <?php echo $equipment['assetnumber']; ?>
                        </div>
                        <div class="password-container">
                            <span class="serialnumber">Serial Number:</span>
                            <input id="serialnumber" type="text" name="txtserialnumber" value="<?php echo $equipment['serialnumber']; ?>" required>
                        </div>
                    </div>
                    <div class="formUserType">
                        <h2>Equipment Details</h2>
                        <div class="changeType">
                            <span class="changeUserType">Change Equipment Type To:</span> 
                            <select name="txtequipmenttype" id="txtequipmenttype" required>
                                <option value="">Current: <?php echo $equipment['equipmenttype']; ?></option>
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
                        <div class="manufacturer">
                            <span class="manufacturer">Manufacturer:</span>
                            <input id="manufacturer" type="text" name="txtmanufacturer" value="<?php echo $equipment['manufacturer']; ?>" required>
                        </div>
                        <div class="yearmodel">
                            <span class="yearmodel">Year Model:</span>
                            <input id="yearmodel" type="text" name="txtyearmodel" value="<?php echo $equipment['yearmodel']; ?>" required>
                        </div>
                        <div class="description">
                            <span class="description">Description:</span>
                            <textarea name="txtdescription" required><?php echo $equipment['description']; ?></textarea>
                        </div>
                        <div class="branch">
                            <span class="branch">Branch:</span>
                            <select name="txtbranch" required>
                                <option value="">Current: <?php echo $equipment['branch']; ?></option>
                                <option value="Branch1">Branch1</option>
                                <option value="Branch2">Branch2</option>
                                <!-- Add all branches of AU -->
                            </select>
                        </div>
                        <div class="department">
                            <span class="department">Department:</span>
                            <select name="txtdepartment" required>
                                <option value="">Current: <?php echo $equipment['department']; ?></option>
                                <option value="Department1">Department1</option>
                                <option value="Department2">Department2</option>
                                <!-- Add all colleges and offices of AU -->
                            </select>
                        </div>
                        <div class="status">
                            Status: <br>
                            <?php
                            $status = $equipment['status'];
                            if ($status == 'WORKING') {
                            ?><input type="radio" name="rbstatus" value="WORKING" checked>Working<br>
                                <input type="radio" name="rbstatus" value="ON-REPAIR">On-repair<br>
                                <input type="radio" name="rbstatus" value="RETIRED">Retired<br> <?php
                            } else if ($status == 'ON-REPAIR') {
                                ?><input type="radio" name="rbstatus" value="WORKING">Working<br>
                                <input type="radio" name="rbstatus" value="ON-REPAIR" checked>On-repair<br>
                                <input type="radio" name="rbstatus" value="RETIRED">Retired<br> <?php
                            } else {
                                ?><input type="radio" name="rbstatus" value="WORKING">Working<br>
                                <input type="radio" name="rbstatus" value="ON-REPAIR">On-repair<br>
                                <input type="radio" name="rbstatus" value="RETIRED" checked>Retired<br> <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="submissions">
                        <input type="submit" name="btnsave" value="Save">
                        <a href="equipment-management.php">Cancel</a>
                    </div>
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
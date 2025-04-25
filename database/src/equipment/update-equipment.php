<?php

require_once '../core/config.php';
include '../core/session-checker.php';
include "../core/errors.php";
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
                        <h1>Update Equipment</h1><br>
                        <p style="text-align: center;">Change the value on this form and submit to update the equipment</p>
                    </div>
                    <div class="form section">
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST">
                            <div class="form__assetnumber">
                                
                            <h2>Asset Number</h2>
                                <input type="text" name="txtassetnumber" value="<?php echo $equipment['assetnumber']; ?>" readonly>
                            </div>

                            <div class="form__serialnumber">
                                <h2>Serial Number</h2>
                                <input type="text" name="txtserialnumber" value="<?php echo $equipment['serialnumber']; ?>" required>
                            </div>

                            <div class="form__type">
                                <h2>Equipment Type</h2>
                                <select name="txtequipmenttype" required>
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

                            <div class="form__manufacturer">
                                <h2>Manufacturer</h2>
                                <input type="text" name="txtmanufacturer" value="<?php echo $equipment['manufacturer']; ?>" required>
                            </div>

                            <div class="form__year">
                                <h2>Year Model</h2>
                                <input type="number" name="txtyearmodel" value="<?php echo $equipment['yearmodel']; ?>" min="1900" max="2025" step="1" required pattern="\d{4}" title="Please enter a valid 4-digit year">
                            </div>

                            <div class="form__description">
                                <h2>Description</h2>
                                <textarea name="txtdescription" required><?php echo $equipment['description']; ?></textarea>
                            </div>

                            <div class="form__branch">
                                <h2>Branch</h2>
                                <select name="txtbranch" required>
                                <option value="">Current: <?php echo $equipment['branch'];?></option>
                                    <option value="Juan Sumulong Campus">Juan Sumulong Campus (Legarda, Manila)</option>
                                    <option value="Jose Abad Santos Campus">Jose Abad Santos Campus (Pasay)</option>
                                    <option value="Apolinario Mabini Campus">Apolinario Mabini Campus (Pasay - School of Law)</option>
                                    <option value="Andres Bonifacio Campus">Andres Bonifacio Campus (Pasig)</option>
                                    <option value="Plaridel Campus">Plaridel Campus (Mandaluyong)</option>
                                    <option value="Jose Rizal Campus">Jose Rizal Campus (Malabon)</option>
                                    <option value="Elisa Esguerra Campus">Elisa Esguerra Campus (Malabon)</option>
                                    <!-- Add all branches of AU -->
                                </select>
                            </div>

                            <div class="form__department">
                                <h2>Department</h2>
                                <select name="txtdepartment" required>
                                    <option value="">Current: <?php echo $equipment['department']; ?></option>
                                    
  <optgroup label="Juan Sumulong Campus">
    <option value="School of Law">School of Law</option>
    <option value="School of Education">School of Education</option>
    <option value="School of Business">School of Business</option>
    <option value="Senior High School">Senior High School</option>
    <option value="Registrar">Registrar</option>
    <option value="Library">Library</option>
    <option value="IT Office">IT Office</option>
  </optgroup>

  <optgroup label="Jose Abad Santos Campus">
    <option value="College of Nursing">College of Nursing</option>
    <option value="Senior High School">Senior High School</option>
    <option value="Registrar">Registrar</option>
    <option value="Library">Library</option>
    <option value="Guidance Office">Guidance Office</option>
  </optgroup>

  <optgroup label="Apolinario Mabini Campus">
    <option value="School of Law">School of Law</option>
    <option value="Registrar">Registrar</option>
    <option value="Library">Library</option>
  </optgroup>

  <optgroup label="Andres Bonifacio Campus">
    <option value="School of Education">School of Education</option>
    <option value="College of Information Tech">College of Information Tech</option>
    <option value="Registrar">Registrar</option>
    <option value="Library">Library</option>
    <option value="Clinic">Clinic</option>
  </optgroup>

  <optgroup label="Plaridel Campus">
    <option value="College of Hospitality">College of Hospitality</option>
    <option value="Registrar">Registrar</option>
    <option value="Library">Library</option>
    <option value="Finance Office">Finance Office</option>
  </optgroup>

  <optgroup label="Jose Rizal Campus">
    <option value="Basic Education">Basic Education</option>
    <option value="Senior High School">Senior High School</option>
    <option value="Registrar">Registrar</option>
    <option value="Library">Library</option>
  </optgroup>

  <optgroup label="Elisa Esguerra Campus">
    <option value="Senior High School">Senior High School</option>
    <option value="Registrar">Registrar</option>
    <option value="Library">Library</option>
  </optgroup>
                                </select>
                            </div>

                            <div class="form__status">
                                <h2>Status</h2>
                                <?php
                                $status = $equipment['status'];
                                if ($status == 'WORKING') {
                                ?>
                                    <input type="radio" name="rbstatus" value="WORKING" checked>Working<br>
                                    <input type="radio" name="rbstatus" value="ON-REPAIR">On-repair<br>
                                    <input type="radio" name="rbstatus" value="RETIRED">Retired<br>
                                <?php
                                } else if ($status == 'ON-REPAIR') {
                                ?>
                                    <input type="radio" name="rbstatus" value="WORKING">Working<br>
                                    <input type="radio" name="rbstatus" value="ON-REPAIR" checked>On-repair<br>
                                    <input type="radio" name="rbstatus" value="RETIRED">Retired<br>
                                <?php
                                } else {
                                ?>
                                    <input type="radio" name="rbstatus" value="WORKING">Working<br>
                                    <input type="radio" name="rbstatus" value="ON-REPAIR">On-repair<br>
                                    <input type="radio" name="rbstatus" value="RETIRED" checked>Retired<br>
                                <?php
                                }
                                ?>
                            </div>

                            <div class="form__btns">
                                <button name="btnsave" type="submit">Save</button>
                                <a href="equipment-management.php">Cancel</a>
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
<?php
require_once 'config.php';
include 'session-checker.php';

$updatemsg = '';
$errormsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btncreate'])) {
    //check existing equipment
    $sql = "SELECT * FROM tblequipments WHERE assetnumber = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        $param_assetnumber = $_POST['txtassetnumber'];
        mysqli_stmt_bind_param($stmt, "s", $param_assetnumber);
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

                        $updatemsg = urlencode("Equipment added successfully");
                        header("Location: equipment-management.php?updatemsg=$updatemsg");
                        exit();
                    } else {

                        $errormsg .=  "Error adding equipment";
                        header("Location: equipment-management.php?errormsg=$errormsg");
                        exit();
                    }
                }
            } else {
                $errormsg .=  "Asset number already exists";
                header("Location: equipment-management.php?errormsg=$errormsg");
                exit();
            }
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
    <link rel="stylesheet" href="css/equipment-management.css">
    <title>Equipment Management - AU TECHNICAL SUPPORT MANAGEMENT SYSTEM</title>
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
                <h1>Equipment Management</h1><br>
                <p style="text-align: center;">Manage your equipment here</p>
            </div>
            <div id="php_error" class="error">
            <?php
                if (isset($_GET['updatemsg'])) {
                    // Display the update status message
                    echo "<div class='msg' style=' color: green'> <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-circle-check-filled' width='24' height='24' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M17 3.34a10 10 0 1 1 -14.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 14.995 -8.336zm-1.293 5.953a1 1 0 0 0 -1.32 -.083l-.094 .083l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.403 1.403l.083 .094l2 2l.094 .083a1 1 0 0 0 1.226 0l.094 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z' stroke-width='0' fill='currentColor' /></svg>" . htmlspecialchars($_GET['updatemsg']) . "</div>";
                }if(isset($_GET['errormsg'])){
                    echo '<div class="msg" style=" color: red"> <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-xbox-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10 -10 10s-10 -4.477 -10 -10s4.477 -10 10 -10m3.6 5.2a1 1 0 0 0 -1.4 .2l-2.2 2.933l-2.2 -2.933a1 1 0 1 0 -1.6 1.2l2.55 3.4l-2.55 3.4a1 1 0 1 0 1.6 1.2l2.2 -2.933l2.2 2.933a1 1 0 0 0 1.6 -1.2l-2.55 -3.4l2.55 -3.4a1 1 0 0 0 -.2 -1.4" /></svg>' . htmlspecialchars($_GET['errormsg']) . "</div>";
                }
                ?>
            </div>
            <div class="form section">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="form__btns">
                        <button type="button" onclick="window.location.href='add-equipment.php'">Add Equipment</button>
                        <button><a href="logout.php">Logout</a></button><br>
                    </div>
                    <div class="search">
                        <input type="text" name="txtsearch" placeholder="Search...">
                        <input type="submit" value="Search" name="btnsearch">
                    </div>
                </form>
            </div>
            <div class="table_component" role="region" tabindex="0">
                <?php
                    
                function buildTable($result)
                {
                    if (mysqli_num_rows($result) > 0) {
                        echo "<table>";
                        echo "<tr class='headers'>";
                        echo "<th>Asset Number</th><th>Serial Number</th><th>Equipment Type</th><th>Branch</th><th>Status</th><th>Created By</th><th>Action</th>";
                        echo "</tr>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr class='row'>";
                            echo "<td>" . $row['assetnumber'] . "</td>";
                            echo "<td>" . $row['serialnumber'] . "</td>";
                            echo "<td>" . $row['equipmenttype'] . "</td>";
                            echo "<td>" . $row['branch'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>" . $row['createdby'] . "</td>";
                            echo "<td><a href='update-equipment.php?assetnumber=" . $row['assetnumber'] . "'>Update</a> | <a href='#' onclick='confirmDelete(\"" . $row['assetnumber'] . "\")'>Delete</a></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "No record/s found";
                    }
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnsearch'])) {
                    $sql = "SELECT * FROM tblequipments WHERE assetnumber LIKE ? OR serialnumber LIKE ? OR equipmenttype LIKE ? OR department LIKE ? ORDER BY assetnumber ASC";
                    if ($stmt = mysqli_prepare($link, $sql)) {
                        $searchvalue  = "%" . $_POST['txtsearch'] . "%";
                        mysqli_stmt_bind_param($stmt, "ssss", $searchvalue, $searchvalue, $searchvalue, $searchvalue);
                        if (mysqli_stmt_execute($stmt)) {
                            $result = mysqli_stmt_get_result($stmt);
                            buildTable($result);
                        }
                    } else {
                        echo $errormsg .= "Error: " . mysqli_error($link);
                    }
                } else {
                    $sql = "SELECT * FROM tblequipments ORDER BY assetnumber ASC";
                    if ($stmt = mysqli_prepare($link, $sql)) {
                        if (mysqli_stmt_execute($stmt)) {
                            $result = mysqli_stmt_get_result($stmt);
                            buildTable($result);
                        }
                    } else {
                        echo $errormsg .= "Error: " . mysqli_error($link);
                    }
                }
                ?>
            </div>
        </div>
        <footer>
            <p>&copy; <span id="year"></span> AU Technical Support Management System. All Rights Reserved.</p>
        </footer>
    </div>

    <!-- Delete Equipment Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Delete Equipment</h2>
            <p>Are you sure you want to delete this equipment?</p>
            <form id="deleteForm" action="delete-equipment.php" method="POST">
                <input type="hidden" name="txtassetnumber" id="deleteAssetNumber">
                <div class="form__btns">
                    <input type="submit" value="Yes" name="btnsubmit">
                    <button type="button" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        
    let errormsg = document.getElementById("php_error");
        document.getElementById("year").textContent = new Date().getFullYear();

        function confirmDelete(assetnumber) {
            document.getElementById('deleteAssetNumber').value = assetnumber;
            document.getElementById('deleteModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('deleteModal')) {
                closeModal();
            }
        }

        setTimeout(() => {
        if (errormsg) {
            errormsg.style.transition = "opacity 1s";
            errormsg.style.opacity = "0";
            setTimeout(() => errormsg.style.display = none, 1000);
        }
    }, 3000);
    </script>
</body>

</html>
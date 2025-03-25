<?php

require_once '../core/config.php';
include '../core/session-checker.php';

$updatemsg = '';
$errormsg = '';

// Check if the search button is clicked
if (isset($_POST['btnsearch'])) {
    $sql = "SELECT * FROM tbltickets WHERE (ticketnumber LIKE ? OR problem LIKE ? OR status LIKE ?) AND createdby = ? ORDER BY datecreated DESC";
    if ($stmt = mysqli_prepare($link, $sql)) {
        $searchvalue = "%" . $_POST['txtsearch'] . "%";
        mysqli_stmt_bind_param($stmt, "ssss", $searchvalue, $searchvalue, $searchvalue, $_SESSION['username']);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
        }
    }
} else {
    $sql = "SELECT * FROM tbltickets WHERE createdby = ? ORDER BY datecreated DESC";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/general/modern-normalize.css ">
    <link rel="stylesheet" href="../../css/tickets/ticket-management.css">
    <title>Ticket Management - AU TECHNICAL SUPPORT MANAGEMENT SYSTEM</title>
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
                    header("location: ../../core/login.php");
                }
                ?>
            </div>
        </header>
        <div class="main-content">
            <div class="page-title">
                <h1>Ticket Management</h1><br>
                <p style="text-align: center;">Manage your tickets here</p>
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
                        <button type="button" onclick="window.location.href='create-ticket.php'">Create Ticket</button>
                        <button><a href="../core/logout.php">Logout</a></button>
                        <input type="text" name="txtsearch" placeholder="Search...">
                        <input type="submit" value="Search" name="btnsearch">
                    </div>
                </form>
            </div>
            <div class="table_component" role="region" tabindex="0">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>";
                    echo "<tr class='headers'>";
                    echo "<th>Ticket Number</th><th>Problem</th><th>Date Created</th><th>Status</th><th>Action</th>";
                    echo "</tr>";
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr class='row'>";
                        echo "<td>" . $row['ticketnumber'] . "</td>";
                        echo "<td>" . $row['problem'] . "</td>";
                        echo "<td>" . $row['datecreated'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>
                            <a href='update-ticket.php?ticketnumber=" . $row['ticketnumber'] . "'>Update</a> |
                            <a href='#' onclick='confirmDelete(\"" . $row['ticketnumber'] . "\")'>Delete</a> |
                            <a href='#' onclick='viewDetails(" . json_encode($row) . ")'>Details</a>
                        </td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No record/s found";
                }
                ?>
            </div>
        </div>
        <footer>
            <p>&copy; <span id="year"></span> AU Technical Support Management System. All Rights Reserved.</p>
        </footer>
    </div>

    <!-- Delete Ticket Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('deleteModal')">&times;</span>
            <h2>Delete Ticket</h2>
            <p>Are you sure you want to delete this ticket?</p>
            <form id="deleteForm" action="delete-ticket.php" method="POST">
                <input type="hidden" name="txtticketnumber" id="deleteTicketNumber">
                <div class="form__btns">
                    <input type="submit" value="Yes" name="btnsubmit">
                    <button type="button" onclick="closeModal('deleteModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Details Modal -->
    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('detailsModal')">&times;</span>
            <h2>Ticket Details</h2>
            <p><strong>Ticket Number:</strong> <span id="detailsTicketNumber"></span></p>
            <p><strong>Problem:</strong> <span id="detailsProblem"></span></p>
            <p><strong>Details:</strong> <span id="detailsDetails"></span></p>
            <p><strong>Status:</strong> <span id="detailsStatus"></span></p>
            <p><strong>Created By:</strong> <span id="detailsCreatedBy"></span></p>
            <p><strong>Date Created:</strong> <span id="detailsDateCreated"></span></p>
            <p><strong>Assigned To:</strong> <span id="detailsAssignedTo"></span></p>
            <p><strong>Date Assigned:</strong> <span id="detailsDateAssigned"></span></p>
            <p><strong>Date Completed:</strong> <span id="detailsDateCompleted"></span></p>
            <p><strong>Approved By:</strong> <span id="detailsApprovedBy"></span></p>
            <p><strong>Date Approved:</strong> <span id="detailsDateApproved"></span></p>
        </div>
    </div>

    <script>
        document.getElementById("year").textContent = new Date().getFullYear();

        function confirmDelete(ticketnumber) {
            document.getElementById('deleteTicketNumber').value = ticketnumber;
            document.getElementById('deleteModal').style.display = 'block';
        }

        function viewDetails(ticket) {
            document.getElementById('detailsTicketNumber').textContent = ticket.ticketnumber;
            document.getElementById('detailsProblem').textContent = ticket.problem;
            document.getElementById('detailsDetails').textContent = ticket.details;
            document.getElementById('detailsStatus').textContent = ticket.status;
            document.getElementById('detailsCreatedBy').textContent = ticket.createdby;
            document.getElementById('detailsDateCreated').textContent = ticket.datecreated;
            document.getElementById('detailsAssignedTo').textContent = ticket.assignedto || 'N/A';
            document.getElementById('detailsDateAssigned').textContent = ticket.dateassigned || 'N/A';
            document.getElementById('detailsDateCompleted').textContent = ticket.datecompleted || 'N/A';
            document.getElementById('detailsApprovedBy').textContent = ticket.approvedby || 'N/A';
            document.getElementById('detailsDateApproved').textContent = ticket.dateapproved || 'N/A';
            document.getElementById('detailsModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('deleteModal')) {
                closeModal('deleteModal');
            }
            if (event.target == document.getElementById('detailsModal')) {
                closeModal('detailsModal');
            }
        }
    </script>
</body>
</html>
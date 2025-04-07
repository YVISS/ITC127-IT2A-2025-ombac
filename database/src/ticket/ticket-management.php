<?php

require_once '../core/config.php';
include '../core/session-checker.php';
include '../core/errors.php';

$updatemsg = '';
$errormsg = '';
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
            <a href="../core/index.php" class="home-link"><svg class='home' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-home">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12.707 2.293l9 9c.63 .63 .184 1.707 -.707 1.707h-1v6a3 3 0 0 1 -3 3h-1v-7a3 3 0 0 0 -2.824 -2.995l-.176 -.005h-2a3 3 0 0 0 -3 3v7h-1a3 3 0 0 1 -3 -3v-6h-1c-.89 0 -1.337 -1.077 -.707 -1.707l9 -9a1 1 0 0 1 1.414 0m.293 11.707a1 1 0 0 1 1 1v7h-4v-7a1 1 0 0 1 .883 -.993l.117 -.007z" />
                </svg></a>
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
                }
                if (isset($_GET['errormsg'])) {
                    echo '<div class="msg" style=" color: red"> <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-xbox-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10 -10 10s-10 -4.477 -10 -10s4.477 -10 10 -10m3.6 5.2a1 1 0 0 0 -1.4 .2l-2.2 2.933l-2.2 -2.933a1 1 0 1 0 -1.6 1.2l2.55 3.4l-2.55 3.4a1 1 0 1 0 1.6 1.2l2.2 -2.933l2.2 2.933a1 1 0 0 0 1.6 -1.2l-2.55 -3.4l2.55 -3.4a1 1 0 0 0 -.2 -1.4" /></svg>' . htmlspecialchars($_GET['errormsg']) . "</div>";
                }
                ?>
            </div>
            <div class="form section">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="form__btns">
                        <?php
                        if ($_SESSION['usertype'] == 'USER') {
                            echo "<button type='button' onclick=\"window.location.href='create-ticket.php'\">Create Ticket</button>";
                        }
                        ?>
                        <button><a href="../core/logout.php">Logout</a></button>
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
                        echo "<th>Ticket Number</th><th>Problem</th><th>Date Created</th><th>Status</th><th>Action</th>";
                        echo "</tr>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['ticketnumber'] . "</td>";
                            echo "<td>" . $row['problem'] . "</td>";
                            echo "<td>" . $row['datecreated'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td class='actions'>";

                            if ($_SESSION['usertype'] == 'ADMINISTRATOR') {
                                //default hrefs for usertypes
                                echo "<a href='#' onclick='confirmDelete(\"" . $row['ticketnumber'] . "\")'><svg class='delete' xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"icon icon-tabler icons-tabler-outline icon-tabler-circle-minus\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0\" /><path d=\"M9 12l6 0\" /></svg></a>";
                                echo "<a href='#' onclick='viewDetails(" . json_encode($row) . ")'><svg class='details' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-clipboard-text'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2' /><path d='M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z' /><path d='M9 12h6' /><path d='M9 16h6' /></svg></a>";
                                if ($row['status'] == 'PENDING' || $row['status'] == 'ONGOING') {
                                    echo "<a  href='assign-ticket.php?ticketnumber=" . $row['ticketnumber'] . "'><svg class='assign' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-users-plus'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M5 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0' /><path d='M3 21v-2a4 4 0 0 1 4 -4h4c.96 0 1.84 .338 2.53 .901' /><path d='M16 3.13a4 4 0 0 1 0 7.75' /><path d='M16 19h6' /><path d='M19 16v6' /></svg></a>";
                                }
                                if ($row['status'] == 'FOR APPROVAL') {
                                    echo "<a href='#' onclick='approveTicket(" . $row['ticketnumber'] . ")'><svg class='approve' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-circle-check'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0' /><path d='M9 12l2 2l4 -4' /></svg></a>";
                                }
                            } elseif ($_SESSION['usertype'] == 'TECHNICAL') {

                                echo "<a href='#' onclick='viewDetails(" . json_encode($row) . ")'><svg class='details' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-clipboard-text'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2' /><path d='M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z' /><path d='M9 12h6' /><path d='M9 16h6' /></svg></a>";
                                if ($row['status'] == 'ONGOING') {
                                    echo "<a href='#' onclick='completeTicket(\"" . $row['ticketnumber'] . "\")'><svg class='complete' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='currentColor' class='icon icon-tabler icons-tabler-filled icon-tabler-star'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z' /></svg></a>";
                                }
                            } else if ($_SESSION['usertype'] == 'USER') {
                                echo "<a href='update-ticket.php?ticketnumber=" . $row['ticketnumber'] . "'> <svg class='update' xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"icon icon-tabler icons-tabler-outline icon-tabler-pencil-check\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4\" /><path d=\"M13.5 6.5l4 4\" /><path d=\"M15 19l2 2l4 -4\" /></svg></a>";
                                echo "<a  href='#' onclick='viewDetails(" . json_encode($row) . ")'> <svg class='details' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-clipboard-text'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2' /><path d='M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z' /><path d='M9 12h6' /><path d='M9 16h6' /></svg></a>";
                                if ($row['status'] == 'CLOSED') {
                                    echo "<a href='#' onclick='confirmDelete(\"" . $row['ticketnumber'] . "\")'><svg class='delete' xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"icon icon-tabler icons-tabler-outline icon-tabler-circle-minus\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0\" /><path d=\"M9 12l6 0\" /></svg></a>";
                                }
                            }

                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "No record/s found";
                    }
                }
                // Check if the search button is clicked
                if (isset($_POST['btnsearch'])) {
                    $sql = "SELECT * FROM tbltickets WHERE ticketnumber LIKE ? OR problem LIKE ? OR status LIKE ? ORDER BY datecreated DESC";

                    // If the user is a technical user, restrict the query to tickets assigned to them
                    if ($_SESSION['usertype'] == 'TECHNICAL') {
                        $sql = "SELECT * FROM tbltickets WHERE (ticketnumber LIKE ? OR problem LIKE ? OR status LIKE ?) AND assignedto = ? ORDER BY datecreated DESC";
                    }

                    if ($stmt = mysqli_prepare($link, $sql)) {
                        $searchvalue = "%" . $_POST['txtsearch'] . "%";

                        // Bind parameters based on usertype
                        if ($_SESSION['usertype'] == 'TECHNICAL') {
                            mysqli_stmt_bind_param($stmt, "ssss", $searchvalue, $searchvalue, $searchvalue, $_SESSION['username']);
                        } else {
                            mysqli_stmt_bind_param($stmt, "sss", $searchvalue, $searchvalue, $searchvalue);
                        }

                        if (mysqli_stmt_execute($stmt)) {
                            $result = mysqli_stmt_get_result($stmt);
                            buildTable($result);
                        } else {
                            echo "<div class='error'>Error executing search query: " . mysqli_error($link) . "</div>";
                        }
                    } else {
                        echo "<div class='error'>Error preparing search query: " . mysqli_error($link) . "</div>";
                    }
                } else { //load current data
                    if (isset($_GET['ticketnumber']) && !empty(trim($_GET['ticketnumber']))) {
                        $sql = "SELECT * FROM tbltickets WHERE ticketnumber = ?";
                        if ($stmt = mysqli_prepare($link, $sql)) {
                            mysqli_stmt_bind_param($stmt, "s", $_GET['ticketnumber']);
                            if (mysqli_stmt_execute($stmt)) {
                                $result = mysqli_stmt_get_result($stmt);
                                $ticket = mysqli_fetch_array($result, MYSQLI_ASSOC);
                            }
                        } else {
                            echo "<font color = 'red'>ERROR: Loading Tickets</font>";
                        }
                    } else {
                        // If the user is a technical user, restrict the query to tickets assigned to them
                        if ($_SESSION['usertype'] == 'ADMINISTRATOR' || $_SESSION['usertype'] == 'USER') {
                            $sql = "SELECT * FROM tbltickets ORDER BY datecreated DESC";
                        }
                        else{
                            $sql = "SELECT * FROM tbltickets WHERE assignedto = ? ORDER BY datecreated DESC";
                        }

                        if ($stmt = mysqli_prepare($link, $sql)) {
                            // Bind parameters based on usertype
                            if ($_SESSION['usertype'] == 'TECHNICAL') {
                                mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
                            }

                            if (mysqli_stmt_execute($stmt)) {
                                $result = mysqli_stmt_get_result($stmt);
                                buildTable($result);
                            } else {
                                echo "<div class='error'>Error executing default query: " . mysqli_error($link) . "</div>";
                            }
                        } else {
                            echo "<div class='error'>Error preparing default query: " . mysqli_error($link) . "</div>";
                        }
                    }
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

    <!-- Approve Modal -->
    <div id="approveModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('approveModal')">&times;</span>
            <h2>Approve Ticket</h2>
            <form action="approve-ticket.php" method="POST">
                <input type="hidden" name="ticketnumber" id="approveTicketNumber">
                <div class="form__btns">

                <input type="submit" value="Approve">
                <button type="button" onclick="closeModal('approveModal')">Cancel</button>

                </div>
            </form>
        </div>
    </div>

    <!-- Complete Ticket Modal -->
    <div id="completeModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('completeModal')">&times;</span>
            <h2>Complete Ticket</h2>
            <p>Are you sure you want to mark this ticket as completed?</p>
            <form action="complete-ticket.php" method="POST">
                <input type="hidden" name="ticketnumber" id="completeTicketNumber">
                <input type="submit" value="Complete">
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
        let errormsg = document.getElementById("php_error");
        document.getElementById("year").textContent = new Date().getFullYear();

        function assignTicket(ticketNumber) {
            window.location.href = "assign-ticket.php?ticketnumber=" + ticketNumber;
        }

        function approveTicket(ticketNumber) {
            document.getElementById('approveTicketNumber').value = ticketNumber;
            document.getElementById('approveModal').style.display = 'block';
        }

        function confirmDelete(ticketNumber) {
            document.getElementById('deleteTicketNumber').value = ticketNumber;
            document.getElementById('deleteModal').style.display = 'block';
        }

        function completeTicket(ticketNumber) {
            // Redirect to a page or handle the completion logic
            window.location.href = "complete-ticket.php?ticketnumber=" + ticketNumber;
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

        function completeTicket(ticketNumber) {
            document.getElementById('completeTicketNumber').value = ticketNumber;
            document.getElementById('completeModal').style.display = 'block';
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
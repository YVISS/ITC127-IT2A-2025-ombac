<?php

require_once '../core/config.php';
include '../core/session-checker.php';

$updatemsg = '';
$errormsg = '';

// Check if the search button is clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnsearch'])) {
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
    <link rel="stylesheet" href="../../css/general/modern-normalize.css">
    <link rel="stylesheet" href="../../css/general/sidebar.css">
    <link rel="stylesheet" href="../../css/general/session.css">
    <link rel="stylesheet" href="../../css/general/wrapper.css">
    <link rel="stylesheet" href="../../css/tickets/ticket-management.css">
    <title>Ticket Management - AU TECHNICAL SUPPORT MANAGEMENT SYSTEM</title>
</head>

<body>
    <nav class="sidebar close">
        <header class="sidebar_header">
            <i class="toggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-right-pipe">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M6 6l6 6l-6 6" />
                    <path d="M17 5v13" />
                </svg>
            </i>
            <li class="welcome">
                <div class="session section">
                    <?php
                    //check if session is recorded
                    if ($_SESSION['username']) {
                        echo "<div class='sessionuser''>Welcome,  " . $_SESSION['username'] . "</div>";
                        echo " <div class = 'sessiontype' style='font-size: 12px;'>Usertype: " . $_SESSION['usertype'] . "</div>";
                    } else {
                        header("location: database\src\core\login.php");
                    }
                    ?>
                </div>
            </li>
        </header>
        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <?php
                    switch ($_SESSION['usertype']) {
                        case 'ADMINISTRATOR':
                            echo "<li class='nav-link'>";
                            echo "<a href='../core/index.php'>
                            <svg  xmlns=\"http://www.w3.org/2000/svg\"  width=\"24\"  height=\"24\"  viewBox=\"0 0 24 24\"  fill=\"none\"  stroke=\"currentColor\"  stroke-width=\"2\"  stroke-linecap=\"round\"  stroke-linejoin=\"round\"  class=\"icon icon-tabler icons-tabler-outline icon-tabler-home\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M5 12l-2 0l9 -9l9 9l-2 0\" /><path d=\"M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7\" /><path d=\"M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6\" /></svg>
                            <span class='text nav-text'>Home</span></a>";
                            echo "</li>";
                            echo "<li class='nav-link'>";
                            echo "<a href='../accounts/accounts-management.php'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-users'>
                                <path stroke='none' d='M0 0h24v24H0z' fill='none' />
                                <path d='M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0' />
                                <path d='M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2' />
                                <path d='M16 3.13a4 4 0 0 1 0 7.75' />
                                <path d='M21 21v-2a4 4 0 0 0 -3 -3.85' />
                            </svg>
                            <span class='text nav-text'>Accounts</span></a>";
                            echo "</li>";
                            echo "<li class='nav-link'>";
                            echo "<a href='../equipment/equipment-management.php'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-package'>
                                <path stroke='none' d='M0 0h24v24H0z' fill='none'/>
                                <path d='M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5' />
                                <path d='M12 12l8 -4.5' />
                                <path d='M12 12l0 9' />
                                <path d='M12 12l-8 -4.5' />
                                <path d='M16 5.25l-8 4.5' />
                            </svg>
                            <span class='text nav-text'>Equiments</span></a>";
                            echo "</li>";
                            echo "<li class='nav-link'>";
                            echo "<a href='../ticket/ticket-management.php'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-ticket'>
                                <path stroke='none' d='M0 0h24v24H0z' fill='none'/>
                                <path d='M15 5l0 2' />
                                <path d='M15 11l0 2' />
                                <path d='M15 17l0 2' />
                                <path d='M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2' />
                            </svg>
                            <span class='text nav-text'>Tickets</span></a>";
                            echo "</li>";
                            break;
                        case 'TECHNICAL':
                            echo "<li class='nav-link'>";
                            echo "<a href='../core/index.php'>
                            <svg  xmlns=\"http://www.w3.org/2000/svg\"  width=\"24\"  height=\"24\"  viewBox=\"0 0 24 24\"  fill=\"none\"  stroke=\"currentColor\"  stroke-width=\"2\"  stroke-linecap=\"round\"  stroke-linejoin=\"round\"  class=\"icon icon-tabler icons-tabler-outline icon-tabler-home\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M5 12l-2 0l9 -9l9 9l-2 0\" /><path d=\"M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7\" /><path d=\"M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6\" /></svg>
                            <span class='text nav-text'>Home</span></a>";
                            echo "</li>";
                            echo "<li class='nav-link'>";
                            echo "<a href='../equipment/equipment-management.php'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-package'>
                                <path stroke='none' d='M0 0h24v24H0z' fill='none'/>
                                <path d='M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5' />
                                <path d='M12 12l8 -4.5' />
                                <path d='M12 12l0 9' />
                                <path d='M12 12l-8 -4.5' />
                                <path d='M16 5.25l-8 4.5' />
                            </svg>
                            <span class='text nav-text'>Equiments</span></a>";
                            echo "</li>";
                            echo "<li class='nav-link'>";
                            echo "<a href='../ticket/ticket-management.php'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-ticket'>
                                <path stroke='none' d='M0 0h24v24H0z' fill='none'/>
                                <path d='M15 5l0 2' />
                                <path d='M15 11l0 2' />
                                <path d='M15 17l0 2' />
                                <path d='M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2' />
                            </svg>
                            <span class='text nav-text'>Tickets</span></a>";
                            echo "</li>";
                            break;
                        case 'USER':
                            // For students and staff, no visible pages
                            echo "<li class='nav-link'>";
                            echo "<a href='../core/index.php'>
                            <svg  xmlns=\"http://www.w3.org/2000/svg\"  width=\"24\"  height=\"24\"  viewBox=\"0 0 24 24\"  fill=\"none\"  stroke=\"currentColor\"  stroke-width=\"2\"  stroke-linecap=\"round\"  stroke-linejoin=\"round\"  class=\"icon icon-tabler icons-tabler-outline icon-tabler-home\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M5 12l-2 0l9 -9l9 9l-2 0\" /><path d=\"M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7\" /><path d=\"M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6\" /></svg>
                            <span class='text nav-text'>Home</span></a>";
                            echo "</li>";
                            echo "<li class='nav-link'>";
                            echo "<a href='../ticket/ticket-management.php'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-ticket'>
                                <path stroke='none' d='M0 0h24v24H0z' fill='none'/>
                                <path d='M15 5l0 2' />
                                <path d='M15 11l0 2' />
                                <path d='M15 17l0 2' />
                                <path d='M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2' />
                            </svg>
                            <span class='text nav-text'>Tickets</span></a>";
                            echo "</li>";
                            break;
                        default:
                            // Handle unknown usertypes
                            echo "<p>Unknown usertype.</p>";
                            break;
                    }
                    ?>
                    <li class="nav-link">

                    </li>

                </ul>
            </div>
            <div class="logout">
                <li class="nav-link">
                    <a href="../core/logout.php" class="logout">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                            <path d="M15 12h-12l3 -3" />
                            <path d="M6 15l-3 -3" />
                        </svg>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>
            </div>
        </div>
    </nav>
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
                        <h1>Ticket Management</h1><br>
                        <p style="text-align: center;">Manage your tickets here</p>
                    </div>
                    <div id="php_error" class="error">
                        <?php
                        if (isset($_GET['updatemsg'])) {
                            echo "<div class='msg' style='color: green;'>" . htmlspecialchars($_GET['updatemsg']) . "</div>";
                        }
                        if (isset($_GET['errormsg'])) {
                            echo "<div class='msg' style='color: red;'>" . htmlspecialchars($_GET['errormsg']) . "</div>";
                        }
                        ?>
                    </div>
                    <div class="form section">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <div class="search">
                                
                                <button type="button" onclick="window.location.href='create-ticket.php'">Create Ticket</button>
                                <input type="text" name="txtsearch" placeholder="Search...">
                                <button type="submit" name="btnsearch">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <circle cx="10" cy="10" r="7" />
                                        <line x1="21" y1="21" x2="15" y2="15" />
                                    </svg>
                                    Search
                                </button>
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
                                            echo "<a href='#' onclick='confirmComplete(\"" . $row['ticketnumber'] . "\")'><svg class='complete' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='currentColor' class='icon icon-tabler icons-tabler-filled icon-tabler-star'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z' /></svg></a>";
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
                                } else {
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
            </div>
            <footer>
                <p>&copy; <span id="year"></span> AU Technical Support Management System. All Rights Reserved.</p>
            </footer>
        </div>
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
        </div>
    </div>

      <!-- Complete Ticket Modal -->
      <div id="completeModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('completeModal')">&times;</span>
            <h2>Complete Ticket</h2>
            <p>Are you sure you want to mark this ticket as completed?</p>
            <form id="completeForm" action="complete-ticket.php" method="POST">
                <input type="hidden" name="ticketnumber" id="completeTicketNumber">
                <div class="form__btns">
                    <input type="submit" value="Yes" name="btnsubmit" class="btn btn-success">
                    <button type="button" onclick="closeModal('completeModal')" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>

     <!-- Approve Modal -->
     <div id="approveModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('approveModal')">&times;</span>
            <h2>Approve Ticket</h2>
            <p>Are you sure you want to approve?</p>
            <form action="approve-ticket.php" method="POST">
                <input type="hidden" name="ticketnumber" id="approveTicketNumber">
                <div class="form__btns">
                <input type="submit" value="Approve">
                <button type="button" onclick="closeModal('approveModal')">Cancel</button>

                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById("year").textContent = new Date().getFullYear();
        const body = document.querySelector("body"),
        sidebar = body.querySelector(".sidebar"),
        toggle = sidebar.querySelector(".toggle");


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
            document.getElementById('detailsModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function confirmComplete(ticketnumber) {
            document.getElementById('completeTicketNumber').value = ticketnumber;
            document.getElementById('completeModal').style.display = 'block';
        }

        function approveTicket(ticketNumber) {
            document.getElementById('approveTicketNumber').value = ticketNumber;
            document.getElementById('approveModal').style.display = 'block';
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('deleteModal')) {
                closeModal('deleteModal');
            }
            if (event.target == document.getElementById('detailsModal')) {
                closeModal('detailsModal');
            }
            if (event.target == document.getElementById('completeModal')) {
                closeModal('completeModal');
            }
        }

        toggle.addEventListener("click", () => {
        // Toggle the 'close' class on the sidebar
        const isClosed = sidebar.classList.toggle("close");

        // Change the toggle icon based on the sidebar state
        if (isClosed) {
            toggle.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-right-pipe">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M6 6l6 6l-6 6" />
                    <path d="M17 5v13" />
                </svg>`;
        } else {
            toggle.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left-pipe">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M7 6v12" />
                    <path d="M18 6l-6 6l6 6" />
                </svg>`;
        }
    });
    </script>
</body>

</html>
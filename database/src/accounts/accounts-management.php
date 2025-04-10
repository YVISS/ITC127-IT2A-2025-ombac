<?php
require_once '../core/config.php';
include '../core/session-checker.php';
$updatemsg = '';
$errormsg = '';

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
    <link rel="stylesheet" href="../../css/accounts/accounts-management.css">
    <title>Accounts Management Page - AU TECHNICAL SUPPORT MANAGEMENT SYSTEM</title>
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
                        <h1>Accounts Management</h1><br>
                        <p style="text-align: center;">Create, Update, and Delete Accounts</p>
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
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">

                            <div class="search">
                                <button type="button" onclick="window.location.href='create-account.php'">+ Create Account</button>
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
                                echo "<th>Username</th><th>Usertype</th><th>Status</th><th>Created by</th><th>Date Created</th><th>Action</th>";
                                echo "</tr>";
                                //display the data
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr class='row'>";
                                    echo "<td>" . $row['username'] . "</td>";
                                    echo "<td>" . $row['usertype'] . "</td>";
                                    echo "<td>" . $row['status'] . "</td>";
                                    echo "<td>" . $row['createdby'] . "</td>";
                                    echo "<td>" . $row['datecreated'] . "</td>";
                                    echo "<td><a href='update-account.php?username=" . $row['username'] . "'>Update</a> | <a href='#' onclick='confirmDelete(\"" . $row['username'] . "\")'>Delete</a></td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "No record/s found";
                            }
                        }
                        //check if the search button is clicked
                        if (isset($_POST['btnsearch'])) {
                            $sql = "SELECT * FROM tblaccounts WHERE username LIKE ? OR usertype LIKE ? ORDER BY username ASC";
                            if ($stmt = mysqli_prepare($link, $sql)) {
                                $searchvalue  = "%" . $_POST['txtsearch'] . "%";
                                mysqli_stmt_bind_param($stmt, "ss", $searchvalue, $searchvalue);
                                if (mysqli_stmt_execute($stmt)) {
                                    $result = mysqli_stmt_get_result($stmt);
                                    buildTable($result);
                                }
                            } else {
                                echo $msg .= "Error: " . mysqli_error($link);
                            }
                        } else {
                            $sql = "SELECT * FROM tblaccounts ORDER BY username ASC";
                            if ($stmt = mysqli_prepare($link, $sql)) {
                                if (mysqli_stmt_execute($stmt)) {
                                    $result = mysqli_stmt_get_result($stmt);
                                    buildTable($result);
                                }
                            } else {
                                echo $msg .= "Error: " . mysqli_error($link);
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Delete Account Modal -->
            <div id="deleteModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('deleteModal')">&times;</span>
                    <h2>Delete Account</h2>
                    <p>Are you sure you want to delete this account?</p>
                    <form id="deleteForm" method="POST">
                        <input type="hidden" name="username" id="deleteUsername">
                        <div class="form__btns">
                            <input type="submit" value="Yes" name="btnsubmit">
                            <button type="button" onclick="closeModal('deleteModal')">Cancel</button>
                        </div>
                    </form>
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
    const body = document.querySelector("body"),
        sidebar = body.querySelector(".sidebar"),
        toggle = sidebar.querySelector(".toggle");
    
        

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



    function confirmDelete(username) {
        document.getElementById('deleteUsername').value = username;
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('deleteModal')) {
            closeModal('deleteModal');
        }
    };
</script>

</html>
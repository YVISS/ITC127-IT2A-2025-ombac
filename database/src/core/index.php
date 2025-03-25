<?php
require_once './config.php';
include './session-checker.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../../css/general/index.css">
    <link rel="stylesheet" href="../../css/general/modern-normalize.css">
    <title>AU TECHNICAL SUPPORT MANAGEMENT SYSTEM</title>
</head>

<body>
    <nav class="sidebar">
        <header class="sidebar_header">
            <i class="toggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left-pipe">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 6v12" />
                    <path d="M18 6l-6 6l6 6" />
                </svg>
            </i>
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
                    <a href="logout.php">
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
                <h1>AU TSMS</h1>
                <div class="session section">
                    <?php
                    //check if session is recorded
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
                    <h1>AU Techincal Support Management System</h1><br>
                    <p style="text-align: center;"></p>
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

            </div>
            <footer>
                <p>&copy; <span id="year"></span> AU Technical Support Management System. All Rights Reserved.</p>
            </footer>
        </div>

    </div>

    <!-- Delete Account Modal -->

</body>

<script>
    document.getElementById("year").textContent = new Date().getFullYear();
    let errormsg = document.getElementById("php_error");
    // Show password
    let passwordInput = document.getElementById("password");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        let eye = document.getElementById('togglePassIcon').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EEEEE"><path d="m644-428-58-58q9-47-27-88t-93-32l-58-58q17-8 34.5-12t37.5-4q75 0 127.5 52.5T660-500q0 20-4 37.5T644-428Zm128 126-58-56q38-29 67.5-63.5T832-500q-50-101-143.5-160.5T480-720q-29 0-57 4t-55 12l-62-62q41-17 84-25.5t90-8.5q151 0 269 83.5T920-500q-23 59-60.5 109.5T772-302Zm20 246L624-222q-35 11-70.5 16.5T480-200q-151 0-269-83.5T40-500q21-53 53-98.5t73-81.5L56-792l56-56 736 736-56 56ZM222-624q-29 26-53 57t-41 67q50 101 143.5 160.5T480-280q20 0 39-2.5t39-5.5l-36-38q-11 3-21 4.5t-21 1.5q-75 0-127.5-52.5T300-500q0-11 1.5-21t4.5-21l-84-82Zm319 93Zm-151 75Z"/></svg>';
    } else {
        passwordInput.type = "password";
        let eye = document.getElementById('togglePassIcon').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EEEEE"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>';
    }

    setTimeout(() => {
        if (errormsg) {
            errormsg.style.transition = "opacity 1s";
            errormsg.style.opacity = "0";
            setTimeout(() => errormsg.style.display = none, 1000);
        }
    }, 3000);
</script>
<script>
    const body = document.querySelector("body"),
        sidebar = body.querySelector(".sidebar"),
        toggle = sidebar.querySelector(".toggle");

    toggle.addEventListener("click", () => {
        // Toggle class and check if it's added
        const isClosed = sidebar.classList.toggle("close");

        // Change the inner HTML based on the class state
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

</html>
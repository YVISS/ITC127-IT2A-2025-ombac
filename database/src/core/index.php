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
    <link rel="stylesheet" href="../../css/general/card.css">
    <link rel="stylesheet" href="../../css/general/sidebar.css">
    <link rel="stylesheet" href="../../css/general/wrapper.css">
    <title>AU TECHNICAL SUPPORT MANAGEMENT SYSTEM</title>
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
                        header("location: login.php");
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
                <div class="logo">
                </div>
                <div class="page-title">
                <img src="../../src/images/au_logo.png" alt="Arellano University Logo">
                    <h1>AU Technical Support Management System</h1>
                </div>


            </header>
            <div class="main-content">


            </div>
            <footer>
                <p>&copy; Copyright <span id="year"></span> AU Technical Support Management System. All Rights Reserved.
                </p>
            </footer>
        </div>

    </div>
</body>

<script>
    document.getElementById("year").textContent = new Date().getFullYear();
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
</script>

</html>
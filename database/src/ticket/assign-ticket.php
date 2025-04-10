<?php
// filepath: /Applications/XAMPP/xamppfiles/htdocs/ITC127-IT2A-2025-ombac/database/src/ticket/assign-ticket.php
require_once '../core/config.php';
include '../core/session-checker.php';
include '../core/errors.php';

$msg = '';
$errormsg = '';
$updatemsg = '';


// Check if ticket number is provided
if (!isset($_GET['ticketnumber']) || empty($_GET['ticketnumber'])) {
    header("Location: ticket-management.php");
    exit();
}

$ticketnumber = $_GET['ticketnumber'];

// Fetch ticket details
$sql = "SELECT * FROM tbltickets WHERE ticketnumber = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "s", $ticketnumber);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $ticket = mysqli_fetch_assoc($result);
    if (!$ticket) {
        echo "Ticket not found.";
        exit();
    }
} else {
    echo "Error fetching ticket details.";
    exit();
}

// Fetch all technicians
$sql = "SELECT username FROM tblaccounts WHERE usertype = 'TECHNICAL'";
$technicians = mysqli_query($link, $sql);

if (isset($_POST['btnsave'])) {
    $ticketnumber = $_POST['ticketnumber'];
    $technician = $_POST['technician'];
    $dateAssigned = date("Y-m-d H:i:s");

    // Update ticket details
    $sql = "UPDATE tbltickets SET status = 'ONGOING', dateAssigned = ?, assignedTo = ? WHERE ticketnumber = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sss", $dateAssigned, $technician, $ticketnumber);
        if (mysqli_stmt_execute($stmt)) {
            $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, performedby, performedto) VALUES (?,?,?,?,?,?)";
            if ($stmt = mysqli_prepare($link, $sql)) {
                $date = date('d/m/Y');
                $time = date("h:i:sa");
                $action = "Assigned";
                $module = "Assign Ticket";
                mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $_SESSION['username'], $technician);
                if (mysqli_stmt_execute($stmt)) {
                    $updatemsg = "Ticket Assigned to " . $technician;
                    header("location: ticket-management.php?updatemsg=" . urlencode($updatemsg));
                    exit();
                }
            } else {
                $errormsg = "ERROR: Inserting logs";
                header("location: ticket-management.php?errormsg=" . urlencode($errormsg));
                exit();
            }
            // Redirect back to ticket management page

        } else {
            echo "Error updating ticket: " . mysqli_error($link);
        }
    } else {
        echo "Error preparing query: " . mysqli_error($link);
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
            echo "<font color = 'red'>ERROR: Loading Account</font>";
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
    <link rel="stylesheet" href="../../css/general/session.css">
    <link rel="stylesheet" href="../../css/general/wrapper.css">
    <link rel="stylesheet" href="../../css/tickets/assign-ticket.css">
    <title>Ticket Management Page - AU TECHNICAL SUPPORT MANAGEMENT SYSTEM</title>
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
                        <h1>Assign Ticket</h1><br>
                        <p style="text-align: center;">Assign your tickets to Technicians</p>
                    </div>

                    <div class="form">
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST">
                            <input type="hidden" name="ticketnumber" value="<?php echo $ticket['ticketnumber']; ?>">

                            <div class="form__ticketnumber">
                                <h2>Ticket Number</h2>
                                <input type="text" name="txtticketnumber" id="" readlonly value="<?php echo $ticket['ticketnumber']; ?>">
                            </div>

                            <div class="form__problem">
                                <h2>Problem</h2>
                                <input type="text" name="problem" id="" readonly value="<?php echo $ticket['problem']; ?>">
                            </div>

                            <div class="form__details">
                                <h2>Details</h2>
                                <input type="text" name="details" id="" readonly value="<?php echo $ticket['details']; ?>">
                            </div>

                            <div class="form__technician">
                                <h2>Assign to a Technician</h2>
                                <select name="technician" id="technician" required>
                                    <option value=""><?php echo "Current Technician: " .  $ticket['assignedto']; ?></option>
                                    <?php while ($row = mysqli_fetch_assoc($technicians)) { ?>
                                        <option value="<?php echo $row['username']; ?>"><?php echo $row['username']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>


                            <div class="form__btns">
                                <button type="submit" name="btnsave" value="">Assign</button>

                                <a href="ticket-management.php">Cancel</a>
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
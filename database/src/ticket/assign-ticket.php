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
                mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $_SESSION['username'], $ticketnumber);
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
}else { //load current data
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
    <title>Assign Ticket</title>

    <link rel="stylesheet" href="../../css/general/modern-normalize.css ">
    <link rel="stylesheet" href="../../css/tickets/assign-ticket.css">
</head>

<body>
    <div class="wrapper">
        <h1>Assign Ticket</h1>
        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST">
            <input type="hidden" name="ticketnumber" value="<?php echo $ticket['ticketnumber']; ?>">

            <label for="ticketnumber">Ticket Number:</label>
            <p><?php echo $ticket['ticketnumber']; ?></p>

            <label for="problem">Problem:</label>
            <p><?php echo $ticket['problem']; ?></p>

            <label for="details">Details:</label>
            <p><?php echo $ticket['details']; ?></p>

            <label for="technician">Assign to Technician:</label>
            <select name="technician" id="technician" required>
                <option value=""><?php echo"Current Technician: ".  $ticket['assignedto'];?></option>
                <?php while ($row = mysqli_fetch_assoc($technicians)) { ?>
                    <option value="<?php echo $row['username']; ?>"><?php echo $row['username']; ?></option>
                <?php } ?>
            </select>

            <div class="form-buttons">
                <input type="submit" name="btnsave" value="Submit">
                <button type="button" onclick="window.location.href='ticket-management.php'">Cancel</button>
            </div>
        </form>
    </div>
</body>

</html>
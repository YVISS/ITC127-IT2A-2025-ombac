<?php

require_once '../core/config.php';
include '../core/session-checker.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnupdate'])) {
    $ticketnumber = $_GET['ticketnumber'];
    $problem = $_POST['cmbproblem'];
    $status = $_POST['cmbstatus'];
    $details = $_POST['txtdetails'];

    $sql = "UPDATE tbltickets SET problem = ?, details = ?, status=? WHERE ticketnumber = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssss", $problem, $details,$status, $ticketnumber);
        if (mysqli_stmt_execute($stmt)) {
            $msg = "Ticket updated successfully";
            header("Location: ticket-management.php?updatemsg=" . urlencode($msg)); 
            exit();
        } else {
            $msg = "Error updating ticket";
        }
    } else {
        $msg = "Error on Update Ticket statement: " . mysqli_connect_error();
    }
} else {
    if (isset($_GET['ticketnumber']) && !empty(trim($_GET['ticketnumber']))) {
        $sql = "SELECT * FROM tbltickets WHERE ticketnumber = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $_GET['ticketnumber']);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                $ticket = mysqli_fetch_array($result, MYSQLI_ASSOC);
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
    <link rel="stylesheet" href="../../css/general/modern-normalize.css ">
    <link rel="stylesheet" href="../../css/tickets/update-ticket.css">
    <title>Update Ticket - AU TECHNICAL SUPPORT MANAGEMENT SYSTEM</title>
</head>
<body>
    <div class="wrapper">
        <header>
            <h1>Update Ticket</h1>
        </header>
        <div class="main-content">
            <div class="form">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?ticketnumber=" . $_GET['ticketnumber']); ?>" method="POST">
                    <label>Ticket Number: <strong><?php echo $ticket['ticketnumber']; ?></strong></label><br>
                    <select name="cmbproblem" required>
                        <option value="<?php echo $ticket['problem']; ?>">Current: <?php echo $ticket['problem']; ?></option>
                        <option value="Hardware">Hardware</option>
                        <option value="Software">Software</option>
                        <option value="Connection">Connection</option>
                    </select><br>
                    <select name="cmbstatus" required>
                        <option value="">Current: <?php echo $ticket['status']; ?></option>
                        <option value="PENDING">Pending</option>
                        <option value="ONGOING">On-Going</option>
                        <option value="FOR APPROVAL">For Approval</option>

                        <option value="COMPLETED">Complete</option>
                        <option value="CLOSED">Closed</option>
                    </select><br>
                    <textarea name="txtdetails" required><?php echo $ticket['details']; ?></textarea><br>
                    <button name="btnupdate" type="submit">Update Ticket</button>
                    <a href="ticket-management.php">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
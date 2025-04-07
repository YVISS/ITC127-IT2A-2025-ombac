<?php
require_once '../core/config.php';
include '../core/session-checker.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btncreate'])) {
    $ticketnumber = date("YmdHis"); // Auto-generate ticket number
    $problem = $_POST['cmbproblem'];
    $details = $_POST['txtdetails'];
    $status = 'PENDING';
    $createdby = $_SESSION['username'];
    $datecreated = date("d/m/Y:H:i:s");

    $sql = "INSERT INTO tbltickets (ticketnumber, problem, details, status, createdby, datecreated) VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssss", $ticketnumber, $problem, $details, $status, $createdby, $datecreated);
        if (mysqli_stmt_execute($stmt)) {
            $msg = "Ticket created successfully";
            header("Location: ticket-management.php?updatemsg=" . urlencode($msg));
            exit();
        } else {
            $msg = "Error creating ticket";
        }
    } else {
        $msg = "Error on Create Ticket statement: " . mysqli_connect_error();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/general/modern-normalize.css">
    <link rel="stylesheet" href="../../css/tickets/create-ticket.css">
    <title>Create Ticket - AU TECHNICAL SUPPORT MANAGEMENT SYSTEM</title>
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
                <h1>Create Ticket</h1><br>
                <p style="text-align: center;">Fill in the details to create a new ticket</p>
            </div>
            <div id="php_error" class="error">
                <?php
                if (!empty($msg)) {
                    echo "<div class='msg' style='color: red;'>$msg</div>";
                }
                ?>
            </div>
            <div class="form section">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <label>Ticket Number: <strong><?php echo date("YmdHis"); ?></strong></label><br>
                    <select name="cmbproblem" required>
                        <option value="">--Select Problem--</option>
                        <option value="Hardware">Hardware</option>
                        <option value="Software">Software</option>
                        <option value="Connection">Connection</option>
                    </select><br>
                    <select name="cmbstatus" required>
                        <option value="" disabled>--SELECT OPTION--</option>
                        <option value="PENDING" selected disabled>Pending</option>
                    </select><br>
                    <textarea name="txtdetails" placeholder="Enter problem details..."  required rows="15" cols="45"></textarea><br>
                    
                    <button name="btncreate" type="submit">Create Ticket</button>
                    <a href="ticket-management.php">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
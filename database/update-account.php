<?php
    require_once "config.php";
    include "session-checker.php";
    include "errors.php";

    if(isset($_POST['btnsubmit']))
    {
        $sql = "UPDATE tblaccounts SET password =?, usertype =?, status = ? WHERE username=?";
        if ($stmt = mysqli_prepare($link, $sql)) 
        {
            mysqli_stmt_bind_param($stmt, "ssss", $_POST['txtpassword'], $_POST['cmbtype'], $_POST['rbstatus'], $_GET['username']);
            if(mysqli_stmt_execute($stmt)){
                $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, performedby, performedto) VALUES (?,?,?,?,?,?)";
                if($stmt = mysqli_prepare($link, $sql))
                {
                    $date = date('d/m/Y');
                    $time = date("h:i:sa");
                    $action = "Update";
                    $module = "Accounts Management";
                    mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $_SESSION['username'],$_GET['username']);
                    if(mysqli_stmt_execute($stmt)){
                        echo "User Account Updated";
                        header("location: accounts-management.php");
                        exit();
                    }
                }
                else{
                    echo "<font color ='red'>ERROR: Inserting logs</font>";
                }
            }
        }
        else{
            echo "<font color = 'red'>ERROR: Updating Account</font>";
        }
    }
    else{ //load current data
        if(isset($_GET['username']) && !empty(trim($_GET['username']))){
            $sql = "SELECT * FROM tblaccounts WHERE username = ?";
            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "s", $_GET['username']);
                if(mysqli_stmt_execute($stmt)){
                    $result = mysqli_stmt_get_result($stmt);
                    $account = mysqli_fetch_array($result, MYSQLI_ASSOC);
                }
            }else{
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
    <title>Update Account Page - AU Technical Support Management System</title>
</head>
<body>
    <p>Change the value on this form and submit to update the account</p>
    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST">
    Username: <?php echo $account['username'];?><br>
    Password: <input type="password" name="txtpassword" value="<?php echo $account['password'];?>" required><br>
    Current Usertype: <?php echo $account['usertype'];?><br>
    Change Usertype To: <select name="cmbtype" id="cmbtype" required>
        <option value   =  "">--Select Account Type--</option>
        <option value   =  "ADMINISRTATOR">Administrator</option>
        <option value   =  "TECHNICAL">Technical</option>
        <option value   =  "STAFF">Staff</option>
    </select><br>
    Status: <br>
    <?php 
        $status = $account['status'];
        if($status == 'ACTIVE'){
            ?><input type="radio" name="rbstatus" value="ACTIVE" checked>Active<br>
            <input type="radio" name="rbstatus" value="INACTIVE">Inactive<br> <?php
        }else{
            ?><input type="radio" name="rbstatus" value="ACTIVE">Active<br>
            <input type="radio" name="rbstatus" value="INACTIVE" checked>Inactive<br> <?php
        }
    ?>
    <input type="submit" name="btnsubmit" value="Submit">
    <a href="accounts-management.php">Cancel</a>

    </form>
</body>
</html>
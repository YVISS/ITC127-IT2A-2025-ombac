<?php
require_once 'config.php';
include 'session-checker.php';
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btncreate'])) {


    //check existing user
    $sql = "SELECT * FROM tblaccounts WHERE username = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        $param_username = $_POST['txtusername'];
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 0) {

                $sql = "INSERT INTO tblaccounts (username, password, usertype, status, createdby, datecreated) VALUES (?, ?, ?, ?, ?,?)";
                if ($stmt = mysqli_prepare($link, $sql)) {

                    $username = $_POST['txtusername'];
                    $password = $_POST['txtpassword'];
                    $usertype = $_POST['cmbtype'];
                    $createdby = $_SESSION['username'];
                    $status = "ACTIVE";
                    $datecreated = date("d/m/Y");

                    mysqli_stmt_bind_param($stmt, "ssssss", $username, $password, $usertype, $status, $createdby, $datecreated);
                    if (mysqli_stmt_execute($stmt)) {

                        $msg .= "<font color=blue>Account created successfully";
                    } else {

                        $msg .= "Error creating account";
                    }
                }
            } else {
                $msg .= "Username already exists";
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
    <link rel="stylesheet" href="css\modern-normalize.css">
    <link rel="stylesheet" href="css\accounts-management.css">
    <title>Accounts Management Page - AU TECHNICAL SUPPORT MANAGEMENT SYSTEM</title>
</head>

<body>
    <div class="wrapper">
        <header>
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
                <h1>Accounts Management</h1><br>
                <p style="text-align: center;">Create, Update, and Delete Accounts</p>
                <div id="php_error" class="error" style="text-align: center;"><?php echo $msg;?></div>
            </div>
            <div class="form section">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                    <div class="form__btns">
                        <button id="openModalBtn" type="button">Create Account</button>
                        <button><a href="logout.php">Logout</a></button>
                    </div>
                    <div class="search">
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
                            echo "<td><a href='update-account.php?id=" . $row['username'] . "'>Update</a> | <a href='delete-account.php?id=" . $row['username'] . "'>Delete</a></td>";
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
        <footer>
            <p>&copy; <span id="year"></span> AU Technical Support Management System. All Rights Reserved.</p>
        </footer>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Create a New Account</h2>
            <div id="php_error" class="error">

            </div>
            <form id="createAccountForm" method="POST">
                <input type="text" name="txtusername" placeholder="Username" required><br>
                <div style="position: relative;">
                    <input type="password" name="txtpassword" id="password" placeholder="Password" required>
                    <span class="toggle-password" onclick="togglePassword()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                        </svg>
                    </span>
                </div>
                <select name="cmbtype" id="cmbtype" required>
                    <option value="">--Select Account Type--</option>
                    <option value="ADMINISTRATOR">Administrator</option>
                    <option value="TECHNICAL">Technical</option>
                    <option value="STAFF">Staff</option>
                </select><br>
                <button name="btncreate" type="submit">Create Account</button>
                <a href="accounts-management.php">Cancel</a>
            </form>
        </div>
    </div>

</body>

<script>
    document.getElementById("year").textContent = new Date().getFullYear();
    let errormsg = document.getElementById("php_error");
    errormsg.style.color = "red";
    errormsg.style.fontWeight = 400;
    // Show password
    function togglePassword() {
        let passwordInput = document.getElementById("password");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }

    setTimeout(() => {
        if (errormsg) {
            errormsg.style.transition = "opacity 1s";
            errormsg.style.opacity = "0";
            setTimeout(() => errormsg.style.display = "none", 1000);
        }
    }, 3000);

    // Open modal
    document.getElementById("openModalBtn").addEventListener("click", function() {
        document.getElementById("myModal").style.display = "block";
    });

    // Close modal
    document.querySelector(".close").addEventListener("click", function() {
        document.getElementById("myModal").style.display = "none";
    });

    // Close modal when clicking outside
    window.addEventListener("click", function(event) {
        if (event.target == document.getElementById("myModal")) {
            document.getElementById("myModal").style.display = "none";
        }
    });

    // Handle form submission without reloading the page
    document.getElementById("createAccountForm").addEventListener("submit", function(event) {

        const formData = new FormData(this);

        fetch("", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById("php_error").innerHTML = data;
            })
            .catch(error => console.error("Error:", error));
    });
</script>

</html>
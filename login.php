<?php
require('db.inc.php');
$msg="";
if(isset($_POST['emp_id']) && isset($_POST['password'])){
	$emp_id=mysqli_real_escape_string($con,$_POST['emp_id']);//to retrieve data securely 
	$password=mysqli_real_escape_string($con,$_POST['password']);
	$res=mysqli_query($con,"select * from employee where emp_id='$emp_id' and password='$password'");
	$count=mysqli_num_rows($res);
	if($count>0){
		$row=mysqli_fetch_assoc($res);
        $_SESSION['ROLE']=$row['role'];
        $_SESSION['IS_LOGIN']='yes';
        if($row['role']==1){
            header('location:pr_index.php');
            die();
        }
        if($row['role']==2){
            header('location:hr_index.php');
            die();
        }
        if($row['role']==3){
            // Run the SQL query to check if the employee ID and password match the database record
            $sql = "SELECT * FROM employee WHERE emp_id = '$emp_id' AND password = '$password'";
            $result = mysqli_query($con, $sql);
            
            // Check if there is a match
            if(mysqli_num_rows($result) == 1){
                // If there is a match, retrieve the corresponding employee record from the database
                $row = mysqli_fetch_assoc($result);
                // Store the employee ID in the session variable
                $_SESSION['emp_id'] = $row['emp_id'];
                // Redirect to the employee dashboard
                header("Location: emp_index.php?emp_id={$_POST['emp_id']}");
            } else{
                // If there is no match, redirect back to the login page with an error message
                $_SESSION['login_error'] = "Invalid employee ID or password.";
                header("Location:login.php");
            }
        }
	}else{
		$msg= 'Please enter correct credentials';
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THE BHAWANIPUR EDUCATION SOCIETY COLLEGE</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h2 style="text-align:left" class="logo"><img src="logo3.png" alt="logo" width="250" height="91"></h2>
    </header>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form action="" method="POST">
                    <h2>Login</h2>
                    <div class="inputbox">
                        <ion-icon name="person-outline"></ion-icon>
                        <input type="text" name="emp_id" pattern="[a-zA-Z0-9]+" required>
                        <label for="">User ID</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="password" required>
                        <label for="">Password</label>
                    </div>
                    <button type="submit">Login</button>
                </form>
                <h4 style="color: bisque;"><?php echo $msg?></h4>
            </div>
        </div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
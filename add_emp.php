<?php
require('header.php');

if(isset($_POST['submit'])){
  
  $emp_id=$_POST['emp_id'];
  $first_name=$_POST['first_name'];
  $last_name=$_POST['last_name'];
  $email=$_POST['email'];
  $gender=$_POST['gender'];
  $password=$_POST['password'];
  $phone=$_POST['phone'];
  $address=$_POST['address'];
  $DOJ=$_POST['DOJ'];


  // ----modification starts----
  $end_month = 12;

  $join_date = date('m', strtotime($DOJ)); //extracts the month number from a date string and stores it in another variable.

  if ($join_date >= 06) { //6=june
    $credit = abs($end_month - $join_date) + 06; //absolute no of credits
  } else {
    $credit = (07 - $join_date); //7=july
  }


  $sql_q="INSERT INTO employee (emp_id, first_name, last_name, email, gender, password, phone, address, DOJ, role) 
  VALUES ('$emp_id','$first_name','$last_name','$email','$gender','$password','$phone','$address','$DOJ','3')";

  $sql_credits = "INSERT INTO `leave` (`emp_id`, `leave_type`, `credits`) VALUES ('$emp_id', 'Casual Leave', '$credit'),('$emp_id', 'Medical Leave', '$credit'),('$emp_id', 'Earned Leave', '$credit');";

  $result = mysqli_query($con, $sql_q); 
  $credit_result = mysqli_query($con, $sql_credits);

// ----modification ends----
 
  if($result){
    header("Location: hr_index.php?msg=New record created succesfully");
  }
  else{
    echo "Failed " . mysqli_error($con);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD EMPLOYEE</title>
    <!--BootStrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!--Font Awesome links for icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>

<body>
  <nav class="navbar navbar-light justify-content-center fs-4 mb-4" style="background-color:khaki;">
      Employee Registration
  </nav>

  <div class="container">
    <div class="text-center">
        <h4>Add New Employee</h4>
        <p class="text-muted">Complete the form to add a new employee</p>
    </div>

    <div class="container d-flex justify-content-center">
      <form action="" method="Post" style="width: 50vw; min-width:300px;">
      <div class="row mb-3">
          <div class="col">
            <label class="form-label">Employee Id:</label>
            <input type="text" name="emp_id" pattern="[a-zA-Z0-9]+" class="form-control" placeholder="EMP**" required>
          </div>

          <div class="col">
            <label class="form-label">Password:</label>
            <input type="password" name="password" class="form-control" placeholder="Create Password" required>
            <!---<span class="error"> 
              <p class="error-text">
                <i class="fa-solid fa-circle-exclamation" style="color: #d80e0e;"></i>
                  Please enter atleast 8 characters with number,symbol,small and capital letter
              </p>
            </span>-->
          </div>

          
      </div>

        <div class="row mb-3">
          <div class="col">
            <label class="form-label">First Name:</label>
            <input type="text" class="form-control" name="first_name" placeholder="Alan" required>
          </div>

          <div class="col">
            <label class="form-label">Last Name:</label>
            <input type="text" class="form-control" name="last_name" placeholder="Turing" required>
          </div>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
        </div>

        <div class="form-group mb-3">
          <label>Gender:</label>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" class="form-check-input" name="gender" id="male" value="male">
          <label for="male" class="form-input-label">Male</label>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" class="form-check-input" name="gender" id="female" value="female">
          <label for="female" class="form-input-label">Female</label>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" class="form-check-input" name="gender" id="others" value="others">
          <label for="others" class="form-input-label">Others</label>
          &nbsp;&nbsp;
        </div>

        <div class="row mb-3">
          <div class="col">
            <label class="form-label">Address:</label>
            <textarea id="address" class="form-control" name="address" required></textarea>
          </div>

          <div class="col">
            <label class="form-label">Mobile Number: </label>
            <input type="tel" class="form-control" name="phone" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col">
            <label class="form-label">Date Of Joining:</label>
            <input type="date" id= "DOJ" class="form-control" name="DOJ" required><br>
          </div>

          <div class="col">
            <!--<label class="form-label">Role: </label>
            <input type="number" class="form-control" name="role" required>
          </div>-->
        </div>
      </form> 
        <div><br><center>
          <button type="submit" class="btn btn-success " name="submit">Save</button>
          <a href="hr_index.php" class="btn btn-danger ">Cancel</a></center>
        </div> 
    </div>
  </div>
  <script>
      var date=new Date();
      var tdate = date.getDate();
      var month = date.getMonth() + 1;
      if(tdate < 10){
        tdate = '0' + tdate;
      }
      if(month < 10){
        month = '0' + month;
      }
      var year = date.getUTCFullYear(); 
      var minDate= year + "-" + month + "-" + tdate;
      document.getElementById("DOJ").setAttribute('min',minDate);
      console.log(minDate);
  </script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
</body>
</html>
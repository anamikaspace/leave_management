<?php
require('header.php');
$emp_id=$_GET['emp_id'];
if(isset($_POST['submit'])){
  
  $first_name=$_POST['first_name'];
  $last_name=$_POST['last_name'];
  $email=$_POST['email'];
  $gender=$_POST['gender'];
  $phone=$_POST['phone'];
  $address=$_POST['address'];

  $sql_q="UPDATE employee SET first_name='$first_name',last_name='$last_name',email='$email',gender='$gender',phone='$phone',address='$address' WHERE emp_id= '$emp_id'";
  
  $result = mysqli_query($con, $sql_q);

  if($result){
    header("Location: hr_index.php?msg=Data Updated Succesfully");
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
    <title>UPDATE EMPLOYEE</title>
    <!--BootStrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <nav class="navbar navbar-light justify-content-center fs-4 mb-4" style="background-color:khaki;">
      Employee Registration
  </nav>

  <div class="container">
    <div class="text-center">
        <h4>Update Employee Information</h4>
        <p class="text-muted">Click on update after editing the information</p>
    </div>

    <?php
        $emp_id=$_GET['emp_id'];
        $sql = "SELECT * FROM employee WHERE emp_id='$emp_id'";
        $result=mysqli_query($con, $sql);
        $row=mysqli_fetch_assoc($result);
    ?>


    <div class="container d-flex justify-content-center">
      <form action="" method="Post" style="width: 50vw; min-width:300px;">
      <div class="row mb-3">
          <div class="col">
            <label class="form-label">Employee Id:</label>
            <?php echo $row['emp_id']?>
          </div>

          <!--<div class="col">
            <label class="form-label">Password:</label>
          </div>-->
      </div>

        <div class="row mb-3">
          <div class="col">
            <label class="form-label">First Name:</label>
            <input type="text" class="form-control" name="first_name" value="<?php echo $row['first_name']?>" required>
          </div>

          <div class="col">
            <label class="form-label">Last Name:</label>
            <input type="text" class="form-control" name="last_name" value="<?php echo $row['last_name']?>" required>
          </div>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" class="form-control" name="email" value="<?php echo $row['email']?>" required>
        </div>

        <div class="form-group mb-3">
          <label>Gender:</label>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" class="form-check-input" name="gender" id="male" value="male" <?php echo ($row['gender']=='male')?"checked":""; ?>>
          <label for="male" class="form-input-label">Male</label>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" class="form-check-input" name="gender" id="female" value="female" <?php echo ($row['gender']=='female')?"checked":""; ?>>
          <label for="female" class="form-input-label">Female</label>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" class="form-check-input" name="gender" id="others" value="others" <?php echo ($row['gender']=='others')?"checked":""; ?>>
          <label for="others" class="form-input-label">Others</label>
          &nbsp;&nbsp;
        </div>

        <div class="row mb-3">
          <div class="col">
            <label class="form-label">Address: </label>
            <input type="address" class="form-control" name="address" value="<?php echo $row['address']?>" required>
          </div>

          <div class="col">
            <label class="form-label">Mobile Number: </label>
            <input type="tel" class="form-control" name="phone" value="<?php echo $row['phone']?>" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col">
            <label class="form-label">Date Of Joining:</label>
            <?php echo $row['DOJ']?>
          </div>

          <div class="col">
            <!--<label class="form-label">Role: </label>
            <input type="number" class="form-control" name="role" required>
          </div>-->
        </div>

        <div><br><center>
          <button type="submit" class="btn btn-success " name="submit">Update</button>
          <a href="hr_index.php" class="btn btn-danger ">Cancel</a></center>
        </div>
      </form>  
    </div>
  </div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
</body>
</html>
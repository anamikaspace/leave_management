<?php
require('header.php');

$emp_id = $_GET['emp_id'];
$start_date = $_GET['start_date'];

$sql1 = "SELECT * FROM `transactions` WHERE emp_id = '".$emp_id."' AND start_date = '".$start_date."'";
$sql2 = "SELECT first_name, last_name FROM employee WHERE emp_id = '".$emp_id."'";
		
$result1 = mysqli_query($con,$sql1);
$result2 = mysqli_query($con,$sql2);

if(isset($_POST['submit'])){
	$emp_id = $_GET['emp_id'];
	$leave_type = $_POST['leave_type'];
	$start_date = $_GET['start_date'];
	$end_date = $_POST['end_date'];
	$no_of_days = $_POST['no_of_days'];
	$reason=$_POST['reason'];
	$status = $_POST['approve_reject'];
	
	$sql3="UPDATE transactions SET status = '".$status."' WHERE emp_id = '".$emp_id."' AND leave_type = '".$leave_type."' AND start_date = '".$start_date."' AND end_date = '".$end_date."'";
	if($status == "Approved")
	{
		$sql4 = "SELECT * FROM `leave` WHERE emp_id = '".$emp_id."' AND leave_type = '".$leave_type."' limit 1";
		
		$res4 = mysqli_query($con,$sql4);
		if($res4 === FALSE) { 
    			die(mysqli_error($con)); // TODO: better error handling
		}
		$row5 = mysqli_fetch_assoc($res4);
		$initial_number = $row5['leaves_taken'];
		
		$new_no_of_days = $no_of_days + $initial_number;
		$sql5 = "UPDATE `leave` SET leaves_taken = '".$new_no_of_days."' WHERE emp_id = '".$emp_id."' AND leave_type = '".$leave_type."'";
		$res5= mysqli_query($con,$sql5);	
	}
	$res3= mysqli_query($con,$sql3);
	
	echo 	"<script>
				alert(\"Leave ".$status.".\");
				window.location=\"pr_index.php\";</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APPROVE/REJECT</title>
    <!--BootStrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div id="content_panel">
    <div id="heading"><h3><center>Leave Requests Details</center></h3><hr size="2" color="#FFFFFF" ice:repeating=""/></div>
    <?PHP
		while($row = mysqli_fetch_assoc($result1))
		{
			$emp_id = $row['emp_id'];
			$leave_type = $row['leave_type'];
			$start_date = $row['start_date'];
			$end_date = $row['end_date'];
			$no_of_days = $row['days_requested'];
            $reason=$row['Reason'];
			$doc_file = $row['doc'];
			$status = $row['status'];

		}
		while($row1 = mysqli_fetch_assoc($result2))
		{
			$first_name = $row1['first_name'];
			$last_name = $row1['last_name'];
		}
	?>
	<div class="container d-flex justify-content-center">
		<form action="" method="Post" style="width: 50vw; min-width:300px;">
		<h5 style="color:DodgerBlue;">General Information:</h5>
			
			<div class="row mb-3">
        
           		 <label class="form-label">Employee Id:</label>
					<input type="text" name="emp_id"  class="form-control" readonly="true" value="<?php echo $emp_id?>">
          	
      		</div>

		<div class="row mb-3">
          <div class="col">
            <label class="form-label">First Name:</label>
            <input type="text" class="form-control" name="first_name" readonly="true" value="<?php echo $first_name?>">
          </div>

          <div class="col">
            <label class="form-label">Last Name:</label>
            <input type="text" class="form-control" name="last_name" readonly="true" value="<?php echo $last_name?>">
          </div>
        </div>
		
		<h5 style="color:DodgerBlue;">Leave Information:</h5>
		<div class="row mb-3">
			<label class="form-label">Leave Type:</label>
            <input type="text" class="form-control" name="leave_type" readonly="true" value="<?php echo $leave_type?>" >
		</div>
		
		<div class="row mb-3">
			<div class="col">
				<label class="form-label">Leave Begin:</label>
				<input type="text" class="form-control" name="start_date" id="start_date" readonly="true" value="<?php echo $start_date ?>">
			</div>

			<div class="col">
				<label class="form-label">Leave End:</label>
				<input type="text" class="form-control" name="end_date" id="end_date" readonly="true" value="<?php echo $end_date ?>">
			</div>

			<div class="col">
				<label class="form-label">Days Requested:</label>
				<input type="text" class="form-control" name="no_of_days" id="no_of_days" readonly="true" value="<?php echo $no_of_days ?>">
			</div>
		</div>

		<div class="row mb-3">
			<div class="col">
           		<label class="form-label">Reason:</label>
				<input type="text" name="reason"  class="form-control" readonly="true" value="<?php echo $reason?>">
			</div>

			<div class="col">
			<label class="form-label">View Document:</label><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php echo "<td> <a href='$doc_file' target='_blank' class='link-dark'><i class='fa-sharp fa-solid fa-file'></i></a>";
                ?> 
			</div>
		</div>

		<h5 style="color:DodgerBlue;">Approve/Reject Leave:</h5>
		<div class="row mb-3">
			<div class="col">
				<label class="form-label">Current Status:</label>
				<input type="text" name="status" readonly="true" placeholder="<?php echo $status?>">
			</div>

			<div class="col">
				<label class="form-label" for="approve_reject">Approve / Reject: </label>
				<select name="approve_reject" id="approve_reject">
					<option value="Approved">Approve</option>
					<option value="Rejected">Reject</option>
				</select>
			</div>
		</div>

		<center><button type="submit" class="btn btn-success " name="submit">Submit</button>
		<a href="pr_index.php" class="btn btn-danger ">Cancel</a></center>

			
		</form>
	</div>

</body>
</html>
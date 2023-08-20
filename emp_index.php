<?php

require('header.php');

$emp_id=$_GET['emp_id'];
$sql = "SELECT * FROM employee WHERE emp_id='$emp_id'";
$sql_q="SELECT * FROM `leave` WHERE emp_id='$emp_id'";
$sql_1="SELECT * FROM `transactions` WHERE emp_id='$emp_id'";

$result=mysqli_query($con, $sql);
$res=mysqli_query($con, $sql_q);
$res1=mysqli_query($con,$sql_1);
$row=mysqli_fetch_assoc($result);

function randomString() {
  $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
  $length = 10;
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, strlen($characters) - 1)];
  }
  return $randomString;
} 

if (isset($_POST['submit'])){
  $emp_id=$_GET['emp_id'];
  $leave_type = $_POST['leave_type'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$no_of_days = $_POST['days_requested'];
  $reason=mysqli_real_escape_string($con,$_POST['reason']);
	$status = "Pending"; 

  $extension = pathinfo($_FILES["doc"]["name"], PATHINFO_EXTENSION);
  $upload_path = "docs/".randomString().".".$extension; 
  $temp_name = $_FILES["doc"]["tmp_name"];

  move_uploaded_file($temp_name, $upload_path); 
  $res2=mysqli_query($con,$sql_q);

  while($row2=mysqli_fetch_assoc($res2)){
    $credits = $row2['credits'];
		$leaves_taken = $row2['leaves_taken'];
  }
  $new = $leaves_taken + $no_of_days;
	$balance_leaves = $credits - $leaves_taken;

  $res_q=mysqli_query($con,$sql_1);

  while($row_q=mysqli_fetch_assoc($res_q)){
    $ei=$row_q['emp_id'];
    $st=$row_q['start_date'];
    $et=$row_q['end_date'];
    if($emp_id==$ei && $start_date==$st && $end_date==$et){
      echo  "<script>
          alert(\"Already taken leave for the scheduled time\");
          window.location=\"logout.php\";</script>";
  }
}
  if($no_of_days > $credits)
	{
		echo	"<script>
				alert('Maximum ".$credits." Days Allowed.')</script>;
        <a href='emp_index.php?emp_id=".$emp_id."'></a>";
	}

	elseif($no_of_days <= 0)
	{
		echo	"<script>
				alert('Invalid no.of days requested')</script>;
				<a href='emp_index.php?emp_id=".$emp_id."'></a>";
	}

  else{
    $sql1="INSERT INTO `transactions`(`emp_id`, `leave_type`, `start_date`, `end_date`, `days_requested`, `Reason`, `status`, `doc`) VALUES ('$emp_id','$leave_type','$start_date','$end_date','$no_of_days','$reason','$status','$upload_path') "; 
    $result = mysqli_query($con, $sql1); 

    if($result){
      echo "<script>
            alert(\"Leave Request Submitted.\");
            window.location=\"logout.php\";</script>";
    }
    else{
      echo "Failed " . mysqli_error($con);
    }
  }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
    <!--BootStrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        p {
        color: red;
        font-size: smaller;
        }
    </style>

<script type="text/javascript" src="../jquery.js"></script>
<script>
	function total_days()
	{
		var start_date = document.getElementById("start_date");
		var end_date = document.getElementById("end_date");
		var start_day = new Date(start_date.value);
		var end_day = new Date(end_date.value);
		var milliseconds_per_day = 1000 * 60 * 60 * 24;
	
		var millis_between = end_day.getTime() - start_day.getTime();
		var days = millis_between / milliseconds_per_day;
	
		// Round down.
		//alert( Math.floor(days));
		
		var total_days = (Math.floor(days)) + 1;
		var combined = total_days;
		//alert(combined);
		//document.getElementById("date").value = (Math.floor(days)) ;
		var days_requested = document.getElementById('days_requested');
		days_requested.value = combined;
	}
	
	
</script>

</head>
<body>
    <nav class="navbar navbar-light justify-content-center fs-4 mb-4" style="background-color:khaki;">
        Employee Page
    </nav>

    <div class="container justify-content-center" style="width: 50vw; min-width:300px;">
      <div class="row mb-3">
          <div class="col">
            <label class="form-label">Employee Id:</label>
            <?php echo $row['emp_id']?>
          </div>

          <div class="col">
            <label class="form-label">Name:</label>
            <?php echo $row['first_name']?>&nbsp;<?php echo $row['last_name']?> 
          </div>
      </div>
      <div class=" row mb-3">
            <div class="col">
                <label class="form-label">Email:</label>
                <?php echo $row['email']?>
            </div>
            <div class="col">
                <label class="form-label">Gender:</label>
                <?php echo $row['gender']?>
            </div>
        </div>
        
        <div class=" row mb-3">
            <div class="col">
                <label class="form-label">Address:</label>
                <?php echo $row['address']?>
            </div>
            <div class="col">
                <label class="form-label">Mobile Number:</label>
                <?php echo $row['phone']?>
            </div>
        </div>
    </div>

    <fieldset><center>
    <legend style="background-color:khaki;">Current Leave Balances</legend>
    <div id="table">
    	<span>
      <table class="table table-hover text-center" >
        <thead class="table-dark">
          <tr>
            <th scope="col">Leave Types</th>
            <th scope="col">Maximum Leaves</th>
            <th scope="col">Leaves Taken</th>
            <th scope="col">Remaining Leaves</th>
				  </tr>
        </thead>
        <tbody>
        <?PHP
    while($row2 = mysqli_fetch_assoc($res))
		{
			$leave_type = $row2['leave_type'];
			$credits = $row2['credits'];
			$laves_taken = $row2['leaves_taken'];
			$remaining_leaves = $credits - $laves_taken;?>
			
      <tr>
        <td><?php echo $leave_type?></td>
        <td><?php echo $credits?></td>
        <td><?php echo $laves_taken?></td>
        <td><?php echo $remaining_leaves?></td>
      </tr>
		
    <?php  }
		
	?>
        </tbody>
        </table>
      </span></div></center>

    </fieldset>
<br><br>

<?php
  if(mysqli_num_rows($res1)>0){
     ?>
  <div class="text-center">
        <legend style="background-color:khaki;">Leave Transactions</legend>
    </div>
    <div id="table">
    	<span>
      <table class="table table-hover text-center" >
        <thead class="table-dark">
				<tr>
					<th scope="col">Leave Type</th>
					<th scope="col">Start Date</th>
					<th scope="col">End Date</th>
					<th scope="col">No. of Days</th>
					<th scope="col">Status</th>
				</tr>
        </thead>
			<tbody>
     <?PHP
		while($row = mysqli_fetch_assoc($res1))
		{
			$leave_type = $row['leave_type'];
			$start_date = $row['start_date'];
			$end_date = $row['end_date'];
			$no_of_days = $row['days_requested'];
			$status = $row['status'];?>
			
				<tr>
          <td><?php echo $leave_type?></td>
          <td><?php echo $start_date?></td>
          <td><?php echo $end_date?></td>
          <td><?php echo $no_of_days?></td>
          <td><?php echo $status?></td>
				</tr>
		
		<?php
      }
	?>
      </tbody>
    </table></span>
  </div></center>
   <?php 
  }
?>
  
    
    <div class="container">
      <div class="text-center">
      <br><legend>Leave Application Form</legend>
      </div>
      <br>
      <div class="container d-flex justify-content-center">
      <form action="" method="Post" enctype="multipart/form-data" style="width: 50vw; min-width:300px;">

          <div class="row mb-3">
              <label class="form-label">Type of leave:</label>
              <select id="leave_type" name="leave_type">
                <option value="Casual Leave">Casual Leave</option>
                <option value="Earned Leave">Earned Leave</option>
                <option value="Medical Leave">Medical Leave</option>
              </select>
          </div>

           <div class="multiple_days_leave" >     
              <label for="start_date" ><span>Start Date: <span class="required"></span></span>
        	      <input type="date" name="start_date" id="start_date" onchange="total_days()" />
              </label>
        
              <label for="end_date" ><span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                End Date: <span class="required"></span></span>
        	      <input type="date" name="end_date" id="end_date" onchange="total_days()" />
              </label>
   	        </div><br>

             <div class="leave_requested_days" >     
                <label for="days_requested" ><span>Days Requested </span>
        	        <input type="text" name="days_requested" id="days_requested" readonly="true" placeholder="No. of Days"/>
                </label>
   	          </div>

          <div class="row mb-3">
            <div class="col">
              <br><label class="form-label">Reason:</label>
              <textarea class="form-control" id="reason" name="reason" required></textarea>
            </div>

            <div class="col">
              <br><label>Upload Document:</label>
              <p> (*jpg,jpeg,pdf only)</p>
              <input type="file" class="form-control" id="doc" name="doc" accept=".jpg, .jpeg, .pdf">
            </div>
          </div>

        <div><br><center>
          <button type="submit" class="btn btn-success " name="submit">Apply</button>
          <a href="logout.php" class="btn btn-danger ">Cancel</a></center>
        </div> 
      </form> 
    </div>

    <script>
      var date= new Date();
      var tdate= date.getDate();
      if(tdate < 10){
        tdate="0" + tdate;
      }
      var month=date.getMonth()+1;
      if(month < 10){
        month="0" + month;
      }
      var year=date.getFullYear();

      var minDate = year + "-" + month + "-" + tdate;
      document.getElementById("start_date").setAttribute('min',minDate);
      document.getElementById("end_date").setAttribute('min',minDate);
      console.log(minDate);

    </script>
</body>
</html>
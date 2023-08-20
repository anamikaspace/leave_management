<?php
require('header.php');


$sql="SELECT * FROM `transactions` WHERE `status` = 'Pending'";
$result=mysqli_query($con,$sql);

$no_of_rows = mysqli_num_rows($result);


$sql_q=" SELECT * from employee e,transactions t where status='Pending' and e.emp_id=t.emp_id";
$res=mysqli_query($con,$sql_q); 


if($no_of_rows == 0)
		{
			echo 	"<script>
					alert(\"No Leave Requests to Show!\");
					window.location=\"logout.php\";</script>";
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
</head>
<body>
<nav class="navbar navbar-light justify-content-center fs-4" style="background-color:khaki;">
      Total Leave Requests:<?PHP echo $no_of_rows; ?><br><br></nav>
    <div id="table">
    	<span>
        <table class="table table-hover text-center" >
		    <thead class="table-dark">
          <tr>
            <th scope="col">EMPLOYEE ID</th>
            <th scope="col">EMPLOYEE NAME</th>
            <th scope="col">TYPE OF LEAVE</th>
            <th scope="col">LEAVE BEGIN</th>
            <th scope="col">LEAVE END</th>
            <th scope="col">REASON</th>
            <th scope="col">ACTION</th>
		</tr>
        </thead>
        <tbody>
        <?PHP
    while($row = mysqli_fetch_assoc($res))
		{
			$emp_id = $row['emp_id'];
            $first_name=$row['first_name'];
            $last_name=$row['last_name'];
			$leave_type = $row['leave_type'];
			$start_date = $row['start_date'];
			$end_date = $row['end_date'];
            $reason=$row['Reason'];?>

			<tr>
				<td><?php echo $emp_id?></td>
                <td><?php echo $first_name?><?php echo "&nbsp"?><?php echo $last_name?></td>
				<td><?php echo $leave_type?></td>
				<td><?php echo $start_date ?></td>
				<td><?php echo $end_date?></td>
                <td><?php echo $reason?></td>
                <?php
                echo "<td>
                    <a href='approve_reject.php?emp_id=".$emp_id."&start_date=".$start_date."' class='link-dark'><i class='fa-solid fa-circle-info'></i></a>
                </td>";

                ?>
			</tr>
			
            <?php
		}
		
	?>
        </table>
</body>
</html>
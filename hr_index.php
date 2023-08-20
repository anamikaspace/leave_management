<?php
require('header.php');

$doj_fetch = "SELECT * FROM employee";
	$result_dojs = mysqli_query($con, $doj_fetch);
	$DOJs = array();
	$credits = array();
	$count = 0;

	if ($result_dojs) {
		while ($row = mysqli_fetch_assoc($result_dojs)) {
			$DOJs[$count++] = $row["DOJ"];
		}
	}

	$end_month = 12;

	for ($i = 0; $i < count($DOJs); $i++) {
	    $key = array_keys($DOJs)[$i];
	    $value = $DOJs[$key];

		$join_date = date('m', strtotime($value));
		//extracts the month number from a date string and stores it in another variable.
		
		if ($join_date >= 06) {
			$credit = abs($end_month - $join_date) + 06;
		} else {
			$credit = (07 - $join_date);
		}

		$credits[$i] = $credit * (3);
	}
	$jsonArray = json_encode($credits);
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
	      /* Style the button */
	      .button {
	        background-color: #4CAF50;
	        color: white;
	        border: none;
	        padding: 10px;
	        text-align: center;
	        text-decoration: none;
	        display: inline-block;
	        font-size: 11px;
	        margin: 4px 2px;
	        cursor: pointer;
	      }

	      /* The overlay (background) */
	      .overlay {
	        position: fixed;
	        top: 0;
	        bottom: 0;
	        left: 0;
	        right: 0;
	        background-color: rgba(0, 0, 0, 0.5);
	        z-index: 999;
	        display: none;
	      }
	      .tableOverlay {
	        position: absolute;
	        top: 50%;
	        left: 50%;
	        transform: translate(-50%, -50%);
	        background-color: white;
	        padding: 20px;
	        border: 1px solid black;
	        z-index: 1000;
	      }

	      .headData {
	        border: 1px solid black;
	        padding: 15px;
	        text-align: center;
	      }
	  </style>
</head>

<body>
  <div class="overlay" id="overlay">
	      <div class="tableOverlay">
	        <table>
	          <thead>
	            <tr>
	              <th class="headData">Type of leave</th>
	              <th class="headData">Credits</th>
	            </tr>
	          </thead>
	          <tbody id="table-body">
	          </tbody>
	        </table>
	        <br>
	        <center><button class="button" onclick="hideOverlay()">Close</button></center>
	      </div>
	    </div>
        
        <script>
	      function showOverlay(x) {
	      	var credits = <?php echo $jsonArray; ?>;
	      	var creditTypes = ["Casual Leave", "Medical Leave", "Earned Leave"];
	      	var index = x;
	      	var tableBody = document.getElementById('table-body');
			
			for (let i = 0; i <= 2; i++) {
				var row = document.createElement('tr');
			    row.innerHTML = `
				    <td class="headData">${creditTypes[i]}</td>
				    <td class="headData">${(credits[x] / 3)}</td>
				`;
				tableBody.appendChild(row);
			}			
	        document.getElementById("overlay").style.display = "block";
		}

	      function hideOverlay() {
	        document.getElementById("overlay").style.display = "none";
	        document.getElementById('table-body').innerHTML = "";

	      }
	    </script>
  <nav class="navbar navbar-light justify-content-center fs-4 mb-4" style="background-color:khaki;">
      Employee Registration
  </nav>

<div class="container">
    <?php
    if(isset($_GET['msg'])){
        $msg=$_GET['msg'];
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        '.$msg.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>
    <a href="add_emp.php" class="btn btn-dark mb-3">Add New</a>

    <table class="table table-hover text-center" >
		    <thead class="table-dark">
		        <tr>
		            <th scope="col">Emp Id</th>
		            <th scope="col">First Name</th>
		            <th scope="col">Last Name</th>
		            <th scope="col">Email Id</th>
		            <th scope="col">Mobile No</th>
		            <th scope="col">Date Of Joining</th>
		            <th scope="col">Credits</th>
					<th scope="col">Action</th>
		        </tr>
		    </thead>
		    <tbody>
		        <?php
		            $sql= "Select * from employee where emp_id like 'EMP%'";;
		            $result = mysqli_query($con, $sql);
		            $index = 0;
		            while ($row = mysqli_fetch_assoc($result)){
		                ?>
		                     <tr>
		                        <td><?php echo $row['emp_id']?></td>
		                        <td><?php echo $row['first_name']?></td>
		                        <td><?php echo $row['last_name']?></td>
		                        <td><?php echo $row['email']?></td>
		                        <td><?php echo $row['phone']?></td>
		                        <td><?php echo $row['DOJ']?></td>
		                        <td><button class="button" onclick="showOverlay(<?php echo $index; ?>)">Display</button></td>
								<td>
                            		<a href="editemp.php?emp_id=<?php echo $row['emp_id']?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                            		<a href="delemp.php?emp_id=<?php echo $row['emp_id']?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
                        		</td>
		                    </tr>
		                <?php
		                $index++;
		            }
		        ?>
		    </tbody>
		</table>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
</body>
</html>
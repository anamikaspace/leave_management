<?php
    require('header.php');
    $emp_id=$_GET['emp_id'];
    $sql="DELETE FROM employee WHERE emp_id='$emp_id' ";
    $sql1="DELETE FROM `leave` WHERE emp_id='$emp_id' ";
    $sql2="DELETE FROM `transactions` WHERE emp_id='$emp_id' ";
    
    $result1= mysqli_query($con, $sql1);
    $result2= mysqli_query($con, $sql2);
    $result = mysqli_query($con, $sql);
    
    if($result){
        header("Location: hr_index.php?msg= Record deleted succesfully");
    }
    else{
        echo "Failed " . mysqli_error($con);
    } 
?>
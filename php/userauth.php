<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();
    if(isset($_POST['register'])){
        $fullnames = $_POST['fullnames'];
        $email =$_POST['email']; 
        $password = $_POST['password'];
        $country = $_POST['country'];
        $gender = $_POST['gender'];
        $sql=("insert into `students` (full_names,email,password,country,gender )values('$fullnames','$email','$password','$country','$gender')");
        $result=mysqli_query($conn,$sql);
        if(!$result){
            die('Could not enter your data: '.mysql_error());
            
         }
             else{
               die(mysqli_error($conn));
             }
        //$sql =  "SELECT email from  `students` where email  =  '$email'";
    if($sql){
       echo "<script> alert('the user registered successfully')</script>";
    }
    else{

        echo "<script> alert('the user exists')</script>";

            }
   //check if user with this email already exist in the database
}
}


//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
            $conn = db();
            $email =$_POST['email']; 
            $password = $_POST['password'];
            $sql = "SELECT email, password  from `students` where email = '$email' AND  password = '$password'";
            $result=mysqli_query($conn,$sql); 
            if($result){
                echo "login successfully";
                session_start();
                if(!isset($_SESSION["fullnames"])){
                 header("location: dashboard.php");
                    exit(); }

               //header(location:dashboard.php);

            }   
            else{
                //die(mysqli_error($conn));
            header("location:login.php");

            }       

   
        }


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    if(isset($_POST['reset']))
{
    $email =$_POST['email']; 
    $password = $_POST['password'];
    $sql= ("UPDATE `students` SET password = '$password', email = '$email'  WHERE email = '$email'");
    $result=mysqli_query($conn,$sql);
    if($result){
        echo "<script> alert('password reset successfully')</script>";

}
else{
    die(mysqli_error($con));
}
}
}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
     $conn = db();
     $sql="delete from `students` where id= $id";
     $result=mysqli_query($conn,$sql);
    if($result){
        echo "data deleted successfully";
        header("location:dashboard.php");
    }
    else{
         die(mysqli_error($con));

        } 
} 
     //delete user with the given id from the database
 

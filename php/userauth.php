<?php

require_once '../config.php';

//register users

function registerUser( $fullnames, $email, $password, $gender, $country ) {
    //create a connection variable using the db function in config.php
    $conn = db();
    if ( mysqli_num_rows( mysqli_query( $conn, 'SELECT * FROM students WHERE email = `email`' ) ) >= 1 ) {
        echo "<script> alert('the user of the email  already exists')</script>";

        header( 'refresh:0.5; url ../forms/register.php' );
    } else {
        $sql = ( "insert into `students` (full_names,email,password,country,gender )values('$fullnames','$email','$password','$country','$gender')" );
        $result = mysqli_query( $conn, $sql );
        if ( $result ) {
            echo "<script> alert('the user registered successfully')</script>";
            header( 'refresh:2; url =../forms/login.php' );
        } else {
            die( mysqli_error( $conn ) );
        }
    }
}

//login users

function loginUser( $email, $password ) {
    $conn = db();

    $sql = "SELECT * from `students` where email = '$email' AND  password = '$password'";
    $result = mysqli_query( $conn, $sql );

    if ( mysqli_num_rows( $result ) >= 1 ) {
        session_start();
        $_SESSION[ 'username' ] = $email;

        header( 'location: ../dashboard.php' );
    } else {
        header( 'Location: ../forms/login.php?message=invalid' );

    }

}

function resetPassword( $email, $password ) {
    //create a connection variable using the db function in config.php
    $conn = db();
    if ( mysqli_num_rows( mysqli_query( $conn, 'SELECT * FROM students WHERE email = `email`' ) ) >= 1 ) {

        $sql = "UPDATE  table `students` SET password = '$password'  WHERE email = '$email'" ;
        $result = mysqli_query( $conn, $sql );
        if ( $result ) {
            echo "<script> alert('password reset successfully')</script>";

        } else {
            echo "<script> alert('try again please')</script>";

        }

    }

    function getusers() {
        $conn = db();
        $sql = 'SELECT * FROM Students';
        $result = mysqli_query( $conn, $sql );
        echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
        if ( mysqli_num_rows( $result ) > 0 ) {
            while( $data = mysqli_fetch_assoc( $result ) ) {
                //show data
                echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data[ 'id' ] . "</td>
                <td style='width: 150px'>" . $data[ 'full_names' ] .
                "</td> <td style='width: 150px'>" . $data[ 'email' ] .
                "</td> <td style='width: 150px'>" . $data[ 'gender' ] .
                "</td> <td style='width: 150px'>" . $data[ 'country' ] .
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                'value=' . $data[ 'id' ] . '>'.
                // "<td style='width: 150px'>
                 "<button  class= 'btn btn-danger'type='submit', name='delete'> DELETE </button> </form>".
                '</tr>';
            }
            echo '</table></table></center></body></html>';
        }
       
    }

    function deleteaccount( $id ) {
        $conn = db();
        if ( mysqli_num_rows( mysqli_query( $conn, 'SELECT * FROM students WHERE id = `$id`' ) ) ) {
            $sql = "delete from `students` where id= $id";
            $result = mysqli_query( $conn, $sql );
            if ( $result ) {
                echo "<script> alert('data deleted successfully')</script>";
                header( 'refresh:0.5; url =action.php?all' );
            }

        }
    }

}
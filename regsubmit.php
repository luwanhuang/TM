<?php
session_start();

//if(isset($_SESSION['userID'])!=""){
//    header("Location: home.php");
//}

if(isset($_POST['regsubmit'])){
  $username = $_POST['email'];
  $password = $_POST['password'];
  $firstname = $_POST['firstName'];
  $lastname = $_POST['lastName'];
  $gender = $_POST['gender'];
  $address = $_POST['address'];
  $phone = $_POST['phoneNo'];
  $stuNo = $_POST['uqNo'];
  $licence = $_POST['licenceNo'];
  $licenceExp = $_POST['licenceExp'];
  $carmodel = $_POST['carModel'];
  $carregis = $_POST['carRegistration'];
  $carcolor = $_POST['carColour'];
  $seat = $_POST['capacity'];

  if(!preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $username)){
    echo "invalid email address";
	exit('Invalid Email<a href="javascript:history.back(-1);">back</a>');
    }

  if(strlen($password) < 6){
    echo "password length is less than 6 character";
	exit('Invalid password<a href="javascript:history.back(-1);">back</a>');
    }

  include 'connection.php';

  $check_query = mysql_query("SELECT userID FROM user WHERE email = '$username' limit 1");
  if(mysql_fetch_array($check_query)){
    echo $username, 'already exites<a href="javascript:history.back(-1);">back</a>';
    exit;
    }

  //check if driver or not
  if($carmodel=="" || $carregis=="" || $carcolor=="" || $seat==""){
    $isDriver = 0;
    $insert_sql = "INSERT INTO user(email, password, firstName, lastName, isDriver, address, phone, gender)VALUES('$username','$password','$firstname','$lastname', '$isDriver', '$address', '$phone', '$gender')";

    if(mysql_query($insert_sql, $conn)){
        header("Location: home_pass.php");
       }else {
         echo $insert_sql;
	     echo 'Sorry, sign up failed ',mysql_error(),'<br />';
	     echo '<a href="javascript:history.back(-1);">Try Again</a>';
      }
    }else{
    $isDriver = 1;
    $insert_sql = "INSERT INTO user(email, password, firstName, lastName, isDriver, address, phone, gender, driverLisence, expiredDate, carModel, carRegistration, carColour, seat)VALUES('$username','$password','$firstname','$lastname', '$isDriver', '$address', '$phone', '$gender', '$licence', '$licenceExp', '$carmodel', '$carregis', '$carcolor', '$seat')";

    if(mysql_query($insert_sql, $conn)){
        header("Location: home_driver.php");
    }else {
         echo $insert_sql;
	     echo 'Sorry, sign up failed ',mysql_error(),'<br />';
	     echo '<a href="javascript:history.back(-1);">Try Again</a>';
    }
  }
}else{
    exit('illegal access');
}

 //User image upload process
//  if($_FILES['userimage']['error'] > 0){
//     die('An error ocurred when uploading!!');
//  }
//
//  if(!getimagesize($_FILES['userimage']['tmp_name'])){
//     die('Please ensure you are uploading an image');
//  }
//
//  //check filetype
//  if($_FILES['userimage']['type'] != 'image/png'){
//     die('Unsupported filetype');
//  }
//
//  //check filesize
//  if($_FILES['userimage']['size'] > 500000){
//     die('File uploaded exceeds maximum upload size');
//  }
//  //check if the file exits
//  if($file_exists('upload/' . $_FILES['userimage']['name'])){
//     die('File with that name already exists');
//  }
//
//  // Upload file
//  if(!move_uploaded_file($_FILES['userimage']['tmp_name'], 'upload/' . $_FILES['userimage'][$username])){
//    die('Error uploading file - check destination is writeable.');
//  }

?>

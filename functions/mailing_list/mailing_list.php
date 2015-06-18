<?php
include ('../db_connect/db_connect.php');
global $mysqli;

$errors = array();  	// array to hold validation errors
$data	= array(); 	// array to pass back data


//validation
if (empty($_POST['name']))	{ $errors['name'] = 'Name is required.'; }
if (empty($_POST['email']))	{ $errors['email'] = 'Email is required.'; }
	
//return a response
if (!empty($errors)) {
	//go into error
	$data['success'] = false;
	$data['errors']  = $errors;
}
else {
	//else, it is successful
	$data['success'] = true;
	FuncAddEmailToDB();
}
		
function FuncReply($type, $message){ 
        $replying = array("error"=>"{$type}", "message"=>"$message");
        echo(json_encode($replying)); // json encode the responce
}
 
function FuncAddEmailToDB() { // adding the email address to the DB
    // add user's email to database
    //$name = mysqli_real_escape_string($_POST['name']);
    //$email = mysqli_real_escape_string($_POST['email']);
    global $mysqli;
    
    $mysqli->query("INSERT INTO Subscribers (Name, Email) VALUES ('".$_POST['name']."', '".$_POST['email']."')");
    
    //close mysqli
    $mysqli->close();
}

//return all data to an AJAX call
echo json_encode($data);
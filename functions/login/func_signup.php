<?php

/** intro
1. check details:
	:ok, proceed -> 2
	:not ok, proceed -> 3
	- if username is already registered in database
	- if password is less than 3 alphanumeric [optional]
2. 	
	:ok -> insert user into database
	:not ok -> report error [what error?] and kill process
	- "username" stored into database
	- "password" stored into database
	- "email" stored into database
3.	:not ok -> report error and kill process

Addtional functions to consider:
1. Send email to verify creation of account
**/
$project = "/nogollas/nogollas-f3";

//connect to db
include_once $_SERVER['DOCUMENT_ROOT']. $project . '/functions/db_connect/db_connect.php';

//date time
$time = time();
date_default_timezone_set('Asia/Singapore');
$date = date('m/d/Y h:i:s a',time());

//retrieve $_POST from login.php -> escape variables for added security
$usrname 	= $mysqli->real_escape_string($_POST['user']);
$password 	= $mysqli->real_escape_string($_POST['password']);
$email 		= $mysqli->real_escape_string($_POST['email']);
$gender		= $mysqli->real_escape_string($_POST['gender']);
$birthday	= $mysqli->real_escape_string($_POST['birthday']);
$role		= 'CUSTOMER';

//function main body
checkCustomer($mysqli,$usrname,$email);
insertRecord($mysqli,$usrname,$password,$email, $gender, $birthday, $role, $date);
createSession($mysqli,$usrname,$email);

//check if there is record of email
//YES: throw error
function checkCustomer($mysqli,$u,$e) {
	$query1 = "SELECT `UserName` FROM Customer WHERE Username='".$u."'";
	$query2 = "SELECT `Email` FROM Customer WHERE Email='".$e."'";
	
	$result1 = $mysqli->query($query1);
	$result2 = $mysqli->query($query2);
	
	if ($result1->num_rows > 0 && $result2->num_rows > 0)
	{
		header("Location: ../../login.php?error=bothExists");
		exit();
	}
	elseif ($result1->num_rows > 0)
	{
		header("Location: ../../login.php?error=userExists");
		exit();
	}
	elseif ($result2->num_rows > 0)
	{
		header("Location: ../../login.php?error=emailExists");
		exit();
	}
	$result1->close();
	$result2->close();
}

function insertRecord($mysqli,$u,$p,$e,$g, $b, $r, $d) {
	/* Prepared statement, stage 1: insert into db */
	$stmt = $mysqli->prepare("INSERT INTO Customer(`UserName`,`Password`,`Email`, `Gender`, `Birthday`, `Role`, `DateCreated`) 
							VALUES (?,?,?,?,?,?,?)") 
		or die ("SIGNUP::Prepare failed: (".$mysqli->errno.") ".$stmt->error);
	/* Prepared statement, stage 2: bind [and/or] execute */
	$stmt->bind_param('sssssss',$u,$p,$e,$g,$b, $r, $d);
	$stmt->execute() 
		or die ("SIGNUP::Execute failed: (".$stmt->errno.") ".$stmt->error);
	
	$stmt->close();
}

function createSession($mysqli,$u,$e) {
	
	//session start
	session_start();
	
	//store a session
	$query1 = "SELECT `CustomerID` FROM Customer WHERE Username='".$u."'";
	if ($result = $mysqli->query($query1))
	{
		while ($row = $result->fetch_assoc())
		{
			$_SESSION['CustomerID'] = $row['CustomerID'];
		}
	}
	header("Location: ../../registereduser.php");
	$result->close();
}

/* close connection */
$mysqli->close();
?>
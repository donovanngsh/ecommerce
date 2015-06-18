<?php
include_once 'psl-config.php';

function sec_session_start() { 
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session 
    session_regenerate_id();    // regenerated the session, delete the old one. 
}

function login($email,$password,$mysqli) {
	if ($stmt = $mysqli->prepare("SELECT id, username, password, salt FROM members
									WHERE email = ? LIMIT 1")) {
	$stmt->bind_param('s',$email);		//bind "$email" to parameter
	$stmt->execute();		//execute prepared query
	$stmt->store_result();
	
	//get variables from result
	$stmt->bind_result($user_id,$username,$db_password,$salt);
	$stmt->fetch();
	
	//hash the password with unique salt
	$password = hash('sha512',$password . $salt);
	if ($stmt->num_rows == 1) 
	{
		//if user exists, check if the account is locked
		//from too many login attempts
		
		if (checkbrute($user_id,$mysqli) == true) 
		{
			//account is locked
			//send email to user, account is locked
			//...
			return false
		}
		else 
		{
			if ($db_password == $password) 
			{
				//password is correct
				//get user-agent string of the user
				$user_browser = $_SERVER['HTTP_USER_AGENT'];
				//XSS protection as we might print this value
				$user_id = preg_replace("/[^0-9]+/", "", $user_id);
				$_SESSION['user_id'] = $user_id;
				//XSS protection as we might print this value
				$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
				$_SESSION['username'] = $username;
				$_SESSION['login_string'] = hash('sha512', $password . $user_browser);
				//login successful
				return true;
			}
			else 
			{
				//password is not correct
				//record this attempt in database
				$now = time();
				$mysqli->query("INSERT INTO login_attempts(user_id, time) 
								VALUES ('$user_id', '$now')");
				return false;
			}
		}
	}
	else 
	{
		//no user exists
		return false;
	}
	}
}


<?php 
//declare database connection 
include('./functions/db_connect/db_connect.php');
//declare variables
global $mysqli;

//set session
session_start();
if(!isset($_SESSION['CustomerID'])){
	header("Location: login.php?status=notLogged");
	exit();
}
?>

<?php

	Try {
		FuncUploadFile();
	}
	catch(Exception $error) {
	echo '<h4>'.$error->getMessage().'</h4>';
	}

function FuncUploadFile(){
	//declare variables
	global $mysqli;
	$date = 0; $session = 0; $getFileName = 0; $getFileSize = 0; $getFileType = 0; $getFileImgfp = 0; 
	$getFileSize= 0; $getMaxSize=0; $roundProductPrice = 0; $error =0;

//Check file is uploaded
if(is_uploaded_file($_FILES['Filename']['tmp_name']) && getimagesize($_FILES['Filename']['tmp_name']) != false){
		
	//Get Date Info
	date_default_timezone_set('Asia/Singapore');
	$date = date('Y/m/d');
	$getFileName = $_FILES['Filename']['name'];
	$getFileExt = pathinfo($_FILES['Filename']['name'], PATHINFO_EXTENSION);
	
	//IF Filename exist, throw error
	$checkFileNameExistQuery = $mysqli->query("SELECT ItemImageFileName From Item Where ItemImageFileName = '$getFileName'");
	//count array row
	$checkFileNameExistQueryNumRows = mysqli_num_rows($checkFileNameExistQuery);
	If ($checkFileNameExistQueryNumRows > 0){
		header("Location: main-managetrans.php?msg=14");	
		exit();
	}
	// if file extension is not valid, throw error
	if (($getFileExt == 'jpg') or ($getFileExt == 'JPG') OR ($getFileExt == 'gif') or ($getFileExt == 'GIF')){
	//do nothing
	}
	Else{
		header("Location: main-managetrans.php?msg=13"); //Image not supported	
		exit();
	}

	//Upload file Path Destination
	$setUploadedFilePath = "/nogollas-f3Latest/nogollas-f2/UploadedFiles/";
	$setUploadedFilePath = ($_SERVER['DOCUMENT_ROOT']. $setUploadedFilePath . $getFileName); 

	//Move file into specific uploaded picture folder
	move_uploaded_file($_FILES['Filename']['tmp_name'], $setUploadedFilePath);
	
	//Get File info
	$getFileSize = getimagesize($setUploadedFilePath);
    $getFileType = $size['mime'];
    $getFileImgfp = fopen($setUploadedFilePath, 'rb');
    $getFileSize = $size[3];
	$getMaxSize = 100000;
	
	//Check filesize whether it meets maxsize
	 if($getFileSize < $getMaxSize ) {
		$session = $_SESSION['CustomerID'];
		$time = time();
		date_default_timezone_set('Asia/Singapore');
		$date = date('m/d/Y h:i:s a',time());
		
	  // SQL query
		//Category 3 - Request Item
        $ItemCreateItemStmt = $mysqli->prepare("
		INSERT INTO Item( DateCreated, DateUpdated,ItemName, ItemSize, ItemRemarks, ItemImageFileName, 
		NogollasCategory, ItemStatus,ItemBuyer, LastUpdateBy) 
		VALUES ('$date', '$date','$_POST[ItemName]', '$_POST[ItemSize]', '$_POST[ItemRemarks]', '$getFileName',
		'ITEM FOR REQUEST', 1,'$session', '$session' )");
		
		//Execute Command
        $ItemCreateItemStmt->execute();
		
		header("Location: main-managetrans.php?msg=1"); //Item Published
		exit();
      }	 
	 else {
		header("Location: main-managetrans.php?msg=12");	//Image size exceeded. Please change to a smaller file size
		exit();
     }
	 //Release Memory
	 unset($_POST[ItemName], $_POST[ItemSize], $_POST[ItemRemarks] );
	 $date = 0; $session = 0; $getFileName = 0; $getFileSize = 0; $getFileType = 0; $getFileImgfp = 0; 
	 $getFileSize= 0; $getMaxSize=0; $roundProductPrice = 0; $error =0;
	 $ItemCreateSellStmt = 0;
    }
else {
    // if the file is not less than the maximum allowed, print an error
	header("Location: main-managetrans.php?msg=13");	//Image not supported
	exit();  
    }
}
	//close connection
	$mysqli->close();
?>

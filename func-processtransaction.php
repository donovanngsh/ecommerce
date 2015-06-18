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

<?php //Refer a Friend
	If($_POST['ReferAFriend']==NULL){	
		// means this selection is not selected. No action required.
	}
	Else {
		$session= $_SESSION['CustomerID'];
		$time = time();
		date_default_timezone_set('Asia/Singapore');
		$date = date('m/d/Y h:i:s a',time());
	
		foreach($_POST['ReferAFriend'] as $ReferFriendValue){
		$ItemEmailCreateItemStmt = $mysqli->prepare("INSERT INTO ItemEmail(DateCreated, ItemID, ReferAFriendEmail, SenderID, SendEmail)
		VALUES (?,?,?,?,?)
		");
		$ItemEmailCreateItemStmt->bind_param("ssssi",
		$date,
		$ReferFriendValue,
		$_POST[email],
		$session,
		1);
		$ItemEmailCreateItemStmt->execute();
		
		//include send-email func
		include('func-sendemail.php');		
		}
	}

//Item Status 
// 1- AVAILABLE
// 2- RESERVED
// 3- CLOSED DEAL
// 4- REMOVED

	//For Buyer: Cancel Transaction
	If($_POST['CancelTrans']==NULL){	
		// means this selection is not selected. No action required.
	}
	Else {
		$session= $_SESSION['CustomerID'];
		$time = time();
		date_default_timezone_set('Asia/Singapore');
		$date = date('m/d/Y h:i:s a',time());
	
		foreach($_POST['CancelTrans'] as $CancelTransValue){		
			$ItemCancelTransStmt = $mysqli->prepare("UPDATE ITEM SET ItemBuyer = ?, ItemStatus = ?, LastUpdateBy = ?, DateUpdated= ?  WHERE ItemId = ?");
			$ItemCancelTransStmt->bind_param("sisss",
			' ',
			1,
			$session,
			$date,
			$CancelTransValue);
			$ItemCancelTransStmt->execute();	
			header("Location: main-managetrans.php?msg=8");
			exit();	
		}
	}
	
	//For Seller: Remove Posting
	If($_POST['RemoveItemPost']==NULL){	
		// means this selection is not selected. No action required.
	}
	Else {
		$session= $_SESSION['CustomerID'];
		$time = time();
		date_default_timezone_set('Asia/Singapore');
		$date = date('m/d/Y h:i:s a',time());
		
		//updates item posting: remove
		foreach($_POST['RemoveItemPost'] as $RemoveItemPostValue){
			$ItemStatus = '4';
			$stmt = $mysqli->prepare("UPDATE Item SET ItemStatus=?, LastUpdateBy=?, DateUpdated=? WHERE ItemId =?");
			$stmt->bind_param('ssss',$ItemStatus,$session,$date,$RemoveItemPostValue);
			$stmt->execute();
			$stmt->close();
			header("Location: main-managetrans.php?msg=6");
			exit();
		}
	}
	
	If($_POST['MarkAsSold']==NULL){	
		// means this selection is not selected. No action required.
	}
	Else {
		$session= $_SESSION['CustomerID'];
		$time = time();
		date_default_timezone_set('Asia/Singapore');
		$date = date('m/d/Y h:i:s a',time());
	
		foreach($_POST['MarkAsSold'] as $MarkAsSoldValue){
			$ItemStatus = '3';		
			$stmt = $mysqli->prepare("UPDATE Item SET ItemStatus?, LastUpdateBy?, DateUpdated=?  WHERE ItemId=?");
			$stmt->bind_param('ssss',$ItemStatus,$session,$date,$MarkAsSoldValue);
			$stmt->execute();
			$stmt->close();
			header("Location: main-managetrans.php?msg=10");
			exit();
		}
	}
	
	If($_POST['ReleaseItem']==NULL){	
		// means this selection is not selected. No action required.
	}
	Else {
		$session= $_SESSION['CustomerID'];
		$time = time();
		date_default_timezone_set('Asia/Singapore');
		$date = date('m/d/Y h:i:s a',time());
	
		foreach($_POST['ReleaseItem'] as $ReleaseItemValue){
			$ItemStatus = '1';
			$ItemBuyer= ' ';
			$stmt = $mysqli->prepare("UPDATE Item SET ItemStatus=?, LastUpdateBy=?, DateUpdated=?  WHERE ItemId=?");
			$stmt->bind_param('ssss',$ItemStatus,$session,$date,$ReleaseItemValue);
			$stmt->execute();
			$stmt->close();
			header("Location: main-managetrans.php?msg=9");
			exit();
		}
	}
	
	//Rating of Seller
	If($_POST['RateItemSeller']==NULL){	
		// means this selection is not selected. No action required.
	}
	Else{
		$sliderBar1 =$_POST['sliderBar1'];
		$sliderBar2 =$_POST['sliderBar2'];
		$sliderBar3 =$_POST['sliderBar3'];
		$sliderBar4 =$_POST['sliderBar4'];
		
		$TotalSliderBar = $sliderBar1 + $sliderBar2 + $sliderBar3 + $sliderBar4;
		$AverageSliderBar = round($TotalSliderBar/4);
		
		foreach($_POST['RateItemSeller'] as $RateItemSellerValue){	
			//get existing customer rating
			$CustomerSellerQuery = $mysqli->query("SELECT Rating, ItemSeller
			FROM Item AS T1 INNER JOIN Customer AS T2 ON T1.ItemSeller = T2.CustomerID	
			Where T1.ItemId = $RateItemSellerValue ");

			//count array row
			$CustomerSellerQueryNumRows = mysqli_num_rows($CustomerSellerQuery);
				
			If ($CustomerSellerQueryNumRows > 0){	
				//Populate Items for Sale
				while($CustomerSellerQueryObj = $CustomerSellerQuery->fetch_object()) {
				//New rating
					If ($CustomerSellerQueryObj->Rating == 0) {
						$RateSellerStmt = $mysqli->prepare("UPDATE Customer SET Rating = ? WHERE CustomerId = ?");
						$RateSellerStmt->bind_param("is",
						$AverageSliderBar,
						$CustomerSellerQueryObj->ItemSeller);
						$RateSellerStmt->execute();
						
						$RateSeller2Stmt = $mysqli->prepare("UPDATE ITEM SET RateItem = ? WHERE ItemId = ?");
						$RateSeller2Stmt->bind_param("is",
						1,
						$RateItemSellerValue);
						$RateSeller2Stmt->execute();
						header("Location: main-managetrans.php?msg=4");
						exit();
					}
					
					Else {
						$CalculatedAverageSliderBar = round(($CustomerSellerQueryObj->Rating + $AverageSliderBar)/2);
						$RateSellerStmt = $mysqli->prepare("UPDATE Customer SET Rating = ? WHERE CustomerId = ?");
						$RateSellerStmt->bind_param("is",
						$CalculatedAverageSliderBar,
						$CustomerSellerQueryObj->ItemSeller);
						$RateSellerStmt->execute();
							
						$RateSeller2Stmt = $mysqli->prepare("UPDATE ITEM SET RateItem = ? WHERE ItemId = ?");
						$RateSeller2Stmt->bind_param("is",
						1,
						$RateItemSellerValue);
						$RateSeller2Stmt->execute();
						
						header("Location: main-managetrans.php?msg=4");
						exit();
					}
				}
			}	
		}
	}

	//Nogollas Picks
	If($_POST['NogollasPicks']==NULL){	
		// means this selection is not selected. No action required.
	}
	Else {
		$session= $_SESSION['CustomerID'];
		$time = time();
		date_default_timezone_set('Asia/Singapore');
		$date = date('m/d/Y h:i:s a',time());
	
		foreach($_POST['NogollasPicks'] as $NogollasPicksValue){		
			$ItemNogollasPicksStmt = $mysqli->query("UPDATE ITEM SET NogollasPicks = 1, LastUpdateBy ='$session', DateUpdated='$date'  WHERE ItemId = '$NogollasPicksValue'");			
			header("Location: main-managetrans.php?msg=7");
			exit();
		}
	}
	//Remove Nogollas Picks
	If($_POST['RemoveNogollasPicks']==NULL){	
		// means this selection is not selected. No action required.
	}
	Else {
		$session= $_SESSION['CustomerID'];
		$time = time();
		date_default_timezone_set('Asia/Singapore');
		$date = date('m/d/Y h:i:s a',time());
	
		foreach($_POST['RemoveNogollasPicks'] as $RemoveNogollasPicksValue){		
			$ItemRemoveNogollasPicksStmt = $mysqli->query("UPDATE ITEM SET NogollasPicks = 0, LastUpdateBy ='$session', DateUpdated='$date'  WHERE ItemId = '$RemoveNogollasPicksValue'");			
			header("Location: main-managetrans.php?msg=7");
			exit();
		}
	}
	
	//ITEM FOR REQUEST - NotifyME
	If($_POST['NotifyMe']==NULL){	
		// means this selection is not selected. No action required.
	}
	Else {
		$session= $_SESSION['CustomerID'];
		$time = time();
		date_default_timezone_set('Asia/Singapore');
		$date = date('m/d/Y h:i:s a',time());
	
		foreach($_POST['NotifyMe'] as $NotifyMeValue){		
			$ItemNotifyMeStmt = $mysqli->query("UPDATE ITEM SET ItemNotify= 1, ItemSeller = '$session', ItemStatus = 5, LastUpdateBy ='$session', DateUpdated='$date'  WHERE ItemId = '$NotifyMeValue'");			
			header("Location: main-managetrans.php?msg=2");
			exit();
		}
	}
		
	//Close database
	$mysqli->close();
?>
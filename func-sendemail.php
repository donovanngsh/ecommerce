<?php 
//declare database connection
include('./functions/db_connect/db_connect.php');
include ('./functions/db_connect/library.php');
include ('./functions/classes/class.phpmailer.php'); 
//declare variables
global $mysqli;

//set session
session_start();
if(!isset($_SESSION['CustomerID'])){
	header("Location: login.php?status=notLogged");
}
?>

<?php	//Retrieve all Requested Items
		$ItemEmailQuery = $mysqli->query("
		Select T1.ItemID, T1.ItemName, T1.NogollasCategory, T1.ItemStatus, T1.ItemPrice, T1.ItemBuyer, T1.ItemSeller, 
		T2.SendEmailID, T2.ReferAFriendEmail, T2.SendEmail, 
		T3.UserName As ItemBuyerUserName, T3.Email As ItemBuyerEmail, 
		T4.UserName As ItemSellerUserName, T4.Email As ItemSellerEmail, 
		T5.UserName As ReferSenderUserName, T5.Email As ReferSenderEmail 
		From Item As T1 INNER JOIN ItemEmail AS T2 ON T1.ItemID = T2.ItemID 
		Left JOIN Customer AS T3 ON T1.ItemBuyer = T3.CustomerID 
		Left JOIN Customer AS T4 ON T1.ItemSeller = T4.CustomerID 
		Left Join Customer As T5 on T2.SenderID = T5.CustomerID 
		Where SendEmail = 1 
		");
					
		//count array row
		$ItemEmailQueryNumRows = mysqli_num_rows($ItemEmailQuery);
					
		If ($ItemEmailQueryNumRows > 0){									 
		//Set Email Configurations (To CONFIGURE THIS base on the hosting server configuration)
		//	$mail	= new PHPMailer; // call the class 
		//	$mail->IsSMTP(); 
		//	$mail->Host = SMTP_HOST; //Hostname of the mail server
		//	$mail->Port = SMTP_PORT; //Port of the SMTP like to be 25, 80, 465 or 587
		//	$mail->SMTPAuth = true; //Whether to use SMTP authentication
		//	$mail->Username = SMTP_UNAME; //Username for SMTP authentication any valid email created in your domain
		//	$mail->Password = SMTP_PWORD; //Password for SMTP authentication
		//	$mail->SetFrom("Nogollas domain", "Nogollas System Generated"); //From address of the mail

			while($ItemEmailQueryObj = $ItemEmailQuery->fetch_object()) {	
				
				If (($ItemEmailQueryObj->ReferAFriendEmail == NULL) And ($ItemEmailQueryObj->ReferAFriendEmail==0)) {
					//(Item For Sale) Item Reservation - Buyer Send Email to Seller
					If (($ItemEmailQuery->NogollasCategory == 'ITEM FOR SALE')  AND ($ItemEmailQuery->ItemStatus == 2) AND ($ItemEmailQuery->ItemSeller <> $session )) {
			
						$session= $_SESSION['CustomerID'];
						$time = time();
						date_default_timezone_set('Asia/Singapore');
						$date = date('m/d/Y h:i:s a',time());
						
						$SendEmailID = $ItemEmailQueryObj->SendEmailID;
						$mail->Subject = " Notification: Someone has made a reservation on your item. Check it out"; //Subject of the mail	
						$mail->AddAddress($ItemEmailQueryObj->ReferAFriendEmail, ""); //Receiver email address  (To CONFIGURE THIS base on the hosting server configuration)
						
						$mail->MsgHTML =("	<p>Hi</p>
											<p> You have been notified that someone has made a reservation on your posted item. </p>
											<p> You are strongly encouraged to contact him/her as soon as possible to complete the deal. 
											Please contact: Buyer Name - $ItemEmailQueryObj->ItemBuyerUserName and Buyer Email - $ItemEmailQueryObj->ItemBuyerEmail. </p>
											<div class='ItemName'><h4>Item Name: $ItemEmailQueryObj->ItemName. Price: $ItemEmailQueryObj->ItemPrice</h6></div>  						
											<h4> Link for Item <a href ='http://localhost/nogollas-f3Latest/nogollas-f2/main-displaytransdetail.php?ItemId=$ItemEmailQueryObj->ItemID'>View Item</a></h6>
											<b><p>Nogollas</p></b></div>
											<div class='ItemEmail'><h6>Please do not reply to this email as we are not able to respond to this messge sent to this email address.
											For more information about the item, <a href ='http://www.nogollas.com'> Please visit Nogollas.com </a></h6>
											<h6>Nogollas shall not be held responsible for any liabilities arising in connection with any transaction between buyers and sellers in this website.</h6>
											'"); //Body of the email
						$send = $mail->Send(); //Send the mails
						
						if($send){
							//Update Sent Status
							$ItemEmailQueryStmt2 = $mysqli->prepare("UPDATE ItemEmail SET SendEmail = 2, LastUpdateBy ='$session', DateUpdated='$date'  WHERE SendEmailID = $SendEmailID");
							$ItemEmailQueryStmt2->execute();
							
						//Mail Sent Successfully. 
						}
						else{
							header("Location: main-managetrans.php?msg=16"); //Fail To Send Mail Sent Successfully
							exit();
						}
					}
				}
				Else{//For refer a friend Email					
					$session= $_SESSION['CustomerID'];
					$time = time();
					date_default_timezone_set('Asia/Singapore');
					$date = date('m/d/Y h:i:s a',time());
					
					$SendEmailID = $ItemEmailQueryObj->SendEmailID;
					$mail->Subject = " You have received a Nogollas Recommendation. Check it out"; //Subject of the mail	
					$mail->AddAddress($ItemEmailQueryObj->ReferAFriendEmail, ""); //Receiver email Address (To CONFIGURE THIS) (To CONFIGURE THIS base on the hosting server configuration)
					
					$mail->MsgHTML =("	<p>Hi</p>
										<p> I saw this ad  on nogollas.com and thought you might be interested. </p>
										<p> Below is the Item that i would like to recommend it to you			</p>
										<div class='ItemName'><h4>Item Name: $ItemEmailQueryObj->ItemName. Price: $ItemEmailQueryObj->ItemPrice</h6></div>  						
										<div class='ItemSender'><h4>Recommendation from: $ItemEmailQueryObj->ReferSenderUserName </h6></div>
										<h4> Link for Item <a href ='http://localhost/nogollas-f3Latest/nogollas-f2/main-displaytransdetail.php?ItemId=$ItemEmailQueryObj->ItemID'>View Item</a></h6>
										<b><p>Nogollas</p></b></div>
										<div class='ItemEmail'><h6>Please do not reply to this email as we are not able to respond to this messge sent to this email address.
										For more information about the item, <a href ='http://www.nogollas.com'> Please visit Nogollas.com </a></h6>
										<h6>Nogollas shall not be held responsible for any liabilities arising in connection with any transaction between buyers and sellers in this website.</h6>
										'"); //Body of the email
					$send = $mail->Send(); //Send the mails
				
					if($send){
						//Update Sent Status
						$ItemEmailQueryStmt2 = $mysqli->prepare("UPDATE ItemEmail SET SendEmail = 2, LastUpdateBy ='$session', DateUpdated='$date'  WHERE SendEmailID = $SendEmailID");
						$ItemEmailQueryStmt2->execute();
						
						header("Location: main-managetrans.php?msg=5"); //Mail Sent Successfully
						exit();
					}
					else{
						header("Location: main-managetrans.php?msg=16"); //Fail To Send Mail Sent Successfully
						exit();
					}	
				}		
			}
		}
?>

<?php
			//Close database
			$mysqli->close();		 
?>
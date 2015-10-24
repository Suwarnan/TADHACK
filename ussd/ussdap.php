<?php

ini_set('error_log', 'ussd-app-error.log');

require 'libs/MoUssdReceiver.php';
require 'libs/MtUssdSender.php';
//require 'log.php';
require 'class/operationsClass.php';
require 'db.php';


$production=false;

	if($production==false){
		$ussdserverurl ='http://localhost:7000/ussd/send';
	}
	else{
		$ussdserverurl= 'https://api.dialog.lk/ussd/send';
	}


$receiver 	= new UssdReceiver();
$sender 	= new UssdSender($ussdserverurl,'APP_000001','password');
$operations = new Operations();

$receiverSessionId = $receiver->getSessionId();
$content 			= 	$receiver->getMessage(); // get the message content
$address 			= 	$receiver->getAddress(); // get the sender's address
$requestId 			= 	$receiver->getRequestID(); // get the request ID
$applicationId 		= 	$receiver->getApplicationId(); // get application ID
$encoding 			=	$receiver->getEncoding(); // get the encoding value
$version 			= 	$receiver->getVersion(); // get the version
$sessionId 			= 	$receiver->getSessionId(); // get the session ID;
$ussdOperation 		= 	$receiver->getUssdOperation(); // get the ussd operation


$responseMsg = array(
    "main" =>  
    "	WELCOME 
EAGLE_SERVICE	
choose
1.Electrician
2.Plumber
3.Home_Assistant
4.Painter
5.Electronic_repairman
6.Carpenter

99.Exit",

"Home_Assistant" =>"choose Service
1.Cooker
2.Cleaner
3.Laundryman
4.Gardener
9.Back",

"Province"=>"choose Province
1.Central
2.Eastern
3.Northern
4.Southern
5.Western
6.North_Western 
7.North_Central
8.Uva
9.Sabaragamuwa",

"District1"=>"choose District
1.Kandy
2.Matale
3.Nuwara_Eliya",

"District2"=>"choose District
1.Ampara
2.Batticaloa
3.Trincomallee",

"District3"=>"choose District
1.Jaffna
2.Kilinochchi
3.Manner
4.Vavuniya
5.Mullativu",

"District4"=>"choose District
1.Galle
2.Hambanthota
3.Mathara",

"District5"=>"choose District
1.Colombo
2.Gampaha
3.Kaluthara",

"District6"=>"choose District
1.Kurunagala
2.Puttalam",

"District7"=>"choose District
1.Anuradhapura
2.Polonnaruwa",

"District8"=>"choose District
1.Badulla
2.Monaragala",

"District9"=>"choose District
1.Kegalle
2.Rathnapura"
);


if ($ussdOperation  == "mo-init") { 
   
	try {
		
		$sessionArrary=array( "sessionid"=>$sessionId,"tel"=>$address,"menu"=>"main","org_menu"=>"","province"=>"","name"=>"","district"=>"","area"=>"");

  		$operations->setSessions($sessionArrary);

		$sender->ussd($sessionId, $responseMsg["main"],$address );

	} catch (Exception $e) {
			$sender->ussd($sessionId, 'Sorry error occured try again',$address );
	}
	
}else {

	$flag=0;

  	$sessiondetails=  $operations->getSession($sessionId);
	//$cuch_menu=array("main", "Home_Assistant", "Province");
  	$cuch_menu=$sessiondetails['menu'];
  	$operations->session_id=$sessiondetails['sessionsid'];

		switch($cuch_menu ){
		
			case "main": 	// Following is the main menu
					switch ($receiver->getMessage()) {
						case "1":
							$operations->session_menu="Electrician";
							$operations->saveSesssion();
							$operations->session_org_manu="Electrician";							
							$operations->saveSesssion4();
							$sender->ussd($sessionId,$responseMsg["Province"],$address );
							break;
						case "2":
							$operations->session_menu="Plumber";
							$operations->saveSesssion();
							$operations->session_org_manu="Plumber";							
							$operations->saveSesssion4();
							$sender->ussd($sessionId,$responseMsg["Province"],$address );
							break;
						case "3":
							$operations->session_menu="Home_Assistant";
							$operations->saveSesssion();
							$sender->ussd($sessionId,$responseMsg["Home_Assistant"],$address );
							break;
						case "4":
							$operations->session_menu="Painter";
							$operations->saveSesssion();
							$operations->session_org_manu="Painter";							
							$operations->saveSesssion4();
							$sender->ussd($sessionId,$responseMsg["Province"],$address );
							break;
						case "5":
							$operations->session_menu="Electronic_repairman";
							$operations->saveSesssion();
							$operations->session_org_manu="Electronic_repairman";							
							$operations->saveSesssion4();
							$sender->ussd($sessionId,$responseMsg["Province"],$address );
							break;
						case "6":
							$operations->session_menu="Carpenter";
							$operations->saveSesssion();
							$operations->session_org_manu="Carpenter";							
							$operations->saveSesssion4();
							$sender->ussd($sessionId,$responseMsg["Province"],$address );
							break;
						case "99":
						$sender->ussd($sessionId,'Thank you for using our Service',$address ,'mt-fin');
						break;
						default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}
					break;
					
			case "Home_Assistant":
				switch ($receiver->getMessage()) {
					case "1":
						$operations->session_menu="Cooker";
						$operations->saveSesssion();
						$operations->session_org_manu="Cooker";							
						$operations->saveSesssion4();
						$sender->ussd($sessionId,$responseMsg["Province"],$address );
					break;
					case "2":
						$operations->session_menu="Cleaner";
						$operations->saveSesssion();
						$operations->session_org_manu="Cleaner";							
						$operations->saveSesssion4();
						$sender->ussd($sessionId,$responseMsg["Province"],$address );
					break;
					case "3":
						$operations->session_menu="Laundryman";
						$operations->saveSesssion();
						$operations->session_org_manu="Laundryman";							
						$operations->saveSesssion4();
						$sender->ussd($sessionId,$responseMsg["Province"],$address );
					break;
					case "4":
						$operations->session_menu="Gardener";
						$operations->saveSesssion();
						$operations->session_org_manu="Gardener";							
						$operations->saveSesssion4();
						$sender->ussd($sessionId,$responseMsg["Province"],$address );
					break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
					break;
					}
				break;
					
					
			case "Electrician":
				switch ($receiver->getMessage()) {
					case "1":
						$operations->session_menu="District1";
						$operations->saveSesssion();
						$operations->session_province="Central";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District1"],$address );
					break;
					case "2":
						$operations->session_menu="District2";
						$operations->saveSesssion();
						$operations->session_province="Eastern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District2"],$address );
					break;
					case "3":
						$operations->session_menu="District3";
						$operations->saveSesssion();
						$operations->session_province="Northern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District3"],$address );
					break;
					case "4":
						$operations->session_menu="District4";
						$operations->saveSesssion();
						$operations->session_province="Southern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District4"],$address );
					break;
					case "5":
						$operations->session_menu="District5";
						$operations->saveSesssion();
						$operations->session_province="Western";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District5"],$address );
					break;
					case "6":
						$operations->session_menu="District6";
						$operations->saveSesssion();
						$operations->session_province="North_Western";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District6"],$address );
					break;
					case "7":
						$operations->session_menu="District7";
						$operations->saveSesssion();
						$operations->session_province="North_Central";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District7"],$address );
					break;
					case "8":
						$operations->session_menu="District8";
						$operations->saveSesssion();
						$operations->session_province="Uva";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District8"],$address );
					break;
					case "9":
						$operations->session_menu="District9";
						$operations->saveSesssion();
						$operations->session_province="Sabaragamuwa";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District9"],$address );
					break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
					break;
					}
				break;
					
			case "Plumber":
				switch ($receiver->getMessage()) {
					case "1":
						$operations->session_menu="District1";
						$operations->saveSesssion();
						$operations->session_province="Central";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District1"],$address );
					break;
					case "2":
						$operations->session_menu="District2";
						$operations->saveSesssion();
						$operations->session_province="Eastern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District2"],$address );
					break;
					case "3":
						$operations->session_menu="District3";
						$operations->saveSesssion();
						$operations->session_province="Northern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District3"],$address );
					break;
					case "4":
						$operations->session_menu="District4";
						$operations->saveSesssion();
						$operations->session_province="Southern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District4"],$address );
					break;
					case "5":
						$operations->session_menu="District5";
						$operations->saveSesssion();
						$operations->session_province="Western";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District5"],$address );
					break;
					case "6":
						$operations->session_menu="District6";
						$operations->saveSesssion();
						$operations->session_province="North_Western";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District6"],$address );
					break;
					case "7":
						$operations->session_menu="District7";
						$operations->saveSesssion();
						$operations->session_province="North_Central";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District7"],$address );
					break;
					case "8":
						$operations->session_menu="District8";
						$operations->saveSesssion();
						$operations->session_province="Uva";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District8"],$address );
					break;
					case "9":
						$operations->session_menu="District9";
						$operations->saveSesssion();
						$operations->session_province="Sabaragamuwa";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District9"],$address );
					break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}
					break;
					
					case "Painter":
					switch ($receiver->getMessage()) {
					case "1":
						$operations->session_menu="District1";
						$operations->saveSesssion();
						$operations->session_province="Central";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District1"],$address );
					break;
					case "2":
						$operations->session_menu="District2";
						$operations->saveSesssion();
						$operations->session_province="Eastern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District2"],$address );
					break;
					case "3":
						$operations->session_menu="District3";
						$operations->saveSesssion();
						$operations->session_province="Northern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District3"],$address );
					break;
					case "4":
						$operations->session_menu="District4";
						$operations->saveSesssion();
						$operations->session_province="Southern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District4"],$address );
					break;
					case "5":
						$operations->session_menu="District5";
						$operations->saveSesssion();
						$operations->session_province="Western";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District5"],$address );
					break;
					case "6":
						$operations->session_menu="District6";
						$operations->saveSesssion();
						$operations->session_province="North_Western";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District6"],$address );
					break;
					case "7":
						$operations->session_menu="District7";
						$operations->saveSesssion();
						$operations->session_province="North_Central";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District7"],$address );
					break;
					case "8":
						$operations->session_menu="District8";
						$operations->saveSesssion();
						$operations->session_province="Uva";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District8"],$address );
					break;
					case "9":
						$operations->session_menu="District9";
						$operations->saveSesssion();
						$operations->session_province="Sabaragamuwa";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District9"],$address );
					break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}
				break;
					
					
			case "Electronic_repairman":
				switch ($receiver->getMessage()) {
					case "1":
						$operations->session_menu="District1";
						$operations->saveSesssion();
						$operations->session_province="Central";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District1"],$address );
					break;
					case "2":
						$operations->session_menu="District2";
						$operations->saveSesssion();
						$operations->session_province="Eastern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District2"],$address );
					break;
					case "3":
						$operations->session_menu="District3";
						$operations->saveSesssion();
						$operations->session_province="Northern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District3"],$address );
					break;
					case "4":
						$operations->session_menu="District4";
						$operations->saveSesssion();
						$operations->session_province="Southern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District4"],$address );
					break;
					case "5":
						$operations->session_menu="District5";
						$operations->saveSesssion();
						$operations->session_province="Western";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District5"],$address );
					break;
					case "6":
						$operations->session_menu="District6";
						$operations->saveSesssion();
						$operations->session_province="North_Western";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District6"],$address );
					break;
					case "7":
						$operations->session_menu="District7";
						$operations->saveSesssion();
						$operations->session_province="North_Central";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District7"],$address );
					break;
					case "8":
						$operations->session_menu="District8";
						$operations->saveSesssion();
						$operations->session_province="Uva";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District8"],$address );
					break;
					case "9":
						$operations->session_menu="District9";
						$operations->saveSesssion();
						$operations->session_province="Sabaragamuwa";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District9"],$address );
					break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}
				break;
					
					case "Carpenter":
				switch ($receiver->getMessage()) {
					case "1":
						$operations->session_menu="District1";
						$operations->saveSesssion();
						$operations->session_province="Central";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District1"],$address );
					break;
					case "2":
						$operations->session_menu="District2";
						$operations->saveSesssion();
						$operations->session_province="Eastern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District2"],$address );
					break;
					case "3":
						$operations->session_menu="District3";
						$operations->saveSesssion();
						$operations->session_province="Northern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District3"],$address );
					break;
					case "4":
						$operations->session_menu="District4";
						$operations->saveSesssion();
						$operations->session_province="Southern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District4"],$address );
					break;
					case "5":
						$operations->session_menu="District5";
						$operations->saveSesssion();
						$operations->session_province="Western";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District5"],$address );
					break;
					case "6":
						$operations->session_menu="District6";
						$operations->saveSesssion();
						$operations->session_province="North_Western";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District6"],$address );
					break;
					case "7":
						$operations->session_menu="District7";
						$operations->saveSesssion();
						$operations->session_province="North_Central";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District7"],$address );
					break;
					case "8":
						$operations->session_menu="District8";
						$operations->saveSesssion();
						$operations->session_province="Uva";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District8"],$address );
					break;
					case "9":
						$operations->session_menu="District9";
						$operations->saveSesssion();
						$operations->session_province="Sabaragamuwa";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District9"],$address );
					break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}
					break;
					
					
			case "Cooker":
				switch ($receiver->getMessage()) {
					case "1":
						$operations->session_menu="District1";
						$operations->saveSesssion();
						$operations->session_province="Central";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District1"],$address );
					break;
					case "2":
						$operations->session_menu="District2";
						$operations->saveSesssion();
						$operations->session_province="Eastern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District2"],$address );
					break;
					case "3":
						$operations->session_menu="District3";
						$operations->saveSesssion();
						$operations->session_province="Northern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District3"],$address );
					break;
					case "4":
						$operations->session_menu="District4";
						$operations->saveSesssion();
						$operations->session_province="Southern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District4"],$address );
					break;
					case "5":
						$operations->session_menu="District5";
						$operations->saveSesssion();
						$operations->session_province="Western";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District5"],$address );
					break;
					case "6":
						$operations->session_menu="District6";
						$operations->saveSesssion();
						$operations->session_province="North_Western";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District6"],$address );
					break;
					case "7":
						$operations->session_menu="District7";
						$operations->saveSesssion();
						$operations->session_province="North_Central";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District7"],$address );
					break;
					case "8":
						$operations->session_menu="District8";
						$operations->saveSesssion();
						$operations->session_province="Uva";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District8"],$address );
					break;
					case "9":
						$operations->session_menu="District9";
						$operations->saveSesssion();
						$operations->session_province="Sabaragamuwa";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District9"],$address );
					break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}
					break;
					
			case "Cleaner":
				switch ($receiver->getMessage()) {
					case "1":
						$operations->session_menu="District1";
						$operations->saveSesssion();
						$operations->session_province="Central";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District1"],$address );
					break;
					case "2":
						$operations->session_menu="District2";
						$operations->saveSesssion();
						$operations->session_province="Eastern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District2"],$address );
					break;
					case "3":
						$operations->session_menu="District3";
						$operations->saveSesssion();
						$operations->session_province="Northern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District3"],$address );
					break;
					case "4":
						$operations->session_menu="District4";
						$operations->saveSesssion();
						$operations->session_province="Southern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District4"],$address );
					break;
					case "5":
						$operations->session_menu="District5";
						$operations->saveSesssion();
						$operations->session_province="Western";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District5"],$address );
					break;
					case "6":
						$operations->session_menu="District6";
						$operations->saveSesssion();
						$operations->session_province="North_Western";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District6"],$address );
					break;
					case "7":
						$operations->session_menu="District7";
						$operations->saveSesssion();
						$operations->session_province="North_Central";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District7"],$address );
					break;
					case "8":
						$operations->session_menu="District8";
						$operations->saveSesssion();
						$operations->session_province="Uva";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District8"],$address );
					break;
					case "9":
						$operations->session_menu="District9";
						$operations->saveSesssion();
						$operations->session_province="Sabaragamuwa";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District9"],$address );
					break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}
				break;
					
			case "Laundryman":
				switch ($receiver->getMessage()) {
					case "1":
						$operations->session_menu="District1";
						$operations->saveSesssion();
						$operations->session_province="Central";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District1"],$address );
					break;
					case "2":
						$operations->session_menu="District2";
						$operations->saveSesssion();
						$operations->session_province="Eastern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District2"],$address );
					break;
					case "3":
						$operations->session_menu="District3";
						$operations->saveSesssion();
						$operations->session_province="Northern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District3"],$address );
					break;
					case "4":
						$operations->session_menu="District4";
						$operations->saveSesssion();
						$operations->session_province="Southern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District4"],$address );
					break;
					case "5":
						$operations->session_menu="District5";
						$operations->saveSesssion();
						$operations->session_province="Western";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District5"],$address );
					break;
					case "6":
						$operations->session_menu="District6";
						$operations->saveSesssion();
						$operations->session_province="North_Western";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District6"],$address );
					break;
					case "7":
						$operations->session_menu="District7";
						$operations->saveSesssion();
						$operations->session_province="North_Central";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District7"],$address );
					break;
					case "8":
						$operations->session_menu="District8";
						$operations->saveSesssion();
						$operations->session_province="Uva";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District8"],$address );
					break;
					case "9":
						$operations->session_menu="District9";
						$operations->saveSesssion();
						$operations->session_province="Sabaragamuwa";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District9"],$address );
					break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}
					break;
					
			case "Gardener":
				switch ($receiver->getMessage()) {
					case "1":
						$operations->session_menu="District1";
						$operations->saveSesssion();
						$operations->session_province="Central";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District1"],$address );
					break;
					case "2":
						$operations->session_menu="District2";
						$operations->saveSesssion();
						$operations->session_province="Eastern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District2"],$address );
					break;
					case "3":
						$operations->session_menu="District3";
						$operations->saveSesssion();
						$operations->session_province="Northern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District3"],$address );
					break;
					case "4":
						$operations->session_menu="District4";
						$operations->saveSesssion();
						$operations->session_province="Southern";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District4"],$address );
					break;
					case "5":
						$operations->session_menu="District5";
						$operations->saveSesssion();
						$operations->session_province="Western";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District5"],$address );
					break;
					case "6":
						$operations->session_menu="District6";
						$operations->saveSesssion();
						$operations->session_province="North_Western";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District6"],$address );
					break;
					case "7":
						$operations->session_menu="District7";
						$operations->saveSesssion();
						$operations->session_province="North_Central";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District7"],$address );
					break;
					case "8":
						$operations->session_menu="District8";
						$operations->saveSesssion();
						$operations->session_province="Uva";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District8"],$address );
					break;
					case "9":
						$operations->session_menu="District9";
						$operations->saveSesssion();
						$operations->session_province="Sabaragamuwa";
						$operations->saveSesssion3();
						$sender->ussd($sessionId,$responseMsg["District9"],$address );
					break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}
				break;
					
					
			case "District1":
				switch ($receiver->getMessage()) {
					case "1":
							$operations->session_menu="Kandy";
							$operations->saveSesssion();
							$operations->session_district="Kandy";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					case "2":
							$operations->session_menu="Matale";
							$operations->saveSesssion();
							$operations->session_district="Matale";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					case "3":
							$operations->session_menu="Nuwara_Eliya";
							$operations->saveSesssion();
							$operations->session_district="Nuwara_Eliya";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}		
					break;
					
					case "District2":
					switch ($receiver->getMessage()) {
					case "1":
							$operations->session_menu="Ampara";
							$operations->saveSesssion();
							$operations->session_district="Ampara";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					case "2":
							$operations->session_menu="Batticaloa";
							$operations->saveSesssion();
							$operations->session_district="Batticaloa";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					case "3":
							$operations->session_menu="Trincomallee";
							$operations->saveSesssion();
							$operations->session_district="Trincomallee";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}		
				break;
					
			case "District3":
				switch ($receiver->getMessage()) {
					case "1":
							$operations->session_menu="Jaffna";
							$operations->saveSesssion();
							$operations->session_district="Jaffna";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					case "2":
							$operations->session_menu="Kilinochchi";
							$operations->saveSesssion();
							$operations->session_district="Kilinochchi";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					case "3":
							$operations->session_menu="Manner";
							$operations->saveSesssion();
							$operations->session_district="Manner";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					case "4":
							$operations->session_menu="Vavuniya";
							$operations->saveSesssion();
							$operations->session_district="Vavuniya";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					case "5":
							$operations->session_menu="Mullativu";
							$operations->saveSesssion();
							$operations->session_district="Mullativu";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion1();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}		
				break;
					
			case "District4":
				switch ($receiver->getMessage()) {
					case "1":
							$operations->session_menu="Galle";
							$operations->saveSesssion();
							$operations->session_district="Galle";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					case "2":
							$operations->session_menu="Hambanthota";
							$operations->saveSesssion();
							$operations->session_district="Hambanthota";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					case "3":
							$operations->session_menu="Mathara";
							$operations->saveSesssion();
							$operations->session_district="Mathara";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}		
				break;
					
			case "District5":
				switch ($receiver->getMessage()) {
					case "1":
							$operations->session_menu="Colombo";
							$operations->saveSesssion();
							$operations->session_district="Colombo";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					case "2":
							$operations->session_menu="Gampaha";
							$operations->saveSesssion();
							$operations->session_district="Gampaha";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					case "3":
							$operations->session_menu="Kaluthara";
							$operations->saveSesssion();
							$operations->session_district="Kaluthara";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}		
				break;
					
			case "District6":
				switch ($receiver->getMessage()) {
					case "1":
							$operations->session_menu="Kurunagala";
							$operations->saveSesssion();
							$operations->session_district="Kurunagala";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					case "2":
							$operations->session_menu="Puttalam";
							$operations->saveSesssion();
							$operations->session_district="Puttalam";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}		
					break;
					
					case "District7":
					switch ($receiver->getMessage()) {
					case "1":
							$operations->session_menu="Anuradhapura";
							$operations->saveSesssion();
							$operations->session_district="Anuradhapura";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					case "2":
							$operations->session_menu="Polonnaruwa";
							$operations->saveSesssion();
							$operations->session_district="Polonnaruwa";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}		
				break;
					
			case "District8":
				switch ($receiver->getMessage()) {
					case "1":
							$operations->session_menu="Badulla";
							$operations->saveSesssion();
							$operations->session_district="Kandy";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					case "2":
							$operations->session_menu="Monaragala";
							$operations->saveSesssion();
							$operations->session_district="Monaragala";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}		
				break;
					
			case "District9":
				switch ($receiver->getMessage()) {
					case "1":
							$operations->session_menu="Kegalle";
							$operations->saveSesssion();
							$operations->session_district="Kandy";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					case "2":
							$operations->session_menu="Rathnapura";
							$operations->saveSesssion();
							$operations->session_district="Rathnapura";							
							$operations->saveSesssion1();
							$sender->ussd($sessionId,'Enter Your Area',$address );
							break;
					default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}		
				break;
									
			case "Kandy":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="1";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);			
			break;
			case "Matale":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="2";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Nuwara_Eliya":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="3";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Ampara":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="4";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Batticaloa":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="5";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Trincomallee":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="6";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Jaffna":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="7";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Kilinochchi":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="8";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Manner":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="9";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Vavuniya":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="10";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Mullativu":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="11";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Galle":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="12";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Hambanthota":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="13";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Mathara":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="14";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Colombo":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="15";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Gampaha":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="16";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Kaluthara":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="17";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Kurunagala":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="18";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Puttalam":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="19";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Anuradhapura":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="20";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Polonnaruwa":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="21";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Badulla":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="22";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Monaragala":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="23";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Kegalle":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="24";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			case "Rathnapura":
				$operations->session_area=$receiver->getMessage();
				$operations->saveSesssion5();
				$operations->session_menu="25";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Enter your Name',$address);
			break;
			
			
			case "1":
				$sender->ussd($sessionId,'hai '.$receiver->getMessage().' Your are registered. Thank you to use our service' ,$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "2":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "3":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "4":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "5":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "6":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "7":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "8":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "9":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "10":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "11":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "12":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "13":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "14":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "15":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "16":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "17":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "18":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "19":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "20":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "21":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "22":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "23":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "24":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			case "25":
				$sender->ussd($sessionId,'You registered to our Service. Please wait for customer call. Your Name:'.$receiver->getMessage(),$address ,'mt-fin');
				$operations->session_name=$receiver->getMessage();
				$operations->saveSesssion2();
			break;
			default:
				$operations->session_menu="main";
				$operations->saveSesssion();
				$sender->ussd($sessionId,'Incorrect option',$address );
				break;
				
			}			
		}
		
		
		
		
		
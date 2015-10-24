<?php

class Operations
{
	
	public $session_id='';
	public $session_menu='';
	public $session_org_manu='';
	public $session_province='';
	public $session_tel='';
	public $session_name='';
	public $session_district='';
	public $session_area='';
	

	public function setSessions($sessions){

		$sql_sessions="INSERT INTO `sessions` (`sessionsid`, `tel`, `menu`,`org_manu`, `province`, `created_at`,`name`,`district`,`area`) VALUES 
			('".$sessions['sessionid']."', '".$sessions['tel']."', '".$sessions['menu']."', '".$sessions['org_manu']."','".$sessions['province']."', 'CURRENT_TIMESTAMP','".$sessions['name']."','".$sessions['district']."','".$sessions['area']."')";

		$quy_sessions=mysql_query($sql_sessions);
	}

	public function getSession($sessionid){	

		$sql_session="SELECT *  FROM  `sessions` WHERE  sessionsid='". $sessionid."'";
		$quy_sessions=mysql_query($sql_session);
		$fet_sessions=mysql_fetch_array($quy_sessions);
		$this->session_name=$fet_sessions['name'];
		return $fet_sessions;	
	}


	public function saveSesssion()
	{
		$sql_session="UPDATE  `sessions` SET 
									`menu`='".$this->session_menu."'						
									WHERE `sessionsid` =  '".$this->session_id."'";
		$quy_sessions=mysql_query($sql_session);
	}
	
	
	public function saveSesssion1()
	{
		$sql_session1="UPDATE  `sessions` SET 
									`district`='".$this->session_district."'
									WHERE `sessionsid` =  '".$this->session_id."'";
		$quy_sessions=mysql_query($sql_session1);
	}
	
	public function saveSesssion2()
	{
		$sql_session2="UPDATE  `sessions` SET 
									`name`='".$this->session_name."'
									WHERE `sessionsid` =  '".$this->session_id."'";
		$quy_sessions=mysql_query($sql_session2);
	}
	public function saveSesssion3()
	{
		$sql_session3="UPDATE  `sessions` SET 
									`province`='".$this->session_province."'
									WHERE `sessionsid` =  '".$this->session_id."'";
		$quy_sessions=mysql_query($sql_session3);
	}
	
	public function saveSesssion4()
	{
		$sql_session4="UPDATE  `sessions` SET 
									`org_manu`='".$this->session_org_manu."'
									WHERE `sessionsid` =  '".$this->session_id."'";
		$quy_sessions=mysql_query($sql_session4);
	}
	
	public function saveSesssion5()
	{
		$sql_session5="UPDATE  `sessions` SET 
									`area`='".$this->session_area."'
									WHERE `sessionsid` =  '".$this->session_id."'";
		$quy_sessions=mysql_query($sql_session5);
	}
	
}

?>
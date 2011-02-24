<?php
class Users extends MySQLDB
{

// Get single user full name
	function getUserFullname($id){
		$q = "SELECT id, firstname, lastname FROM ".CO_TBL_USERS." where id = '$id'";
		$result_user = mysql_query($q, $this->connection);
		$row_user = mysql_fetch_assoc($result_user);
		$user = $row_user["lastname"] . ' ' . $row_user["firstname"];
		return $user;
	}

}

$users = new Users();
?>
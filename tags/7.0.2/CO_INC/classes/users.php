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
	
	function getAvatar($id){
		$q = "SELECT avatar FROM ".CO_CONTACTS_TBL_AVATARS." where uid = '$id' and bin = '0'";
		$result = mysql_query($q, $this->connection);
		$row = mysql_fetch_assoc($result);
		$avatar = $row["avatar"];
		if($avatar == "") {
			$avatar = CO_FILES . "/img/avatar.jpg";
		} else {
			$avatar = CO_PATH_URL . "/data/avatars/" .$avatar;
		}
		return $avatar;
	}

}

$users = new Users();
?>
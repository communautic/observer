<?php
include("database.php");
include(CO_INC . "/classes/users.php");
include(CO_INC . "/classes/system.php");
include(CO_INC . "/classes/form.php");
include(CO_INC . "/classes/date.php");
include(CO_INC . "/classes/class.phpmailer-lite.php");

class Session
{
   var $username;     //Username given on sign-up
   var $userid;       //Random value generated on current login
   var $userlevel;    //The level to which the user pertains
   var $uid;
   var $cid;
   var $uidid;
   var $userlang;
   var $firstname;
   var $lastname;
   var $timezone;      	//users timezone
   var $time;         //Time user was last active (page loaded)
   var $logged_in;    //True if user is logged in, false otherwise
   var $userinfo = array();  //The array holding all user info
   var $url;          //The page url current being viewed
   var $referrer;     //Last recorded site page viewed
    var $pwd_pick;     //Last recorded site page viewed
   //var $canView = array();
   //var $canEdit = array();
   //var $canAccess = array();
   /**
    * Note: referrer should really only be considered the actual
    * page referrer in process.php, any other time it may be
    * inaccurate.
    */

   /* Class constructor */
   function Session(){
      $this->time = time();
      $this->startSession();
   }

   /**
    * startSession - Performs all the actions necessary to 
    * initialize this session object. Tries to determine if the
    * the user has logged in already, and sets the variables 
    * accordingly. Also takes advantage of this page load to
    * update the active visitors tables.
    */
   function startSession(){
      global $database;  //The database connection
      session_start();   //Tell PHP to start the session

      /* Determine if user is logged in */
      $this->logged_in = $this->checkLogin();

      /**
       * Set guest value to users not logged in, and update
       * active guests table accordingly.
       */
      if(!$this->logged_in){
         $this->username = $_SESSION['username'] = GUEST_NAME;
         $this->userlevel = GUEST_LEVEL;
		 $this->userlang = CO_DEFAULT_LANGUAGE;
		 $this->timezone = "Europe/Vienna";
         //$database->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);
      }
      /* Update users last active timestamp */
      else{
         $database->addActiveUser($this->uid, $this->username, $this->time);
      }
      
      /* Remove inactive visitors from database */
      //$database->removeInactiveUsers();
      //$database->removeInactiveGuests();
      
      /* Set referrer page */
      if(isset($_SESSION['url'])){
         $this->referrer = $_SESSION['url'];
      }else{
         $this->referrer = "/";
      }

      /* Set current url */
      $this->url = $_SESSION['url'] = $_SERVER['PHP_SELF'];
   }

   /**
    * checkLogin - Checks if the user has already previously
    * logged in, and a session with the user has already been
    * established. Also checks to see if user has been remembered.
    * If so, the database is queried to make sure of the user's 
    * authenticity. Returns true if the user has logged in.
    */
   function checkLogin(){
      global $database;  //The database connection
      /* Check if user has been remembered */
      if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])){
		 $this->username = $_SESSION['username'] = $_COOKIE['cookname'];
         $this->userid   = $_SESSION['userid']   = $_COOKIE['cookid'];
      }

      /* Username and userid have been set and not guest */
      if(isset($_SESSION['username']) && isset($_SESSION['userid']) && $_SESSION['username'] != GUEST_NAME){
         /* Confirm that username and userid are valid */
         if($database->confirmUserID($_SESSION['username'], $_SESSION['userid']) != 0){
            unset($_SESSION['username']);
            unset($_SESSION['userid']);
			if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])){
				setcookie("cookname", "", time()-COOKIE_EXPIRE, COOKIE_PATH);
				setcookie("cookid",   "", time()-COOKIE_EXPIRE, COOKIE_PATH);
      		}
            return false;
         }

         /* User is logged in, set class variables */
		 
		 $this->userinfoorders  = $database->getUserInfoOrders($_SESSION['username']);
         $this->username  = $this->userinfoorders['username'];
         $this->userid    = $this->userinfoorders['userid'];
		 $this->uid    = $this->userinfoorders['uid'];
		 $this->cid    = $this->userinfoorders['cid'];
		 $this->uidid    = $this->userinfoorders['id'];
		 $this->pwd_pick = $this->userinfoorders['pwd_pick'];
		 
         $this->userinfo  = $database->getUserInfo($this->uid);
        // $this->username  = $this->userinfo['username'];
        // $this->userid    = $this->userinfo['userid'];
         $this->userlevel = $this->userinfo['userlevel'];
		 $this->firstname = $this->userinfo['firstname'];
		 $this->lastname = $this->userinfo['lastname'];
		 $this->email = $this->userinfo['email'];
		 //$this->uid = $this->userinfo['id'];
		 $this->userlang = $this->userinfo['lang'];
		 $this->useroffset = $this->userinfo['offset'];
		 $this->timezone = $this->userinfo['timezone'];
		 //$this->pwd_pick = $this->userinfo['pwd_pick'];
		 
		 
		
		 
		 
		 //$this->canView = "";
		 /*if (!$this->isSysadmin()) {
			 $this->canView = $database->getViewPerms($this->uid);
			 $this->canEdit = $database->getEditPerms($this->uid);
			 $this->canAccess = array_merge($this->canView,$this->canEdit);
		 }*/
		 
         return true;
      }
      /* User not logged in */
      else{
         return false;
      }
   }

   /**
    * login - The user has submitted his username and password
    * through the login form, this function checks the authenticity
    * of that information in the database and creates the session.
    * Effectively logging in the user if all goes well.
    */
   function login($subuser, $subpass, $subremember){
      global $database, $form;  //The database and form object

      /* Username error checking */
      $field = "user";  //Use field name for username
      if(!$subuser || strlen($subuser = trim($subuser)) == 0){
         $form->setError($field, "* Username not entered");
      }
      else{
         /* Check if username is not alphanumeric */
         if(!eregi("^([0-9a-z])*$", $subuser)){
            $form->setError($field, "* Username not alphanumeric");
         }
      }

      /* Password error checking */
      $field = "pass";  //Use field name for password
      if(!$subpass){
         $form->setError($field, "* Password not entered");
      }
      
      /* Return if form errors exist */
      if($form->num_errors > 0){
         return false;
      }

      /* Checks that username is in database and password is correct */
      $subuser = stripslashes($subuser);
      $result = $database->confirmUserPass($subuser, md5($subpass));

      /* Check error codes */
      if($result == 1){
         $field = "user";
         $form->setError($field, "* Username not found");
      }
      else if($result == 2){
         $field = "pass";
         $form->setError($field, "* Invalid password");
      }
      
      /* Return if form errors exist */
      if($form->num_errors > 0){
         return false;
      }
	
	  $this->userinfoorders  = $database->getUserInfoOrders($subuser);
      $this->username  = $_SESSION['username'] = $this->userinfoorders['username'];
	  $this->uid  = $this->userinfoorders['uid'];
	  $this->cid  = $this->userinfoorders['cid'];
	  $this->uidid  = $this->userinfoorders['id'];
	  
      /* Username and password correct, register session variables */
      $this->userinfo  = $database->getUserInfo($this->uid);
      //$this->username  = $_SESSION['username'] = $this->userinfo['username'];
      $this->userid    = $_SESSION['userid']   = $this->generateRandID();
      $this->userlevel = $this->userinfo['userlevel'];
	  //$this->uid = $this->userinfo['id'];
	  
	  
      
      /* Insert userid into database and update active users table */
      $database->updateUserField($this->username, "userid", $this->userid);
      $database->addActiveUser($this->uid, $this->username, $this->time);
      //$database->removeActiveGuest($_SERVER['REMOTE_ADDR']);

      /**
       * This is the cool part: the user has requested that we remember that
       * he's logged in, so we set two cookies. One to hold his username,
       * and one to hold his random value userid. It expires by the time
       * specified in constants.php. Now, next time he comes to our site, we will
       * log him in automatically, but only if he didn't log out before he left.
       */
      if($subremember){
         setcookie("cookname", $this->username, time()+COOKIE_EXPIRE, COOKIE_PATH);
         setcookie("cookid",   $this->userid,   time()+COOKIE_EXPIRE, COOKIE_PATH);
      }

      /* Login completed successfully */
      return true;
   }
   
	
	function changeLogin($username, $password){
		global $database;  //The database and form object 
		$database->updateUser($this->uidid, "username", $username);
		$database->updateUser($this->uidid, "password", md5($password));
		$database->updateUser($this->uidid, "pwd_pick", '1');
		return $this->uidid;
	}
	
	
   /**
    * logout - Gets called when the user wants to be logged out of the
    * website. It deletes any cookies that were stored on the users
    * computer as a result of him wanting to be remembered, and also
    * unsets session variables and demotes his user level to guest.
    */
   function logout(){
      global $database;  //The database connection
      /**
       * Delete cookies - the time must be in the past,
       * so just negate what you added when creating the
       * cookie.
       */
      if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])){
         setcookie("cookname", "", time()-COOKIE_EXPIRE, COOKIE_PATH);
         setcookie("cookid",   "", time()-COOKIE_EXPIRE, COOKIE_PATH);
      }

      /* Unset PHP session variables */
      unset($_SESSION['username']);
      unset($_SESSION['userid']);

      /* Reflect fact that user has logged out */
      $this->logged_in = false;
      
      /**
       * Remove from active users table and add to
       * active guests tables.
       */
     // $database->removeActiveUser($this->username);
     // $database->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);
      
      /* Set user level to guest */
      $this->username  = GUEST_NAME;
      $this->userlevel = GUEST_LEVEL;
   }
   
   function checkUsername($username) {
	   global $database;
	   return $database->usernameTaken($username);
   }
   
      function isSysadmin(){
      return ($this->userlevel == SYSADMIN_LEVEL ||
              $this->username  == SYSADMIN_NAME);
   }

   
   function getAccess($pid) {
		$access = "";
		if(in_array($pid,$this->canView)) {
			$access = "guest";
		}
		if(in_array($pid,$this->canEdit)) {
			$access = "admin";
		}
		if($this->isSysadmin()) {
			$access = "sysadmin";
		}
		return $access;
   }
   
   /**
    * generateRandID - Generates a string made up of randomized
    * letters (lower and upper case) and digits and returns
    * the md5 hash of it to be used as a userid.
    */
   function generateRandID(){
      return md5($this->generateRandStr(16));
   }
   
   /**
    * generateRandStr - Generates a string made up of randomized
    * letters (lower and upper case) and digits, the length
    * is a specified parameter.
    */
   function generateRandStr($length){
      $randstr = "";
      for($i=0; $i<$length; $i++){
         $randnum = mt_rand(0,61);
         if($randnum < 10){
            $randstr .= chr($randnum+48);
         }else if($randnum < 36){
            $randstr .= chr($randnum+55);
         }else{
            $randstr .= chr($randnum+61);
         }
      }
      return $randstr;
   }



   function generateAccessUsername($length){
      $randstr = "";
      for($i=0; $i<$length; $i++){
         $randnum = mt_rand(65,90);
		 $randstr .= chr($randnum);
      }
      return $randstr;
   }
   
   function generateAccessPassword($length){
      $randstr = "";
      for($i=0; $i<$length; $i++){
         $randnum = mt_rand(1,9);
         $randstr .= chr($randnum+48);
      }
      return $randstr;
   }
   
   function checkUserActive($id) {
	   global $database;
	   return $database->checkUserActive($id);
   }


}

/**
 * Initialize session object - This must be initialized before
 * the form object because the form uses session variables,
 * which cannot be accessed unless the session has started.
 */
$session = new Session;
/* Initialize form object */
$form = new Form;
include_once(CO_INC . "/lang/" . $session->userlang . ".php");
?>
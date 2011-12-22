<?php
//include("config.php");
include(CO_INC . "/api/apps/publishers/menues/orders/session.php");

class Process
{
   /* Class constructor */
   function Process(){
      global $session;
      /* User submitted login form */
      if(isset($_POST['sublogin'])){
         $this->procLogin();
      }
	  else if(isset($_POST['changelogin'])){
         $this->procChangeLogin();
      }
	  else if(isset($_GET['fieldId'])) {
			$this->procCheckUsername();
	  }
	  else if($session->logged_in){
         $this->procLogout();
      }
      /**
       * Should not get here, which means user is viewing this page
       * by mistake and therefore is redirected.
       */
       else{
          //echo "yes me allowed";
		  header("Location: /?path=api/apps/publishers/menues/orders");
       }
   }

   function procLogin(){
      global $session, $form;
      $retval = $session->login($_POST['user'], $_POST['pass'], isset($_POST['remember']));
	  if($retval){
		 echo "1";
      } else{
		 echo "0";
      }
   }
   
    function procCheckUsername(){
      global $session;
	  
	  $retval = $session->checkUsername($_GET['fieldValue']);
	  if($retval){
		 echo '["username",false]';
      } else{
		 echo '["username",true]';
      }
   }
   
   function checkUsername($username){
      global $session;
	  
	  $retval = $session->checkUsername($username);
	  if($retval){
		 return false;
      } else{
		 return true;
      }
   }
   
   function procChangeLogin(){
      global $session;
	  $username = $_POST['username'];
	  if(!$this->checkUsername($username)) {
		  echo "0";
	  } else {
		  $retval = $session->changeLogin($_POST['username'], $_POST['password']);
		  if($retval){
			 $session->logout();
			 $retval = $session->login($_POST['username'], $_POST['password'], isset($_POST['remember']));
			 echo "1";
		  } else{
			 echo "0";
		  }
	  }
   }


   function procLogout(){
      global $session;
      $retval = $session->logout();
      header("Location: /?path=api/apps/publishers/menues/orders");
   }


};

/* Initialize process */
$process = new Process;
?>
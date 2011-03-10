<?php
//include("config.php");
include(CO_INC . "/classes/session.php");

class Process
{
   /* Class constructor */
   function Process(){
      global $session;
      /* User submitted login form */
      if(isset($_POST['sublogin'])){
         $this->procLogin();
      }
      else if($session->logged_in){
         $this->procLogout();
      }
      /**
       * Should not get here, which means user is viewing this page
       * by mistake and therefore is redirected.
       */
       else{
          header("Location: /");
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


   function procLogout(){
      global $session;
      $retval = $session->logout();
      header("Location: ".CO_PATH_URL);
   }


};

/* Initialize process */
$process = new Process;
?>
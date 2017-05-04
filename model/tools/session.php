<?php 
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);


	class session{

		function __construct(){
			session_start();
		}


		public function setUserName($username){
			
			$_SESSION['username'] = $username;
		}

		public function setUserId($user_id){
			$session['user_id'] = $user_id;
		}

		public function returnUsername(){

			if(!empty($_SESSION['username'])){
				return $_SESSION['username'];
			}else{
				return false;
			}

			
		}

		public function returnUserId(){
			if(!empty($session['user_id'])){
				return $_SESSION['user_id'];
			}else{
				throw new Exception("Error Processing Request", 1);
				
			}
		}


		public function destroySession(){
			session_destroy();
		}
	}


?>
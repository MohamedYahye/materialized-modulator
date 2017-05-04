<?php
	

	/**
	* add new beheerder
	*/
	class ADDBEHEERDER {
		
		private $name;
		private $username;
		private $email;
		private $password;

		private $proceed;
		private $connect;
		private $response;


		function __construct(){

			require_once("connect.php");

			$this->proceed = false;
			$this->response = array();
			$this->connect = null;


			if(!empty(isset($_POST))){
				if(!empty($_POST['name'])){
					$this->name = $_POST['name'];
					$this->proceed = true;
				}

				if(!empty($_POST['username'])){
					$this->username = $_POST['username'];
					$this->proceed = true;
				}
				if(!empty($_POST['email'])){
					$this->email = $_POST['email'];
					$this->proceed = true;
				}

				if(!empty($_POST['password'])){
					$this->password = $_POST['password'];
					$this->proceed = true;
				}

				if(!empty($_POST['repeat'])){
					if(strcmp($_POST['repeat'], $this->password) == 0){
						$this->proceed == true;
					}else{
						$this->proceed = false;
					}
				}
			}


			if($this->proceed){
				echo json_encode($this->ADDBEHEERDER());
			}


			
		}

		private function ADDBEHEERDER(){

			try{

				require_once("hash.php");

				$doesBeheerderExist = $this->doesBeheerderExist();

				if($doesBeheerderExist){
					$this->response['beheerder_exist'] = true;
				}else{


					$this->connect = new connect();
					$returnName = $this->returnName();
					$returnUserName = $this->returnUserName();
					$returnEmail = $this->returnEmail();
					$returnPassword = $this->returnPassword();

					$dbh = $this->connect->returnConnection();

					$stmt = $dbh->prepare("INSERT INTO beheerder (name, username, email, password) VALUES(:name, :username, :email, :password)");

					$hashed = Bcrypt::hashPassword($returnPassword);
					
					$stmt->bindParam(":name", $returnName);
					$stmt->bindParam(":username", $returnUserName);
					$stmt->bindParam(":email", $returnEmail);
					$stmt->bindParam(":password", $hashed);

					$stmt->execute();

					if($stmt->rowCount() > 0){
						$this->response['added'] = true;
					}else{
						$this->response['added'] = false;
					}

				}

				return $this->response;



			}catch(PDOException $e){
				return $e->getMessage();
			}

		}


		private function doesBeheerderExist(){
			try{

				$this->connect = new connect();

				$returnName = $this->returnName();
				$returnUserName = $this->returnUserName();
				$returnEmail = $this->returnEmail();


				$dbh = $this->connect->returnConnection();

				$stmt = $dbh->prepare("SELECT name, username, email FROM beheerder WHERE name=:name OR username=:username OR email=:email");

				$stmt->bindParam(":name", $returnName);
				$stmt->bindParam(":username", $returnUserName);
				$stmt->bindParam(":email", $returnEmail);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					return true;
				}else{
					return false;
				}
				return false;

			}catch(PDOException $e){
				return $e->getMessage();
			}
		}

		private function returnName(){
			return $this->name;
		}
		private function returnUserName(){
			return $this->username;
		}
		private function returnEmail(){
			return $this->email;
		}
		private function returnPassword(){
			return $this->password;
		}
	}


	new ADDBEHEERDER();

?>
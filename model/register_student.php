<?php 
	
	/**
	* register student
	*/
	class RegisterStudent{

		private $ov;
		private $name;
		private $username;
		private $email;
		private $password;
		private $repeat_password;
		private $opleiding;
		private $uitstroom;
		private $leerjaar;
		
		private $connect;
		private $proceed;
		private $response;

		public function __construct(){

			$this->proceed = false;

			$this->connect = null;


			if(!empty(isset($_POST))){
				if(!empty(isset($_POST['ov']))){
					$this->proceed = true;
					$this->ov = $_POST['ov'];

				}else{
					$this->proceed = false;
				}

				if(!empty(isset($_POST['name']))){
					$this->proceed = true;
					$this->name = $_POST['name'];

				}else{
					$this->proceed = false;
				}

				if(!empty(isset($_POST['username']))){
					$this->proceed = true;
					$this->username = $_POST['username'];
				}else{
					$this->proceed = false;
				}

				if(!empty(isset($_POST['email']))){
					$this->proceed = true;
					$this->email = $_POST['email'];
				}else{
					$this->proceed = false;
				}

				if(!empty(isset($_POST['password']))){
					$this->proceed = true;
					$this->password = $_POST['password'];
				}else{
					$this->proceed = false;
				}

				if(!empty(isset($_POST['repeat_password']))){
					if($_POST['repeat_password'] == $this->password){
						$this->proceed = true;
					}else{
						$this->proceed = false;
					}
				}

				if(!empty(isset($_POST['opleiding']))){
					$this->proceed = true;
					$this->opleiding = $_POST['opleiding'];
				}else{
					$this->proceed = false;
				}

				if(!empty(isset($_POST['uitstroom']))){
					$this->uitstroom = $_POST['uitstroom'];
					$this->proceed = true;
				}else{
					$this->proceed = false;
				}

				if(!empty(isset($_POST['leerjaar']))){
					$this->proceed = true;
					$this->leerjaar = $_POST['leerjaar'];
				}else{
					$this->proceed = false;
				}
			}


			if($this->proceed){
				echo json_encode($this->register());
			}else{
				echo json_encode(array("oeps"=>"something went wrong"));
			}
		}



		private function register(){
			try{
				require_once("tools/connect.php");
				require_once("tools/hash.php");

				$this->connect = new connect();

				$returnOv = $this->returnOv();
				$returnName = $this->returnName();
				$returnUsername = $this->returnUsername();
				$returnEmail = $this->returnEmail();
				$returnPassword = $this->returnPassword();
				$returnOpleiding = $this->returnOpleiding();
				$returnUitstroom = $this->returnUitstroom();
				$returnLeerjaar = $this->returnLeerjaar();


				$dbh = $this->connect->returnConnection();

				$stmt = $dbh->prepare("SELECT ov_nummer, name, username, email FROM student WHERE ov_nummer=:ov_nummer OR name=:name OR username=:username OR email=:email");

				$stmt->bindParam(":ov_nummer", $returnOv);
				$stmt->bindParam(":name", $returnName);
				$stmt->bindParam(":username", $returnUsername);
				$stmt->bindParam(":email", $returnEmail);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$this->response['user'] = true;
				}else{

					$hashed = Bcrypt::hashPassword($returnPassword);


					$stmt = $dbh->prepare("INSERT INTO student (ov_nummer, name, username, email, password, opleiding, leerjaar, uitstroom) VALUES(:ov_nummer, :name, :username, :email, :password, :opleiding, :leerjaar, :uitstroom)");


					$stmt->bindParam(":ov_nummer", $returnOv);
					$stmt->bindParam(":name", $returnName);
					$stmt->bindParam(":username", $returnUsername);
					$stmt->bindParam(":email", $returnEmail);
					$stmt->bindParam(":password", $hashed);
					$stmt->bindParam(":opleiding", $returnOpleiding);
					$stmt->bindParam(":leerjaar", $returnLeerjaar);
					$stmt->bindParam(":uitstroom", $returnUitstroom);

					$stmt->execute();

					if($stmt->rowCount() > 0){
						$this->response['created'] = true;
					}else{
						$this->response['created'] = false;
					}


				}

				return $this->response;

			}catch(PDOException $e){
				return $e->getMessage();
			}
		}


		private function returnOv(){
			return $this->ov;
		}
		private function returnName(){
			return $this->name;
		}
		private function returnUsername(){
			return $this->username;
		}
		private function returnEmail(){
			return $this->email;
		}
		private function returnPassword(){
			return $this->password;
		}
		private function returnOpleiding(){
			return $this->opleiding;
		}
		private function returnUitstroom(){
			return $this->uitstroom;
		}
		private function returnLeerjaar(){
			return $this->leerjaar;
		}
	}

	new RegisterStudent();


?>
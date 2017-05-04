<?php 

	
	/**
	* Login student
	*/
	class LoginStudent{


		private $ov_nummer;
		private $password;
		private $connect;
		private $response;
		private $proceed;
		
		function __construct(){


			$this->connect = null;
			$this->proceed =  false;


			if(!empty(isset($_POST))){
				if(!empty($_POST['ov'])){
					$this->ov_nummer = $_POST['ov'];
					$this->proceed = true;
				}else{
					$this->proceed = false;
				}

				if(!empty($_POST['password'])){
					$this->password = $_POST['password'];
					$this->proceed = true;
				}else{
					$this->proceed = false;
				}
			}


			if($this->proceed){
				echo json_encode($this->Login());
			}
			
		}

		private function Login(){
			try{

				require_once("tools/connect.php");
				require_once("tools/hash.php");
				require_once("tools/session.php");

				$this->connect = new connect();

				$dbh = $this->connect->returnConnection();

				$returnOv = $this->returnOv();
				$returnPassword = $this->returnPassword();

				$stmt = $dbh->prepare("SELECT student_id, name, ov_nummer, password FROM student WHERE ov_nummer=:ov_nummer");

				$stmt->bindParam(":ov_nummer", $returnOv);

				$stmt->execute();

				if($stmt->rowCount() > 0){

					$result = $stmt->fetch(PDO::FETCH_ASSOC);

					$checkPassword = Bcrypt::checkPassword($returnPassword, $result['password']);

					if($checkPassword){
						$this->response['user'] = true;

						$session = new session();

						$session->setUserName($result['name']);
						$session->setUserId($result['student_id']);

					}else{
						$this->response['password'] = false;
					}

					
				}else{
					$this->response['user'] = false;
				}

				return $this->response;


			}catch(PDOException $e){
				return $e->getMessage();
			}
		}

		private function returnOv(){
			return $this->ov_nummer;
		}

		private function returnPassword(){
			return $this->password;
		}


	}


	new LoginStudent();


?>
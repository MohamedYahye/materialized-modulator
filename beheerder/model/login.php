<?php 

	

	class Login{

		private $username;
		private $password;
		private $connect;
		private $response;

		private $proceed;


		public function __construct(){

			$this->connect = null;
			$this->response = array();
			$this->proceed = false;

			if(!empty(isset($_POST))){

				if(!empty($_POST['username'])){
					$this->username = $_POST['username'];
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
			}else{
				$this->proceed = false;

				echo json_encode(array("missin values"=>true));
			}

			if($this->proceed){
				echo json_encode($this->Login());

			}else{
				echo json_encode(array("missin values"=>true));
			}

		}


		private function Login(){

			try{

				require_once("tools/connect.php");
				require_once("tools/hash.php");
				require_once("tools/session.php");

				$this->connect = new connect();


				$returnUsername = $this->returnUsername();
				$returnPassword = $this->returnPassword();

				$dbh = $this->connect->returnConnection();

				$stmt = $dbh->prepare("SELECT beheerder_id, username, password FROM beheerder WHERE username=:username");

				$stmt->bindParam(":username", $returnUsername);

				$stmt->execute();

				if($stmt->rowCount() > 0 ){
					$result = $stmt->fetch(PDO::FETCH_ASSOC);

					$hash = $result['password'];

					$check = Bcrypt::checkPassword($returnPassword, $hash);

					if($check){
						$this->response['password'] = true;

						$session = new session();

						$session->setUserName($result['username']);
						$session->setUserId($result['beheerder_id']);




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

		private function returnUsername(){
			return $this->username;
		}

		private function returnPassword(){
			return $this->password;
		}
	}


new Login();

?>
<?php 
	
	/**
	* edit beheerder
	*/
	class EDITBEHEERDER{
		
		private $beheerderName;

		private $connect;

		private $response;

		private $proceed;

		function __construct(){
			require_once("connect.php");
			$this->connect = null;
			$this->response = array();
			$this->proceed = false;
			if(!empty(isset($_POST))){
				if(!empty($_POST['beheerder'])){
					$this->beheerderName = $_POST['beheerder'];
					$this->proceed = true;
				}
			}

			if($this->proceed){
				echo json_encode($this->getBeheerder());
			}

			if(!empty(isset($_POST['check_password']))){
				if(!empty($_POST['password'])){
					echo json_encode($this->check_password($_POST['password'], $_POST['current_name']));
				}
			}
		}



		private function check_password($password, $current_name){
			try{

				if(!empty($password)){
					if(!empty($current_name)){
						$this->connect = new connect();

						$dbh = $this->connect->returnConnection();

						$stmt = $dbh->prepare("SELECT password FROM beheerder WHERE username=:username");

						require_once("hash.php");

						$stmt->bindParam(":username", $current_name);

						$stmt->execute();

						if($stmt->rowCount() > 0){

							$storedPass = $stmt->fetch(PDO::FETCH_ASSOC);



							$checkPassword = Bcrypt::checkPassword($password,$storedPass['password'] );

							if($checkPassword){
								$this->response['password'] = true;
							}else{
								$this->response['password'] = false;
							}
						}

						return $this->response;
					}

				}

			}catch(PDOException $e){
				return $e->getMessage();
			}
		}


		private function getBeheerder(){
			try{

				$this->connect = new connect();

				$returnBeheerderName = $this->returnBeheerderName();

				$dbh = $this->connect->returnConnection();

				$stmt = $dbh->prepare("SELECT name, username, email, password FROM beheerder WHERE username=:username");

				$stmt->bindParam(":username", $returnBeheerderName);

				$stmt->execute();

				if($stmt->rowCount() > 0){

					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

					$this->response['user_found'] = true;

					foreach($result as $res){
						$this->response['name'] = $res['name'];
						$this->response['username'] = $res['username'];
						$this->response['email'] = $res['email'];
						$this->response['password'] = $res['password'];
					}

					



				}else{
					$this->response['user_found'] = false;
				}
				return $this->response;

			}catch(PDOException $e){
				return $e->getMessage();
			}
		}

		private function returnBeheerderName(){
			return $this->beheerderName;
		}
	}

	new EDITBEHEERDER();

?>
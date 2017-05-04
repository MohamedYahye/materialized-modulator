<?php 
	
	class GetStudent{
		private $proceed;
		private $connect;
		private $studentname;
		private $response;

		public function __construct(){
			$this->proceed = false;
			$this->connect = null;
			$this->response = array();
			if(!empty(isset($_POST))){
				if($_POST['student']){
					$this->studentname = $_POST['student'];
					$this->proceed = true;
				}else{
					$this->proceed = false;
				}
			}

			if($this->proceed){
				echo json_encode($this->GetStudent());
			}else{
				echo json_encode(array("user"=>false));
			}
		}


		private function GetStudent(){

			try{
				require_once("tools/connect.php");

				$returnStudentName = $this->returnStudentName();
				$this->connect = new connect();
				$dbh = $this->connect->returnConnection();

				$stmt = $dbh->prepare("SELECT * FROM student WHERE name=:name");

				$stmt->bindParam(":name", $returnStudentName);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$this->response['success'] = true;
					foreach($result as $res){
						$this->response['ov_nummer'] = $res['ov_nummer'];
						$this->response['name'] = $res['name'];
						$this->response['username'] = $res['username'];
						$this->response['email'] = $res['email'];
						$this->response['password'] = $res['password'];
						$this->response['opleiding'] = $res['opleiding'];
						$this->response['leerjaar'] = $res['leerjaar'];
						$this->response['uitstroom'] = $res['uitstroom'];
					}
				}else{
					$this->response['user'] = false;
				}

				return $this->response;

			}catch(PDOException $e){
				return $e->getMessage();
			}


		}
		private function returnStudentName(){
			return $this->studentname;
		}
	}


	new GetStudent();



?>
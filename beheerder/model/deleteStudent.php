<?php 
	
	/**
	* delete student
	*/
	class DeleteStudent {

		private $student;
		private $proceed;
		private $connect;
		private $response;
		
		function __construct(){

			$this->connect = null;
			$this->proceed = false;
			$this->response = array();

			require_once("tools/connect.php");


			if(!empty(isset($_POST))){
				if(!empty($_POST['student'])){
					$this->student = $_POST['student'];
					$this->proceed = true;
				}else{
					$this->proceed = false;
				}
			}else{
				$this->proceed = false;
			}


			if($this->proceed){
				echo json_encode($this->DeleteStudent());
			}else{
				echo json_encode(array("error"=>"oeps...."));
			}
		}



		private function DeleteStudent(){
			try{


				$returnStudent = $this->returnStudent();

				$this->connect = new connect();

				$dbh = $this->connect->returnConnection();

				$stmt = $dbh->prepare("DELETE FROM student WHERE name=:name");
				$stmt->bindParam(":name", $returnStudent);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$this->response['deleted'] = true;
				}else{
					$this->response['deleted'] =  false;
				}



				return $this->response;
			}catch(PDOException $e){
				return $e->getMessage();
			}
		}


		private function returnStudent(){
			return $this->student;
		}
	}


	new DeleteStudent();

?>
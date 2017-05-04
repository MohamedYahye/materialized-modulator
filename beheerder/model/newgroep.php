<?php 
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	/**
	* create new group
	*/
	class newGroup{
		private $groupname;
		private $response;
		private $proceed;
		private $groepLeden;
		private $connect;

		function __construct(){
			require_once("tools/connect.php");
			$this->connect = null;
			$this->proceed = false;
			$this->response = array();
			$this->groepLeden = array();
			
			if(!empty(isset($_POST))){
				if(!empty($_POST['groepnaam'])){
					$this->groupname = $_POST['groepnaam'];
					$this->proceed = true;
				}

				if(!empty($_POST['box'])){

					foreach($_POST['box'] as $student){
						array_push($this->groepLeden, $student);
					}

					
				}
			}

			if($this->proceed){
				$this->getMemebrsById();
			}else{
				echo "string";
			}

		}



		private function newGroup(){

			try{

				$checkGroupName = $this->checkGroupName();

				$this->connect = new connect();

				$dbh = $this->connect->returnConnection();

				$returnGroupName = $this->returnGroupName();

				if(!$checkGroupName){


					$stmt = $dbh->prepare("INSERT INTO groep (groep_naam) values(:groep_naam)");


					$stmt->bindParam(":groep_naam", $returnGroupName);

					$stmt->execute();

					if($stmt->rowCount() > 0){
						$groep_id = $dbh->lastInsertId();
						return $groep_id;
					}else{
						return false;
					}
				}

		
			}catch(PDOExcetion $e){
				return $e->getMessage();
			}

		}


		private function getMemebrsById(){
			try{

				$this->connect = new connect();

				$dbh = $this->connect->returnConnection();

				$returnGroupLeden = $this->returnGroupLeden();

				$student_id_array = array();

				if(!is_null($returnGroupLeden)){
					$stmt = $dbh->prepare("SELECT student_id FROM student WHERE name=:name");

					foreach($returnGroupLeden as $leden){
						$stmt->bindParam(":name", $leden);

						$stmt->execute();

						if($stmt->rowCount() > 0){
							$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

							$flat = iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($data)), 0);

							$keys = array_keys($data);
							for($i = 0; $i < count($data); $i++) {
							    foreach($data[$keys[$i]] as $key => $value) {
							        array_push($student_id_array, $value);
							    }
							}
						}
					}
				
					
					$checkGroupName = $this->checkGroupName();

					if($checkGroupName){
						$this->response = "groep naam is niet uniek";
					}else{


						$group_id = $this->newGroup();

						$stmt = $dbh->prepare("INSERT INTO koppeltabel (groep_id, student_id) VALUES(:groep_id, :student_id)");

						foreach($student_id_array as $i=>$row){
							$stmt->bindParam(":groep_id", $group_id);
							$stmt->bindParam(":student_id", $row);

							$stmt->execute();

							if($stmt->rowCount() > 0){
								$this->response = "groep is aangemaakt";

							}else{
								$this->response = "er ging iets fout.. probeer het nog een keer S.V.P";
							}
						}

					}
					
				}else{
					$this->response = "er ging iets fout.. probeer het nog een keer S.V.P";
				}

				$this->redirectWithMessage($this->response);
				
			}catch(PDOExcetion $e){
				return $e->getMessage();
			}
		}

		private function checkGroupName(){
			try{

				$returnGroupName = $this->returnGroupName();

				$this->connect = new connect();

				$dbh = $this->connect->returnConnection();

				$stmt = $dbh->prepare("SELECT groep_naam FROM groep WHERE groep_naam=:groep_naam");
				$stmt->bindParam(":groep_naam", $returnGroupName);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					return true;
				}else{
					return false;
				}

				return false;
			}catch(PDOExcetion $e){
				return $e->getMessage();
			}
		}

		private function returnGroupName(){
			return $this->groupname;
		}
		private function returnGroupLeden(){
			return $this->groepLeden;
		}


		private function redirectWithMessage($message){
			try{

				return header("Location:" ."../view/groepen.php?message=".base64_encode($message));

			}catch(RedirectException $e){
				return $e->getMessage();
			}
		}
	}


	new newGroup();

?>
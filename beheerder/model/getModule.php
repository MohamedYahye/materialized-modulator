<?php 
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	class GetModule{

		private $moduleName;
		private $response;
		private $proceed;
		private $connect;
		private $continue;

		public function __construct(){

			$this->connect = null;
			$this->response = array();
			$this->proceed = false;

			if(!empty(isset($_POST['module']))){
				if($_POST['module']){
					$this->moduleName = $_POST['module'];
					$this->proceed = true;
				}else{
					$this->proceed = false;
				}
			}else{
				$this->proceed = false;
			}


			if($this->proceed){
				echo $this->GetModule();
			}else{
				echo json_encode(array("proceed"=>false));
			}

			// if(!empty(isset($_POST['getUsers']))){
			// 	if(!empty(isset($_POST['module']))){
			// 		$this->moduleName = $_POST['module'];
			// 		$this->continue = true;
			// 	}else{
			// 		$this->continue = false;
			// 	}
			// }else{
			// 	$this->continue = false;
			// }


			// if($this->continue){
			// 	echo json_encode($this->GetModuleUsers());
			// }
		}

		private function GetModule(){
			try{

				require_once("tools/connect.php");

				$this->connect = new connect();
				$returnModule = $this->returnModule();

				$dbh = $this->connect->returnConnection();

				$stmt = $dbh->prepare("SELECT * FROM module WHERE module_locatie=:module");
				$stmt->bindParam(":module", $returnModule);

				$stmt->execute();



				if($stmt->rowCount() > 0){
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

					foreach($result as $res){
						$this->response = $res;
					}


					

				}else{
					$this->response['proceed'] = "false";
				}


				return json_encode($this->response);

			}catch(PDOException $e){
				return $e->getMessage();
			}

		}


		private function GetModuleUsers(){
			try{

				require_once("tools/connect.php");

				$this->connect = new connect();
				$returnModule = $this->returnModule();

				$dbh = $this->connect->returnConnection();

				$stmt = $dbh->prepare("SELECT module_id FROM module WHERE module_locatie=:module");
				$stmt->bindParam(":module", $returnModule);

				$stmt->execute();

				if($stmt->rowCount() > 0){

					$result = $stmt->fetch(PDO::FETCH_ASSOC);

					$stmt = $dbh->prepare("SELECT groep_id FROM module_koppel WHERE module_id=:module_id");


					$stmt->bindParam(":module_id", $result['module_id']);

					$stmt->execute();

					if($stmt->rowCount() > 0){
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$stmt = $dbh->prepare("SELECT groep_naam FROM groep WHERE groep_id=:groep_id");

						foreach($result as $group){
							$stmt->bindParam(":groep_id", $group['groep_id']);

							$stmt->execute();

							if($stmt->rowCount() > 0){
								$this->response['groups'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
							}
						}
					}else{
						$this->response['module_groep'] = "module has no group";
					}
				}
				

				return json_encode($this->response);
			}catch(PDOException $e){
				return $e->getMessage();
			}
		}

		private function selectGroupByName($groupId){
			try{

				require_once("tools/connect.php");

				$this->connect = new connect();

				$dbh = $this->connect->returnConnection();

				$groupId = array();


				$stmt = $dbh->prepare("SELECT groep_naam FROM groep WHERE groep_id=:groep_id");

				foreach($groupId as $group){
					$stmt->bindParam(":groep_id", $groupId['groep_id']);

					$stmt->execute();

					if($stmt->rowCount() > 0){
						return $stmt->fetchAll(PDO::FETCH_ASSOC);
					}
				}

			}catch(PDOException $e){
				return $e->getMessage();
			}
		}

		private function returnModule(){
			return $this->moduleName;
		}
	}

	new GetModule();


?>
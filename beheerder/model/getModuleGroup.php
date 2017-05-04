<?php 
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	class GetModuleGroup{

		private $module_name;
		private $response;
		private $connect;
		private $proceed;

		public function __construct(){
			require_once("tools/connect.php");

			$this->proceed = false;
			$this->connect = null;
			$this->response = array();


			if(!empty(isset($_POST))){
				if($_POST['module_name']){
					$this->module_name = $_POST['module_name'];
					$this->proceed = true;
				}else{
					$this->proceed = false;
				}
			}else{
				$this->proceed = false;
			}

			if($this->proceed){
				echo json_encode($this->getGroupNameById());
			}
		}




		private function changeModuleStatus(){
			return "hi";
		}

		private function getModuleIdByName(){
			try{
				$this->connect = new connect;
				$dbh = $this->connect->returnConnection();

				$returnModuleName = $this->returnModuleName();

				$stmt = $dbh->prepare("SELECT module_id FROM module WHERE module_locatie=:module_name");
				$stmt->bindParam(":module_name", $returnModuleName);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$result = $stmt->fetch(PDO::FETCH_ASSOC);

					return $result['module_id'];
				}else{
					return false;
				}

				return false;

			}catch(PDOException $e){
				return $e->getMessage();
			}


		}

		private function GetModuleGroup(){
			try{
				$this->connect = new connect;
				$dbh = $this->connect->returnConnection();

				$module_id = $this->getModuleIdByName();

				$stmt = $dbh->prepare("SELECT DISTINCT groep_id FROM module_koppel WHERE module_id=:module_id");

				$stmt->bindParam(":module_id", $module_id);
				$stmt->execute();

				$temp = array();
				if($stmt->rowCount() > 0 ){
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					return $result;
					
				}else{
					return false;
				}

				return false;
				

			}catch(PDOException $e){
				return $e->getMessage();
			}
		}



		private function getGroupNameById(){
			try{
				$this->connect = new connect;
				$dbh = $this->connect->returnConnection();
				$groep_id = $this->GetModuleGroup();

				if($groep_id != false){
					$temp = array();

					foreach($groep_id as $id){
						array_push($temp, $id['groep_id']);
					}


					$stmt = $dbh->prepare("SELECT groep_naam FROM groep WHERE groep_id=:groep_id");

					$groupNameArray = array();

					if(!empty($groep_id)){
						foreach($temp as $id){
							$stmt->bindParam(":groep_id", $id);

							$stmt->execute();

							if($stmt->rowCount() > 0){
								$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
							}

							foreach($result as $res){
								array_push($groupNameArray, $res['groep_naam']);
							}

						}

						$this->response['group'] = true;
						$this->response['group_name'] = $groupNameArray;
					}else{
						$this->response['empty'] = true;
					}

				}else{
					$this->response['group'] = false;
				}

				return $this->response;

			}catch(PDOException $e){
				return $e->getMessage();
			}
		}


		private function getGroupByName($group_id){
			try{

				$group_id = array();

				$this->connect = new connect();

				$dbh = $this->connect->returnConnection();

				$stmt = $dbh->prepare("SELECT groep_naam FROM groep WHERE groep_id=:groep_id");

				if(!empty($group_id)){
					foreach($group_id as $id){
						$stmt->bindParam(":group_id", $group_id);

						$stmt->execute();

						return $stmt->fetchAll(PDO::FETCH_ASSOC);
					}
				}


			}catch(PDOException $e){
				return $e->getMessage();
			}
		}


		private function returnModuleName(){
			return $this->module_name;
		}
	}

	new GetModuleGroup();

?>
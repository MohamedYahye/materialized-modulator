<?php 
	/**
	* Module koppelen aan groepen
	*/
	class moduleKoppel{
		
		private $connect;


		function __construct(){
			require_once("tools/connect.php");
			$this->connect = null;


			if(!empty(isset($_POST['remove']))){
				echo json_encode($this->removeFromGroupFromModule($_POST['group_name'], $_POST['module_name']));
			}

			if(!empty(isset($_POST['add']))){
				echo json_encode($this->adGroupToModule($_POST['group_name'], $_POST['module_name']));
			}
		}


		public function moduleKoppel($module){
			try{

				$this->connect = new connect();

				$dbh = $this->connect->returnConnection();

				if($module != null){

					$module_id = $this->GetModuleById($module);

					if(is_numeric($module_id)){

						$stmt = $dbh->prepare("SELECT groep_id FROM module_koppel WHERE module_id=:module_id");

						$stmt->bindParam(":module_id", $module_id);

						$stmt->execute();

						$groep_id = array();

						if($stmt->rowCount() > 0){
							$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
							echo "<h6>Groepen die toegang hebben tot deze module. Klik op groep om module te ontkoppelen</h6>";

							$stmt = $dbh->prepare("SELECT groep_naam FROM groep WHERE groep_id=:groep_id");

							foreach($result as $id){
								$stmt->bindParam(":groep_id", $id['groep_id']);

								$stmt->execute();

								if($stmt->rowCount() > 0){

									$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
									foreach($result as $name){
										echo "<div class='collection members'><a href='#!' class='collection-item member-item'>".$name['groep_naam']."</a></div>";
									}
								}
							}
							

						}else{
							echo "<span>Module heeft geen groepen</span";
						}
					}else{
						return false;
					}
				}else{
					return false;
				}


			}catch(PDOException $e){
				return $e->getMessage();
			}
		}


		public function GetModuleById($module){
			try{

				$this->connect = new connect();

				$dbh = $this->connect->returnConnection();

				if($module != null){
					$stmt = $dbh->prepare("SELECT module_id FROM module WHERE module_locatie=:module");
					$stmt->bindParam(":module", $module);

					$stmt->execute();

					if($stmt->rowCount() > 0){
						$res = $stmt->fetch(PDO::FETCH_ASSOC);

						return $res['module_id'];
					}else{
						return false;
					}

				}else{
					return false;
				}
				return false;


			}catch(PDOException $e){
				return $e->getMessage();
			}
		}


		public function GetNewGroups($module_id){
			try{

				$this->connect = new connect();

				$dbh = $this->connect->returnConnection();

				//SELECT groep_naam, groep_id FROM groep WHERE groep_id NOT in(SELECT groep_id FROM module_koppel WHERE module_id=15)


				if($module_id != null){
					$stmt = $dbh->prepare("SELECT groep_naam FROM groep WHERE groep_id NOT IN(SELECT groep_id FROM module_koppel WHERE module_id=:module_id)");

					$stmt->bindParam(":module_id", $module_id);

					$stmt->execute();

					if($stmt->rowCount() > 0){

						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						echo "<h5>Potentiole groepen</h5><h6>Klik op groep om aan module toe te voegen</h6>";
						foreach($result as $name){
							echo "<div class='collection new-members'><a href='#!' class='collection-item member-new'>".$name['groep_naam']."</a></div>";
						}
					}
				}

			}catch(PDOException $e){
				return $e->getMessage();
			}
		}



		private function removeFromGroupFromModule($group_name, $module_name){

			try{

				if(!empty(is_string($module_name)) && (!empty(is_string($group_name)))){

					$response = array();

					$module_id = $this->GetModuleById(trim($module_name));
					$getGroupById = $this->getGroupById($group_name);

					$this->connect = new connect();

					$dbh = $this->connect->returnConnection();

					$stmt = $dbh->prepare("DELETE FROM module_koppel WHERE module_id=:module_id AND groep_id=:groep_id");

					$stmt->bindParam(":module_id", $module_id);

					$stmt->bindParam(":groep_id", $getGroupById);

					$stmt->execute();

					if($stmt->rowCount() > 0){
						$response['removed'] = true;
					}else{
						$response['removed'] = false;
					}

					return $response;

				}else{
					return false;
				}

			}catch(PDOException $e){
				return $e->getMessage();
			}
		}


		private function getGroupById($group_name){
			try{

				$this->connect = new connect();

				$dbh = $this->connect->returnConnection();

				if(!empty(is_string($group_name))){
					$stmt = $dbh->prepare("SELECT groep_id FROM groep WHERE groep_naam=:groep_naam");

					$stmt->bindParam(":groep_naam", $group_name);

					$stmt->execute();

					if($stmt->rowCount() > 0){
						$result = $stmt->fetch(PDO::FETCH_ASSOC);

						return $result['groep_id'];
					}else{
						return false;
					}

				}else{
					return false;
				}


			}catch(PDOException $e){
				return $e->getMessage();
			}
		}


		private function adGroupToModule($group_name, $module_name){
			try{

				if(!empty(is_string($module_name)) && (!empty(is_string($group_name)))){

					$response = array();

					$module_id = $this->GetModuleById(trim($module_name));
					$getGroupById = $this->getGroupById($group_name);

					$this->connect = new connect();

					$dbh = $this->connect->returnConnection();

					$stmt = $dbh->prepare("INSERT INTO module_koppel (module_id, groep_id) VALUES(:module_id, :groep_id)");

					$stmt->bindParam(":module_id", $module_id);
					$stmt->bindParam(":groep_id", $getGroupById);

					$stmt->execute();

					if($stmt->rowCount() > 0){
						$response['added'] = true;
					}else{
						$response['added'] = false;
					}

					return $response;

				}else{
					return "false error";
				}

			}catch(PDOException $e){
				return $e->getMessage();
			}


		}
	}

	new moduleKoppel();

?>
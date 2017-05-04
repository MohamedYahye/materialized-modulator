<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	/**
	* get all groups
	*/
	class GetGroup {
		
		private $groupName;
		private $groupmember;
		private $response;
		private $proceed;
		private $continue;
		private $new_group_name;
		private $new_group;

		function __construct() {

			if(isset($_POST['remove'])){
				if(!empty(isset($_POST['groepnaam']))){

					$this->groupName = $_POST['groepnaam'];

					$this->proceed = true;
					if(!empty(isset($_POST['member']))){
						$this->groupmember = $_POST['member'];

						$this->proceed = true;
					}else{
						$this->proceed = false;
					}
				}else{
					$this->proceed = false;
				}

			}elseif(isset($_POST['add'])){
				if(!empty(isset($_POST['groepnaam']))){
					$this->groupName = $_POST['groepnaam'];
					$this->continue = true;
					if(!empty(isset($_POST['member']))){
						$this->groupmember = $_POST['member'];
						$this->continue = true;
					}
					
				}
			}elseif(isset($_POST['new_group'])){
				if(!empty($_POST['groepnaam'])){
					$this->groupName = $_POST['groepnaam'];
					$this->new_group = true;
				}else{
					$this->new_group = false;
				}
				if(!empty($_POST['new_group_name'])){
					$this->new_group_name = $_POST['new_group_name'];
					$this->new_group = true;
				}else{
					$this->new_group = false;
				}
				
			}elseif(isset($_POST['delete_group'])){

				echo json_encode($this->delete_group($_POST['groepnaam']));
			}
			

			if($this->proceed){
				echo json_encode($this->removeMember());
			}


			if($this->continue){
				echo json_encode($this->addMember());
			}


			if($this->new_group){
				echo json_encode($this->newGroupName());
			}
			
		}


		private function newGroupName(){

			try{

				require_once("tools/connect.php");

				$connect = new connect();

				$dbh = $connect->returnConnection();

				$returnGroupName = $this->returnGroupName();

				$getGroupById = $this->getGroupById($returnGroupName);

				$returnNewGroupName = $this->returnNewGroupName();


				$stmt = $dbh->prepare("SELECT groep_naam FROM groep WHERE groep_naam=:groep_naam");

				$stmt->bindParam(":groep_naam", $returnNewGroupName);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$this->response['name'] = false;
				}else{
					$stmt = $dbh->prepare("UPDATE groep SET groep_naam=:groep_naam WHERE groep_id=:groep_id");

					$stmt->bindParam(":groep_naam", $returnNewGroupName);
					$stmt->bindParam(":groep_id", $getGroupById['groep_id']);

					$stmt->execute();

					if($stmt->rowCount() > 0){
						$this->response['updated'] = true;

						$stmt = $dbh->prepare("SELECT groep_naam FROM groep WHERE groep_id=:groep_id");

						$stmt->bindParam(":groep_id", $getGroupById['groep_id']);

						$stmt->execute();

						if($stmt->rowCount() > 0){
							$res = $stmt->fetch(PDO::FETCH_ASSOC);

							$this->response['new_name'] = base64_encode($res['groep_naam']);

							// header("Location: GetGroup.php?group=".base64_encode($res['groep_naam']));
							// exit();
						}else{
							$this->response['new_name'] = "not found!";
						}

					}else{
						$this->response['updated'] = false;
					}

					}

				

				return $this->response;

			}catch(PDOException $e){
				return $e->getMessage();
			}

		}



		private function addMember(){

			try{

				require_once("tools/connect.php");

				$connect = new connect();

				$dbh = $connect->returnConnection();

				$returnGroupMember = $this->returnGroupMember();

				$getMemberById = $this->getMemberById($returnGroupMember);

				$returnGroupName = $this->returnGroupName();

				$getGroupById = $this->getGroupById($returnGroupName);

				$stmt = $dbh->prepare("INSERT INTO koppeltabel (groep_id, student_id) VALUES(:groep_id, :student_id)");

				$stmt->bindParam(":groep_id", $getGroupById['groep_id']);

				$stmt->bindParam(":student_id", $getMemberById['student_id']);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$this->response['added'] = true;
				}else{
					$this->response['added'] = false;
				}


				return $this->response;

			}catch(PDOException $e){
				return $e->getMessage();
			}

		}

		private function removeMember(){

			try{

				require_once("tools/connect.php");

				$connect = new connect();

				$dbh = $connect->returnConnection();


				$getMemberById = $this->getMemberById();
				$getGroupById = $this->getGroupById();

				$stmt = $dbh->prepare("DELETE FROM koppeltabel WHERE groep_id=:groep_id AND student_id=:student_id");


				$stmt->bindParam(":groep_id", $getGroupById['groep_id']);
				$stmt->bindParam(":student_id", $getMemberById['student_id']);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$this->response['removed'] = true;
				}else{
					$this->response['removed'] = false;
				}

				return $this->response;

			}catch(PDOException $e){
				return $e->getMessage();
			}
			
		}


		private function getMemberById($memberName = ""){
			try{

				require_once("tools/connect.php");

				$connect = new connect();

				$dbh = $connect->returnConnection();

				$returnGroupMember;

				if(strlen($memberName) > 0){
					$returnGroupMember = $memberName;
				}else{
					$returnGroupMember = $this->returnGroupMember();
				}

				 

				$stmt = $dbh->prepare("SELECT student_id FROM student WHERE name=:name");

				$stmt->bindParam(":name", $returnGroupMember);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					return $stmt->fetch(PDO::FETCH_ASSOC);
				}else{
					return false;
				}

				return false;



			}catch(PDOException $e){
				return $e->getMessage();
			}
		}


		private function getGroupById($groupName = ""){
			try{

				require_once("tools/connect.php");

				$connect = new connect();

				$dbh = $connect->returnConnection();


				$returnGroupName;

				if(strlen($groupName) > 0){
					$returnGroupName = $groupName;
				}else{
					$returnGroupName = $this->returnGroupName();
				}


				$stmt = $dbh->prepare("SELECT groep_id FROM groep WHERE groep_naam=:name");

				$stmt->bindParam(":name", $returnGroupName);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					return $stmt->fetch(PDO::FETCH_ASSOC);
				}else{
					return false;
				}

				return false;



			}catch(PDOException $e){
				return $e->getMessage();
			}
		}


		public function GetGroup(){
			try{

				require_once("tools/connect.php");

				$connect = new connect();

				$dbh = $connect->returnConnection();

				$stmt = $dbh->prepare("SELECT groep_naam FROM groep");

				$stmt->execute();

				if($stmt->rowCount() > 0){

					return $stmt->fetchAll(PDO::FETCH_ASSOC);
				}else{
					return false;
				}
				return false;


			}catch(PDOException $e){
				return $e->getMessage();
			}
		}






		public function getGroupMemebers($group){
			try{

				require_once("tools/connect.php");

				$connect = new connect();

				$dbh = $connect->returnConnection();

				$stmt = $dbh->prepare("SELECT groep_id FROM groep WHERE groep_naam=:groep_naam");

				$stmt->bindParam(":groep_naam", $group);

				$stmt->execute();

				if($stmt->rowCount() > 0){

					$res = $stmt->fetch(PDO::FETCH_ASSOC);

					$groep_id = $res['groep_id'];

					$stmt = $dbh->prepare("SELECT student_id FROM koppeltabel WHERE groep_id=:groep_id");

					$stmt->bindParam(":groep_id", $groep_id);

					$stmt->execute();

					$memebrArray = array();

					if($stmt->rowCount() > 0){
						$memebers_id = $stmt->fetchAll(PDO::FETCH_ASSOC);


						$stmt = $dbh->prepare("SELECT name FROM student WHERE student_id=:student_id");

						foreach($memebers_id as $id){
							$stmt->bindParam(":student_id", $id['student_id']);

							$stmt->execute();

							if($stmt->rowCount() > 0){

								while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
									foreach($row as $memebers){
										echo "<div class='collection members'><a href='#!' class='collection-item'>".$memebers."</a></div>";
									}
								}


							


							}else{
								//echo "<h5>group has no members</h5>";
							}

						}



					}else{
						echo "<span>Deze groep bevat geen leden</span>";
					}



				}else{
					return "false";
				}
				return "false";


			}catch(PDOException $e){
				return $e->getMessage();
			}
		}


		public function getNewMembers($group){
			try{

				require_once("tools/connect.php");

				$connect = new connect();

				$dbh = $connect->returnConnection();

				$stmt = $dbh->prepare("SELECT groep_id FROM groep WHERE groep_naam=:groep_naam");

				$stmt->bindParam(":groep_naam", $group);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$res = $stmt->fetch(PDO::FETCH_ASSOC);

					$group_id = $res['groep_id'];


					$stmt = $dbh->prepare("SELECT name, student_id FROM student WHERE student_id NOT IN(SELECT student_id FROM koppeltabel WHERE groep_id=:groep_id)");

					$stmt->bindParam(":groep_id", $group_id);
					$stmt->execute();
					if($stmt->rowCount() > 0){

						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						echo "<h5>Nieuwe leden</h5><h6>Klik op leden om aan groep toe te voegen</h6>";
						foreach($result as $res){
							echo "<div class='collection new_members'><a href='#!' class='collection-item'>".$res['name']."</a></div>";
						}

					}else{
						echo "<h5>Dese groep bevat alle beschikbare leden</h5>";
					}

				}else{
					return "oepsieee";
				}


			}catch(PDOException $e){
				return $e->getMessage();
			}
		}

		public function delete_group($group_name){
			try{

				$trimmed = trim($group_name);

				if(!empty($trimmed)){
					$getGroupById = $this->getGroupById($trimmed);

					$this->connect = new connect();

					$dbh = $this->connect->returnConnection();

					$dbh->beginTransaction();

					$stmt = $dbh->prepare("DELETE FROM groep WHERE groep_id=:groep_id");
					$stmt->bindParam(":groep_id", $getGroupById['groep_id']);
					$stmt->execute();
					$stmt = $dbh->prepare("DELETE FROM koppeltabel WHERE groep_id=:groep_id");
					$stmt->bindParam(":groep_id", $getGroupById['groep_id']);
					$stmt->execute();
					$stmt = $dbh->prepare("DELETE FROM module_koppel WHERE groep_id=:groep_id");
					$stmt->bindParam(":groep_id", $getGroupById['groep_id']);
					$stmt->execute();
					$dbh->commit();

					// $stmt = $dbh->prepare("DELETE FROM groep WHERE groep_id=:groep_id");

					// $stmt->bindParam(":groep_id", $getGroupById['groep_id']);

					// $stmt->execute();

					// if($stmt->rowCount() > 0){
					// 	$stmt = $dbh->prepare("DELETE FROM koppeltabel WHERE groep_id=:groep_id");

					// 	$stmt->bindParam(":groep_id", $getGroupById['groep_id']);
 
					// 	$stmt->execute();

					// 	if($stmt->rowCount() > 0){
					// 		$stmt = $dbh->prepare("DELETE FROM module_koppel WHERE groep_id=:groep_id");

					// 		$stmt->bindParam(":groep_id", $getGroupById['groep_id']);

					// 		$stmt->execute();

					// 		if($stmt->rowCount() > 0){
					// 			$this->response['groep_deleted'] = true;
					// 		}else{
					// 			$this->response['groep_deleted'] = false;
					// 		}
					// 	}
					// }else{
						
					// }

					// return $this->response;
				}else{
					return false;
				}

				

			}catch(PDOException $e){
				return $e->getMessage();
			}
		}


		private function returnGroupName(){
			return trim($this->groupName);
		}
		private function returnGroupMember(){
			return $this->groupmember;
		}

		private function returnNewGroupName(){
			return $this->new_group_name;
		}
	}
	new GetGroup();
?>
<?php 
	
	/**
	* Add or delete new module
	*/

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	class NEWMODULE{

		function __construct(){

			require_once("connect.php");

			echo json_encode($this->getAllModulesFromDb());

		}


		private function getDirectory(){


			$path = '../../../modules';

				$dirs = array();

				// directory handle
				$dir = dir($path);

				while (false !== ($entry = $dir->read())) {
				    if ($entry != '.' && $entry != '..') {
				       if (is_dir($path . '/' .$entry)) {
				            $dirs[] = $entry; 
				       }
				    }
				}


				return $dirs;

		}



		private function getAllModulesFromDb(){
			try{
				$this->removeFromDb();
				$response = array();
				
				$connect = new connect();

				$dbh = $connect->returnConnection();

				$directory = $this->getDirectory();


				$stmt = $dbh->prepare("SELECT * FROM module");

				$stmt->execute();

				$temp = array();

				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				foreach($result as $res){
					array_push($temp, $res['module_locatie']);
				}				

				$removed = false;

				$match = array_diff($directory, $temp);

				$stmt = $dbh->prepare("INSERT INTO module (module_locatie, module_status) 
						VALUES(:module_locatie, :module_status)");
					
				$module_status = 0;
				foreach($match as $dir){
					
					$stmt->bindParam(":module_locatie", $dir);
					$stmt->bindParam(":module_status", $module_status);
					

					$stmt->execute();

					if($stmt->rowCount() > 0){

						$response['added'] = true;
						$response['newdir'] = $dir;

					}else{
						$response['added'] = false;
					}
				}

				return $response;
				

			}catch(PDOException $e){
				return $e->getMessage();
			}
		}


		private function removeFromDb(){
			try{

				$response = array();

				$connect = new connect();

				$dbh = $connect->returnConnection();


				$stmt = $dbh->prepare("SELECT * FROM module");
				$stmt->execute();

				$temp = array();

				if($stmt->rowCount() > 0){
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					foreach($result as $res){
						array_push($temp, $res['module_locatie']);
					}

				}

				$getDirectory = $this->getDirectory();

				$diff = array_diff($temp, $getDirectory);



				$stmt = $dbh->prepare("DELETE FROM module WHERE module_locatie=:module_locatie");

				foreach($diff as $_diff){
					$stmt->bindParam(":module_locatie", $_diff);
				}

				$stmt->execute();

				if($stmt->rowCount() > 0){

					$response['removed'] = true;
				}else{
					$response['removed'] = false;
				}


				return $response;

			}catch(PDOException $e){
				return $e->getMessage();

			}
		}

		private function newDirrAdded($dirname){
			return $dirname;
		}


		// private function NEWMODULE(){
		// 	try{


		// 		require_once("connect.php");
		// 		$connect = new connect();

		// 		$dbh = $connect->returnConnection();

		// 		$directory = $this->getDirectory();

		// 		if(!empty($directory)){
		// 			$stmt = $dbh->prepare("INSERT INTO module (module_locatie, module_status) VALUES(:module_locatie, :module_status)");

		// 			$status = 0;
		// 			$stmt->bindParam(":module_status", $status);

		// 			foreach($directory as $dir){
		// 				$stmt->bindParam(":module_locatie", $dir);

		// 				$stmt->execute();

		// 				if($stmt->rowCount() > 0){
		// 					return true;
		// 				}else{
		// 					return false;
		// 				}
		// 			}
		// 		}else{
		// 			return false;
		// 		}

		// 		return false;

		// 	}catch(PDOException $e){
		// 		return $e->getMessage();
		// 	}
		// }
	
	}


	new NEWMODULE();
?>
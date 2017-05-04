<?php 

	
	class getStudents{

		// private $studentArray;

		// public function __construct(){
		// 	$this->studentArray = array();

		// }

		public function getStudents(){

			try{


				require_once("tools/connect.php");

				$connect = new connect();

				$dbh = $connect->returnConnection();

				$stmt = $dbh->prepare("SELECT name FROM student");

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
					return $res;
				}else{
					return false;
				}

				return false;

			}catch(PDOException $e){
				return $e->getMessage();
			}

		}
	}


?>
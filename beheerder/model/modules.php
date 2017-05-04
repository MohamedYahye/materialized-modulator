<?php 
	
	class Modules{

		private $modules;
		private $proceed;
		private $moduleName;
		private $connect;

		public function __construct(){
			$this->connect = null;
			$this->proceed = false;
		}


		public function Modules(){
			try{
				require_once('tools/connect.php');

				$this->connect = new connect();

				$dbh = $this->connect->returnConnection();

				$stmt = $dbh->prepare("SELECT * FROM module");
				$stmt->execute();

				if($stmt->rowCount() > 0){
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

					return $result;
				}else{
					return false;
				}
			}catch(PDOException $e){
				return $e->getMessage();
			}

		}




	}


	new Modules();


?>
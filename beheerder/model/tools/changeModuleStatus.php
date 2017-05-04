<?php 
	
	/**
	* change module status
	*/
	class CHNAGEMDOULESTATUS {
		
		private $module_name;
		private $status;
		private $proceed;
		private $connect;

		function __construct() {

			$this->proceed = false;
			$this->connect = null;

			if(!empty(isset($_POST['change_module']))){
				if(!empty(isset($_POST['module_name']))){
					$this->module_name = trim($_POST['module_name']);
					$this->status = $_POST['module_status'];
					echo json_encode($this->CHNAGEMDOULESTATUS());
				}
			}
		}


		private function CHNAGEMDOULESTATUS(){
			try{
				require_once("connect.php");

				$this->connect = new connect();

				$dbh = $this->connect->returnConnection();

				$stmt = $dbh->prepare("UPDATE module SET module_status=:module_status WHERE module_locatie=:module_locatie");

				$stmt->bindParam(":module_status", $this->status);
				$stmt->bindParam(":module_locatie", $this->module_name);

				$stmt->execute();
				if($stmt->rowCount() > 0){
					$this->response['changed'] = true;
				}else{
					$this->response['changed'] = false;
				}

				return $this->response;

			}catch(PDOException $e){
				return $e->getMessage();
			}
		}
	}

	new CHNAGEMDOULESTATUS();

?>
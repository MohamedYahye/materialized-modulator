<?php 
	


	class CONNECT{


		private $conn;
		private $username;
		private $password;
		private $server;

		function __construct() {
			$this->conn = null;
			$this->username = "";
			$this->password = "";
			$this->server = "mo-.nl";

			$this->connect();
			
		}


		public function connect(){

			try{
				$this->conn = new PDO('mysqldbname=', $this->username, $this->password);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e) {
			    echo 'ERROR: ' . $e->getMessage();
			}
			

		}


		public function returnConnection(){
			return $this->conn;
		}


		public function closeConnection(){
			return $this->conn = null;
		}

	}

?>

<?php 
	
	class UpdateStudent{

		private $currentname;
		private $name;
		private $userName;
		private $email;
		private $password;
		private $opleiding;
		private $leerjaar;
		private $uitstroom;
		private $ov_nummer;

		private $connect;
		private $proceed;
		private $response;
		private $hash;

		public function __construct(){
			$this->connect = null;
			$this->proceed = false;
			$this->response = array();

			require_once("tools/connect.php");

			if(!empty(isset($_POST))){

				if(!empty($_POST['current_name'])){
					$this->currentname = $_POST['current_name'];
					$this->proceed = true;
				}else{
					$this->proceed = false;
				}

				if(!empty($_POST['name'])){
					$this->name = $_POST['name'];
					$this->proceed = true;
				}else{
					$this->proceed = false;
				}

				if(!empty($_POST['username'])){
					$this->userName = $_POST['username'];
					$this->proceed = true;
				}else{
					$this->proceed = false;
				}
				if(!empty($_POST['password'])){
					$this->password = $_POST['password'];
					$this->proceed = true;
				}else{
					$this->proceed = false;
				}

				if(!empty($_POST['email'])){
					$this->email = $_POST['email'];
					$this->proceed = true;
				}else{
					$this->proceed = false;
				}
				if(!empty($_POST['opleiding'])){
					$this->opleiding = $_POST['opleiding'];
					$this->proceed = true;
				}else{
					$this->proceed = false;
				}

				if(!empty($_POST['leerjaar'])){
					$this->leerjaar = $_POST['leerjaar'];
					$this->proceed = true;
				}else{
					$this->proceed = false;
				}
				if(!empty($_POST['uitstroom'])){
					$this->uitstroom = $_POST['uitstroom'];
					$this->proceed = true;
				}else{
					$this->proceed = false;
				}

				if(!empty($_POST['ov_nummer'])){
					$this->ov_nummer = $_POST['ov_nummer'];
					$this->proceed = true;
				}else{
					$this->proceed = false;
				}


			}else{
				$this->proceed = false;
			}


			if($this->proceed){

				echo json_encode($this->UpdateStudent());
			}
		

		}


		private function contains(){
			$haystack = $this->returnPassword();
			$needle = "$2a$10$";

			return strpos($haystack, $needle) !== false;
		}


		private function is_array_any($needles, $haystack){
			return (bool)array_intersect($needles, $haystack);
		}


		private function UpdateStudent(){

			try{


				$userName = $this->returnUsername();
				$name = $this->returnName();
				$ov_nummer = $this->returnOv_nummer();
				$email = $this->returnEmail();
				$opleiding = $this->returnOpleiding();
				$leerjaar = $this->returnLeerjaar();
				$uitstroom = $this->returnUitstroom();

				$current_name = $this->returnCurrentName();

				$userid = $this->getStudentById();


				$continue = true;


				require_once("tools/hash.php");
				$this->connect = new connect();

				$dbh = $this->connect->returnConnection();


				$stmt = $dbh->prepare("SELECT ov_nummer, name, username, email FROM student WHERE
					student_id!=:student_id");
				$stmt->bindParam(":student_id", $userid['student_id']);

				$stmt->execute();

				if($stmt->rowCount() > 0){

					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


					foreach($result as $res){
						if($res['ov_nummer'] ==  $ov_nummer){
							$continue = false;
						}

						if($res['name'] == $name){
							$continue = false;
						}

						if($res['username'] == $userName){
							$continue = false;
						}
						if($res['email'] == $email){
							$continue = false;
						}
					}



					if($continue){

						$newPass;

						$passChanged = $this->contains();

						if($passChanged){

							$newPass = $this->returnPassword();

						}else{

							$this->hash = Bcrypt::hashPassword($this->returnPassword());


							$newPass = $this->hash;
						}



						$stmt = $dbh->prepare("UPDATE student SET ov_nummer=:ov_nummer, username=:username, name=:name, email=:email, password=:password, opleiding=:opleiding, leerjaar=:leerjaar, uitstroom=:uitstroom WHERE name=:current_name");

						$stmt->bindParam(":name", $name);
						$stmt->bindParam(":username", $userName);
						$stmt->bindParam(":password", $newPass);
						$stmt->bindParam(":email", $email);
						$stmt->bindParam(":ov_nummer", $ov_nummer);
						$stmt->bindParam(":opleiding", $opleiding);
						$stmt->bindParam("leerjaar", $leerjaar);
						$stmt->bindParam(":uitstroom", $uitstroom);
						$stmt->bindParam(":current_name", $current_name);

						$stmt->execute();

						if($stmt->rowCount() > 0){

							$last_inserted = $this->getStudentById();

							$stmt = $dbh->prepare("SELECT name FROM student WHERE student_id=:student_id");

							$stmt->bindParam(":student_id", $userid['student_id']);

							$stmt->execute();

							if($stmt->rowCount() > 0){
								$res = $stmt->fetch(PDO::FETCH_ASSOC);

								$this->response['update'] = array("update"=>true, "newname"=>$res['name']);
							}


							
						}else{
							$this->response['update'] = array("update"=>false);
						}

						


					}else{
						$this->response['values'] = "in use";
					}

				}else{
					$this->response['oeps'] = "something went wrong";
				}


				

				return $this->response;

			}catch(PDOException $e){
				return $e->getMessage();
			}


		}



		private function getStudentById(){
			try{

				$returnCurrentName = $this->returnCurrentName();

				$this->connect = new connect();

				$dbh = $this->connect->returnConnection();

				$student_id;

				$stmt = $dbh->prepare("SELECT student_id FROM student WHERE name=:name");

				$stmt->bindParam(":name", $returnCurrentName);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$student_id = $stmt->fetch(PDO::FETCH_ASSOC);

					return $student_id;
				}else{
					return false;
				}

				return false;



			}catch(PDOException $e){
				return $e->getMessage();
			}
		}

		private function getAllstudents(){
			try{

				$this->connect = new connect();
				$dbh = $this->connect->returnConnection();

				$studentArray = array();

				$student_id = $this->getStudentById();

				$stmt = $dbh->prepare("SELECT ov_nummer, name, username, email FROM student WHERE student_id!=:id");

				$stmt->bindParam(":id", $student_id['student_id']);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$studentArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
					return $studentArray;
				}else{
					return false;
				}

				return false;


			}catch(PDOException $e){
				return $e->getMessage();
			}
		}


		private function returnCurrentName(){
			return trim($this->currentname);
		}
		private function returnOv_nummer(){
			return $this->ov_nummer;
		}
		private function returnName(){
			return $this->name;
		}
		private function returnUsername(){
			return $this->userName;
		}
		private function returnEmail(){
			return $this->email;
		}
		private function returnPassword(){
			return $this->password;
		}
		private function returnOpleiding(){
			return $this->opleiding;
		}
		private function returnLeerjaar(){
			return $this->leerjaar;
		}
		private function returnUitstroom(){
			return $this->uitstroom;
		}


	}

	new UpdateStudent();


?>
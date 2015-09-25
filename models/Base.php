<?php
	class BaseModel{
		private $url = "localhost";
		private $params = "";

		private $dbh;

		public function __construct(){
			
			try{
				$this->dbh = new PDO('mysql:dbname=sek;host=localhost', 'testsek', '');
			}catch(PDOException $e){
				echo "Error: Could not connect".$e->getMessage();
			}
		}

		public function getDbh(){
			return $this->dbh;
		}

		
	}
?>
<?php
	class BaseCollection{
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

		public function getUrl(){
			return $this->url;
		}

		public function setUrl($url){
			if( isset($url) ){
				$this->url = url;
			}
		}

		public function getParams(){
			return $this->params;
		}

		public function setParams($params){
			if( isset($params) ){
				$this->params = $params;
			}
		}

		public function fetch($page, $type){
		}
	}
?>
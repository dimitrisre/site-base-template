<?php
	
	class GeneralCollection extends BaseCollection{
		private $type = "";

		public function __construct($type){
			parent::__construct();
			$this->type = $type;
		}

		public function getType(){
			return $this->type;
		}

		public function setType($type){
			$this->type = $type;
		}

		public function fetch($page){
			$dbh = $this->getDbh();
			$type = $this->type;

			$nextPage = $page+1;
			$pageSize = 10;
			$where = "";
			if( $type == "tar" ){
				$from = $page*$pageSize;
				$to = $nextPage*$pageSize;
				$where = "WHERE back2='tar'";
			}else{
				$from = 1;
				$to = 30;
				$where = "WHERE back2='general'";
			}

			$generalSpecs = array("general" => array());

			$sth = $dbh->prepare("SELECT id, link, title, img, back1, back2 FROM general $where ORDER BY back1 DESC LIMIT $from , $to");

			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_OBJ)){
				array_push($generalSpecs["general"],$row);
			}
			
			return $generalSpecs;
		}
		public function save($general){
			$dbh = $this->getDbh();

			$sth = $dbh->prepare("INSERT INTO general ( link, title ,img, back2 ) VALUES ( :link,:title,:img,:back2 )");

			$link = $general["link"];
			$title = $general["title"];
			$img = $general["img"];
			$type = $general["type"];

			$sth->bindParam(":link",$link);
			$sth->bindParam(":title",$title);
			$sth->bindParam(":img",$img); 
			$sth->bindParam(":back2",$type);

			$res = true;
			$sth->execute() or $res=false;
			
			return $res;
		}

		public function update($general){
			$dbh = $this->getDbh();

			$sth = $dbh->prepare("UPDATE general SET link=:link, title=:title , back1=:back1, back2=:type  WHERE id=:id");

			$id = $general["id"];
			$link = $general["link"];
			$title = $general["title"];
			$back1 = $general["back1"];
			$type = $general["type"];

			$sth->bindParam(":id",$id);
			$sth->bindParam(":link",$link);
			$sth->bindParam(":title",$title);
			$sth->bindParam(":back1",$back1); 
			$sth->bindParam(":type",$type);

			$res = true;
			$sth->execute() or $res=false;
			
			return $res;
		}

		public function delete($id){
			$dbh = $this->getDbh();

			$sth = $dbh->prepare("DELETE from general WHERE id = :id");

			$sth->bindParam(":id",$id);
			
			$res = true;
			$sth->execute() or $res=false;
			
			return $res;
		}


	}
?>
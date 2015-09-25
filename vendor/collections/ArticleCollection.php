<?php
	
	class ArticleCollection extends BaseCollection{
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

		public function fetch($page, $type=""){
			$dbh = $this->getDbh();
			
			if(!isset($this->type)){
				return null;
			}

			$nextPage = $page + 1;
			$pageSize = 5;

			$from = $page*$pageSize;
			$to = $nextPage*$pageSize;

			$articleSpecs = array("articles" => array());

			$sth = $dbh->prepare("SELECT id,type,src,title,body,img,date FROM articles WHERE type = :type ORDER BY id DESC LIMIT $from, $pageSize");
			$sth->bindParam(':type', $this->type);
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				// $row["body"] = mb_convert_encoding(strip_tags($row["body"]), 'UTF-8', 'UTF-8');
				$row["body"] = mb_substr(strip_tags($row["body"]), 0, 300, 'UTF-8');
				array_push($articleSpecs["articles"],$row);
			}
			
			return $articleSpecs;
		}

		public function fetchAll(){
			$dbh = $this->getDbh();
			
			$articleSpecs = array("articles" => array());

			$sth = $dbh->prepare("SELECT id,type,src,title,body,img,date FROM articles ORDER BY id");
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				// $row["body"] = mb_convert_encoding(strip_tags($row["body"]), 'UTF-8', 'UTF-8');
				$row["body"] = strip_tags($row["body"]);
				array_push($articleSpecs["articles"],$row);
			}
			
			return $articleSpecs;
		}

		public function search($term){
			$dbh = $this->getDbh();

			$upperTerm = mb_strtoupper($term,'UTF-8');
			$upperTerm = "%".$upperTerm."%";

			$lowerTerm = mb_strtolower($term,'UTF-8');
			$lowerTerm = "%".$lowerTerm."%";

			$firstUpperTerm = mb_strtoupper(mb_substr($term, 0, 1,'UTF-8'),'UTF-8') . mb_substr($term, 1, mb_strlen($term), 'UTF-8');
			$firstUpperTerm = "%".$firstUpperTerm."%";

			$firstLowerTerm = mb_strtolower(mb_substr($term, 0, 1,'UTF-8'),'UTF-8') . mb_substr($term, 1, mb_strlen($term), 'UTF-8');
			$firstLowerTerm = "%".$firstLowerTerm."%";

			$term = "%".$term."%";

			$articleSpecs = array( "articles" => array() );

			$sth = $dbh->prepare("SELECT id,type,src,title,body,img,date FROM articles WHERE ". 
				"(title LIKE :term OR body LIKE :term) OR ". 
				"(title LIKE :upperTerm OR body LIKE :upperTerm) OR ". 
				"(title LIKE :lowerTerm OR body LIKE :lowerTerm) OR ". 
				"(title LIKE :firstUpperTerm OR body LIKE :firstUpperTerm) OR ". 
				"(title LIKE :firstLowerTerm OR body LIKE :firstLowerTerm) ORDER BY id DESC");

			//$sth->bindParam("ssssssssss",$term, $term, $upperTerm, $upperTerm, $lowerTerm, $lowerTerm, $firstUpperTerm, $firstUpperTerm, $firstLowerTerm, $firstLowerTerm);
			$sth->bindParam(':term',$term);
			$sth->bindParam(':upperTerm',$upperTerm);
			$sth->bindParam(':lowerTerm',$lowerTerm);
			$sth->bindParam(':firstUpperTerm',$firstUpperTerm);
			$sth->bindParam(':firstLowerTerm',$firstLowerTerm);

			$sth->execute();
			
			while($row = $sth->fetch(PDO::FETCH_OBJ)){
				// $result = array("id" => $aId, 
				// 	"type" => $type,
				// 	"src"  => $src,
				// 	"title"=> strip_tags($title),
				// 	"body" => strip_tags($body),
				// 	"img"  => $img,
				// 	"date" => $date);

				array_push($articleSpecs["articles"], $row);
			}
			
			return  $articleSpecs;
		}
	}
?>
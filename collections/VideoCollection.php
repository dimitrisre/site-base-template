<?php
	class VideoCollection extends BaseCollection{
		public function fetch($page){
			$dbh = $this->getDbh();
			
			$nextPage = $page+1;
			$pageSize = 10;

			$from = $page*$pageSize;
			$to = $nextPage*$pageSize;

			$videoSpecs = array( "videos" => array() );

			$sth = $dbh->prepare("SELECT id, type, src, title FROM videos ORDER BY id DESC LIMIT $from, $to");
			
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_OBJ)){
				array_push($videoSpecs["videos"], $row);
			}
						
			return  $videoSpecs;
		}

		public function save($videos){
			$dbh = $this->getDbh();

			$res = true;
			$sth = $dbh->prepare("INSERT INTO videos ( type, src ,title ) VALUES ( :type,:src,:title )");
			
			$sth->bindParam(':type', $type);
			$sth->bindParam(':src', $src);
			$sth->bindParam(':title', $title);

			foreach ($videos as $v) {
				print_r($v);
				$type  = $v["type"];
				$src   = $v["src"];
				$title = $v["title"];

				
				$sth->execute() or $res=false;
				if( !$res ){
					break;
				}	
			}
			
			return $res;
		}
	}
?>
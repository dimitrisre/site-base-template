<?php
	class AlbumModel extends BaseModel{
		public function fetch($aid){
			$dbh = $this->getDbh();

			$sth = $dbh->prepare("SELECT id, title, path, comment, date FROM photo_album WHERE id = :aid");
			$sth->bindParam(":aid", $aid);			
			$sth->execute();

			$row = $sth->fetch(PDO::FETCH_OBJ);
			$albumId = $row->id;

			$results = array("id" => $row->id,
				"title"   => $row->title,
				"path"    => $row->path,
				"comment" => $row->comment,
				"date" 	  => $row->date,
				"photos"  => array()
				);

			$sth1 = $dbh->prepare("SELECT id, title, src, comment, date FROM photos WHERE album_id = :albumId");
			$sth1->bindParam(":albumId", $albumId);			
			$sth1->execute();

			while($row = $sth1->fetch(PDO::FETCH_OBJ)){
				array_push($results["photos"],$row);
			}
			// var_dump($results["photos"]);
			return $results;
		}

		public function put($albumJson){
			$dbh = $this->getDbh();

			$sth = $dbh->prepare("INSERT INTO photo_album ( title, path, comment ) VALUES ( :title, :path, :comment )");
	
			$res = true;

			$title = $albumJson["title"];
			$path = $albumJson["path"];
			$comment = $albumJson["comment"];

			$sth->bindParam(":title",$title);			
			$sth->bindParam(":path",$path);			
			$sth->bindParam(":comment",$comment);
			
			$sth->execute( ) or $res=false;
			
			return $res;
		}

		public function putPhoto($photoJson){
			$dbh  = $this->getDbh();

			$sth = $dbh->prepare("INSERT INTO photos ( src, title, comment, album_id ) VALUES ( :src, :title, :comment, :album_id )");
			
			$src = $photoJson["src"];
			$title = $photoJson["title"];
			$comment = $photoJson["comment"];
			$album_id = $photoJson["album_id"];

			$sth->bindParam(":src",$src);
			$sth->bindParam(":title",$title);
			$sth->bindParam(":comment",$comment);
			$sth->bindParam(":album_id",$album_id);
			
			$res = true;
			$sth->execute( ) or $res=false;
			
			return $res;
		}

		public function getAlbumId($title){
			$dbh = $this->getDbh();

			$sth = $dbh->prepare("SELECT id FROM photo_album WHERE title=:title");
			
			$sth->bindParam(":title", $title );
			
			$sth->execute( ) or die("Could not execute statement");
			
			$row = $sth->fetch(PDO::FETCH_ASSOC);
			
			$id = $row["id"];

			return $id;
		}
	}
?>
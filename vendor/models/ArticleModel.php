<?php
	class ArticleModel extends BaseModel{
		public function fetch($aid){
			$dbh = $this->getDbh();

			$sth = $dbh->prepare("SELECT id,type,src,title,body,img,date FROM articles where id = :aid");
			$sth->bindParam(":aid", $aid);			
			$sth->execute();

			$result = $sth->fetch(PDO::FETCH_OBJ);
			
			return  $result;
		}
		public function save($article){
			$dbh = $this->getDbh();
			$sth = $dbh->prepare("INSERT INTO articles ( type,src,title,body,img ) VALUES ( :type,:src,:title,:body,:img )");
			
			$type = $article["type"];
			$src = $article["src"];
			$title = $article["title"];
			$body = $article["body"];
			$img = $article["img"];

			$sth->bindParam(":type",$type); 
			$sth->bindParam(":src",$src); 
			$sth->bindParam(":title",$title); 
			$sth->bindParam(":body",$body); 
			$sth->bindParam(":img",$img);

			$res = true;
			$sth->execute( ) or $res=false;
			
			return $res;
		}
		public function update($article){
			$dbh=$this->getDbh();
			$sth = $dbh->prepare("UPDATE articles SET type=:type,src=:src,title=:title,body=:body WHERE id=:id ");
			
			$type = $article["type"];
			$src = $article["src"];
			$title = $article["title"];
			$body = $article["body"];
			$img = $article["img"];
			$id = $article["id"];

			$sth->bindParam(":type",$type); 
			$sth->bindParam(":src",$src); 
			$sth->bindParam(":title",$title); 
			$sth->bindParam(":body",$body); 
			$sth->bindParam(":id",$id);
			
			$res = true;
			$sth->execute( ) or $res=false;
			
			return $res;
		}
	}
?>
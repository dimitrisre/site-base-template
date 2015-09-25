<?php
	class ScrollerCollection extends BaseCollection{
		private $path;
		
		public function __construct($path="data/scroller_list.json"){
			$this->path = $path;
		}

		public function fetch(){
			// $file = "data/scroller_list.json";

			$json = file_get_contents( $this->path );
			
			return json_decode($json,true);
		}

		public function save($json){
			if ( !file_put_contents($this->path, $json) ){
				return false; 
			}
			return true;
		}
	}
?>
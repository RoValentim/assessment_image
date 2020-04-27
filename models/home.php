<?php
	class home extends models {
		public function render() {
			$file = $_SERVER["DOCUMENT_ROOT"] . "/views/home.html";

			$handle = fopen( $file, "r" );
			$page = fread( $handle, filesize($file) );
			fclose( $handle );

			header("Content-Type: text/html; charset=utf-8");
			echo $page;
		}
	}
?>
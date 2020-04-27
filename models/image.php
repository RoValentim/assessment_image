<?php
	class image extends models {
		private $errorImageNotFound = "Error: Image not found.";

		public function render( $clienId, $imageHash ) {
			$file = $_SERVER["DOCUMENT_ROOT"] . "/public/images/" . $clienId . "/" . $imageHash;

			if( !file_exists($file) ) {
				header("Content-Type: text/plain");
				echo $this->errorImageNotFound;
				die();
			}

			$handle = fopen( $file, "r" );
			$image = fread( $handle, filesize($file) );
			fclose( $handle );

			$imageData = $this->returnExtensionFromBase64( $image );
			$mimeExt = $imageData[0];

			header("Content-Type: image/" . $mimeExt);

			$imgInfo = explode(",", $image, 2);
			echo base64_decode($imgInfo[1]);
		}
	}
?>
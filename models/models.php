<?php
	class models {
		protected $resp = ["originalName" => null, "hash" => null, "link" => null, "status" => "processing"];

		protected function getLink( $clientId, $fileHash ) {
			return "http://" . $_SERVER["SERVER_NAME"] . ($_SERVER["SERVER_PORT"]==80 ? "/" : ":".$_SERVER["SERVER_PORT"]."/") . "images/" . $clientId . "/" . $fileHash;
		}

		protected function returnExtensionFromBase64($data) {
			$imgInfo = explode(";", substr($data, 5), 2);
			$mime = $imgInfo[0];

			$mimeExt = substr($imgInfo[0], 6);
			$image = trim( substr($imgInfo[1], 7) );

			return array($mimeExt, $image);
		}
	}
?>
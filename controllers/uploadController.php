<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/upload.php');

	class uploadController extends controller {
		public function do() {
			if( $_SERVER["REQUEST_METHOD"] != "POST" ) {
				$this->returnValue($this->methodNotAllowed);
				die();
			}

			$this->getData();

			if( !array_key_exists("clientId", $this->jsonData) || !array_key_exists("images", $this->jsonData) ) {
				$this->returnValue($this->errorProtocol);
				die();
			}

			$ret = array("images" => array());
			$call = new upload( $this->jsonData["clientId"] );

			foreach( $this->jsonData["images"] as $singleImage) {
				if(array_key_exists("base64", $singleImage))
					$retImage = $call->uploadByBase64( $singleImage );
				else if(array_key_exists("link", $singleImage))
					$retImage = $call->uploadByLink( $singleImage["link"] );
				else
					continue;

				array_push($ret["images"], $retImage);
			}

			$this->returnValue($ret);
		}
	}
?>
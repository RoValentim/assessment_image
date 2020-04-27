<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/image.php');

	class imageController extends controller {
		public function do($clientId, $imageHash) {
			if( $_SERVER["REQUEST_METHOD"] != "GET" ) {
				$this->returnValue($this->methodNotAllowed);
				die();
			}

			$call = new image();
			$call->render($clientId, $imageHash);
		}
	}
?>
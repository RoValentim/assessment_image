<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/home.php');

	class homeController extends controller {
		public function do() {
//			if( $_SERVER["REQUEST_METHOD"] != "GET" ) {
//				$this->returnValue($this->methodNotAllowed);
//				die();
//			}

			$call = new home();
			$ret = $call->render();
		}
	}
?>
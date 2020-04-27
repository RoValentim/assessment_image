<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/search.php');

	class searchController extends controller {
		public function do() {
			if( $_SERVER["REQUEST_METHOD"] != "POST" ) {
				$this->returnValue($this->methodNotAllowed);
				die();
			}

			$this->getData();

			if( !array_key_exists("clientId", $this->jsonData) || !array_key_exists("search", $this->jsonData) ) {
				$this->returnValue($this->errorProtocol);
				die();
			}

			$call = new search( $this->jsonData["clientId"] );
			$ret = $call->searchImages( $this->jsonData["search"] );
			$this->returnValue($ret);
		}
	}
?>
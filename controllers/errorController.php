<?php
	class errorController extends controller {
		public function do() {
			$this->returnValue($this->pageNotFound);
			die();
		}
	}
?>
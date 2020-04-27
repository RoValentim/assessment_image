<?php
	class router {
		private $resource;

		public function do() {
			$this->parse($_SERVER["REQUEST_URI"]);
			$controller = $this->setController();

			call_user_func_array([$controller, "do"], $this->resource->params);
		}

		private function parse($url) {
			$explode_url = explode('/', trim($url));

			@$uri->controller = $explode_url[1];
			$uri->params = array_slice($explode_url, 2);

			switch($uri->controller) {
				case "upload-image":
					$uri->controller = "upload";
					break;
				case "search-image":
					$uri->controller = "search";
					break;
				case "images":
					$uri->controller = "image";
					break;
				default:
					if(empty($uri->controller))
						$uri->controller = "home";
					break;
			}

			$this->setResource($uri);
		}

		public function setResource($value) {
			$this->resource = $value;
		}

		public function setController() {
			$name = $this->resource->controller . "Controller";
			$file = $_SERVER["DOCUMENT_ROOT"] . '/controllers/' . $name . '.php';

			if( !file_exists($file) ) {
				$name = "errorController";
				$file = $_SERVER["DOCUMENT_ROOT"] . '/controllers/' . $name . '.php';
			}

			require_once($file);
			$controller = new $name();
			return $controller;
		}
	}
?>
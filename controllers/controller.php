<?php
	class controller {
		protected $jsonData;

		protected $errorProtocol = ["Error" => "Data protocol mismatch."];
		protected $methodNotAllowed = ["Error" => "Method not allowed."];
		protected $pageNotFound = ["Error" => "Page not found."];

		protected function getData() {
			$request_headers = getallheaders();
			$json = '';

			if( isset($request_headers['X-FILENAME']) && isset($request_headers['X-CLIENT-ID']) ) {
				$cliendId = $request_headers['X-CLIENT-ID'];
				$toJSON = array("clientId" => $cliendId, "images" => array());

				foreach ($_FILES as $value) {
					$originalName = $value["name"];
					$file = file_get_contents( $value["tmp_name"] );
					$base64Image = base64_encode($file);
					$base64Image = 'data:'.$value["type"].';base64,'.$base64Image;

					$jsonImages = array("originalName" => $originalName, "base64" => $base64Image);
					array_push($toJSON["images"], $jsonImages);
				}

				$json = json_encode($toJSON, JSON_FORCE_OBJECT);
			} else {
				$jsonString = file_get_contents('php://input');
				$json = utf8_encode($jsonString);
			}

			$this->jsonData = json_decode($json, true);
		}

		protected function returnExtensionFromBase64($data) {
			$imgInfo = explode(";", substr($data, 5), 2);
			$mime = $imgInfo[0];

			return substr($imgInfo[0], 6);
		}

		protected function returnValue($value) {
			header("Content-Type: application/json");
			echo json_encode($value);
		}
	}
?>
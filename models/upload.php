<?php
	class upload extends models {
		private $clientId;
		private $image;

		private $allowedFormats = ["jpe", "jpeg", "jpg", "jtif", "png", "gif", "bmp"];
		private $imgHashType = "adler32";
		private $imgMaxSize = "5242880";

		private $errorFormatNotAllowed = "Error: Image format not allowed.";
		private $errorImageNotFound = "Error: Image not found.";
		private $errorImageTooBig = "Error: Image size is too big.";

		public function __construct( $clientId ) {
			$this->clientId = $clientId;
		}

		public function uploadByBase64( $data ) {
			$nameOriginal = $data["originalName"];
			$base64Image = $data["base64"];
			$this->resp["originalName"] = $nameOriginal;

			if( !$this->validadeImage($base64Image) )
				return $this->resp;

			if( $this->writeImage( $base64Image ) ) {
				$this->resp["status"] = "success";
				$this->saveImageIntoDB();
			}

			return $this->resp;
		}

		public function uploadByLink( $link ) {
			$imgInfo = explode("/", $link);
			$imgName = $imgInfo[count($imgInfo)-1];
			$this->resp["originalName"] = $imgName;

			$imgInfo = explode(".", $imgName);
			$mimeExt = $imgInfo[count($imgInfo)-1];

			$file = file_get_contents( $link );

			if( strlen($file) < 1 ) {
				$this->resp["status"] = $this->errorImageNotFound;
				return $this->resp;
			}

			$base64Image = base64_encode($file);
			$base64Image = 'data:image/'.$mimeExt.';base64,'.$base64Image;

			if( !$this->validadeImage($base64Image) )
				return $this->resp;

			if( $this->writeImage( $base64Image ) ) {
				$this->resp["status"] = "success";
				$this->saveImageIntoDB();
			}

			return $this->resp;
		}

		private function generateHash( $data ) {
			return hash($this->imgHashType, hrtime(true).$data);
		}

		private function saveImageIntoDB() {
			$db = new Database();
			$conn = $db->getDb();

			$sql = "INSERT INTO `images` (`id`, `client_id`, `name`, `status`) VALUES (:id, :clientId, :name, :status)";
			$conn->prepare($sql)->execute([
				'id' => $this->resp["hash"],
				'clientId' => $this->clientId,
				'name' => $this->resp["originalName"],
				'status' => $this->resp["status"]
			]);
		}

		private function validateExtension( $extension ) {
			if( in_array(strtolower($extension), $this->allowedFormats) )
				return true;
			
			return false;
		}

		private function validateFileSize( $file ) {
			$size = strlen(base64_decode($file));

			if( $size > $this->imgMaxSize )
				return false;
			
			return true;
		}

		private function validadeImage( $base64Image ) {
			$imageData = $this->returnExtensionFromBase64($base64Image);
			$mimeExt = $imageData[0];
			$this->image = $imageData[1];

			if( !$this->validateExtension($mimeExt) ) {
				$this->resp[status] = $this->errorFormatNotAllowed;
				return false;
			}

			if( !$this->validateFileSize($base64Image) ) {				
				$this->resp[status] = $this->errorImageTooBig;
				return false;
			}

			return true;
		}

		private function writeImage( $data ) {
			$this->resp["hash"] = $this->generateHash($this->image);
			$this->resp["link"] = $this->getLink( $this->clientId, $this->resp["hash"] );

			$path = $_SERVER["DOCUMENT_ROOT"] . "/public/images/" . $this->clientId;

			if( !is_dir($path) )
				mkdir($path, 0777, true);

			file_put_contents( $path."/".$this->resp["hash"], $data );

			return true;
		}
	}
?>
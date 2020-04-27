<?php
	class search extends models {
		private $clientId;

		public function __construct( $clientId ) {
			$this->clientId = $clientId;
		}

		public function searchImages( $pattern ) {
			$db = new Database();
			$conn = $db->getDb();

			$sql = "SELECT * FROM images WHERE client_id = :clientId AND CONCAT(id, name) LIKE :pattern";
			$res = $conn->prepare($sql);
			$res->execute([
				'clientId' => $this->clientId,
				'pattern' => "%". $pattern . "%"
			]);

			$ret = array();
			$resColumn = $res->fetchAll();

			foreach( $resColumn as $value ) {
				$this->resp["originalName"] = $value["name"];
				$this->resp["hash"] = $value["id"];
				$this->resp["link"] = $this->getLink($this->clientId, $value["id"]);
				$this->resp["status"] = $value["status"];

				array_push($ret, $this->resp);
			}
			
			return $ret;
		}
	}
?>
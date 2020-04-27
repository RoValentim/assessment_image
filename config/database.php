<?php
	class Database {
		private $conn = null;

		public function __construct() {
			$dbServer = "localhost";
			$dbUser = "root";
			$dbPassword = "root";
			$dbName = "assessment_image";

			if( is_null($this->conn) ) {
				$this->conn = new PDO("mysql:host=".$dbServer.";dbname=".$dbName, $dbUser, $dbPassword);
			}

			$sql = "CREATE TABLE IF NOT EXISTS `images` (" .
						"`id` varchar(8) NOT NULL," .
						"`client_id` varchar(16) NOT NULL," .
						"`name` varchar(128) NOT NULL," .
						"`status` varchar(10) NOT NULL," .
						"`created` datetime DEFAULT CURRENT_TIMESTAMP" .
					") COMMENT='image assessment'";

			$this->conn->exec($sql);
		}

		public function getDb() {
			return $this->conn;
		}
	}
?>

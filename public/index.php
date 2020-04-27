<?php 
	require_once($_SERVER["DOCUMENT_ROOT"] . "/config/database.php");
	require_once($_SERVER["DOCUMENT_ROOT"] . "/config/router.php");
	require_once($_SERVER["DOCUMENT_ROOT"] . "/controllers/controller.php");
	require_once($_SERVER["DOCUMENT_ROOT"] . '/models/models.php');

	$call = new router();
	$call->do();
?>
<?php
	require 'core/vendor/Slim/Slim.php'; // gere le routage
	use Slim\Slim;
	\Slim\Slim::registerAutoloader();
	$app = new \Slim\Slim(array());
	require 'core/model/system.php'; // gere le system
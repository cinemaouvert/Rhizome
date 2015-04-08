<?php
	require 'core/vendor/Slim/Slim.php'; // gere le routage
	use Slim\Slim;
	\Slim\Slim::registerAutoloader();
	$app = new \Slim\Slim(array(
		'templates.path' => 'admin/templates/'
		));
	require 'core/model/system.php'; // gere le system
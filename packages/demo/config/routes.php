<?php

return array(
	'GET' => array(
		'' => array('Phoxx\Packages\Demo\Controllers\DemoController' => 'index'),
		'_404_' => array('Phoxx\Packages\Demo\Controllers\DemoController' => 'pageNotFound'),
		'_500_' => array('Phoxx\Packages\Demo\Controllers\DemoController' => 'internalServerError')
	)
);
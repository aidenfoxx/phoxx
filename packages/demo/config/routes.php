<?php

return array(
	'GET' => array(
		'' => array('Phoxx\Packages\Demo\Controllers\CoreController' => 'index'),
		'_404_' => array('Phoxx\Packages\Demo\Controllers\CoreController' => 'pageNotFound'),
		'_500_' => array('Phoxx\Packages\Demo\Controllers\CoreController' => 'internalServerError')
	)
);
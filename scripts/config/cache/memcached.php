<?php

return array(
	/**
	 * Array of memcache servers locations.
	 *     Layout: array(
	 *         array('SERVER_HOST', SERVER_PORT, SERVER_WEIGHT),
	 *         ...
	 *     )
	 */
	'MEMCACHED_SERVERS' => array(
		array('mc1.localhost', 11211, 50),
		array('mc2.localhost', 11211, 50)
	)
);
<?php
return array(
	'admin'	=> array(
		array('GET', new Route('admin/job/index'))
	),
	'admin/login' => array(
		array('GET', new Route('admin/auth/index')),
		array('POST', new Route('admin/auth/index'))
	),
	'admin/logout' => array(
		array('GET', new Route('admin/auth/logout'))
	),
);



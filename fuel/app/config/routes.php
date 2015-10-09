<?php
return array(
	'_root_'  => 'index',  // The default route
	'user/job/saved'	=> array(
		array('GET', new Route('favorite'))
	),
);

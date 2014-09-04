<?php

/**
 * Basic route
 */
Route::set('giggacounter', 'giggacounter/<api>',
	array(
	))
	->defaults(array(
	    'controller' => 'giggacounter',
	    'action'     => 'index',
	)
);

/**
 * Serve media files from the module
 */
Route::set('giggacounter/media', 'giggacounter/media(/<file>)', array('file' => '.+'))
	->defaults(array(
		'controller' => 'Giggacounter',
		'action'     => 'media',
		'file'       => NULL,
	));
	
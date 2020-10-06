<?php
/********** Debugging Functions ***********/

// this should never be called directly
if (!function_exists('new_dump')) {
    function new_dump()
    {
		array_map(function($x){ dump($x); }, func_get_args());
	}
}

// dumps the data
// accepts any number of parameters
if (!function_exists('d')) {
    function d()
    {
		new_dump( func_get_args() );
	}
}

// dumps the data and exits
// accepts any number of parameters
if (!function_exists('dd')) {
    function dd()
    {
		new_dump( func_get_args() ); exit;
	}
}
<?php
namespace Spark\Config;

get('/', ['function'=>'index']);
get('/portfolios', ['function'=>'index']);


//users
post('/users', ['function' => 'create']);

get('/api/stocks/:symbol', [
	'function'=>'index',
	'namespace'=>'api'
]);
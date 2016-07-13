<?php
namespace Spark\Config;

get('/', ['function'=>'index']);
get('/portfolios', ['function'=>'index']);

get('/api/stocks/:symbol', [
	'function'=>'index',
	'namespace'=>'api'
]);
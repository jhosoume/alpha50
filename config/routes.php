<?php
namespace Spark\Config;

get('/', ['function'=>'index']);
get('/portfolios', ['function'=>'index']);

//users
post('/users', ['function' => 'create']);

//sessions
post('/sessions', ['function' => 'create']);
delete('/sessions', ['function' => 'destroy']);
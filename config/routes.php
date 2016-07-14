<?php
namespace Spark\Config;

get('/', ['function'=>'index']);
get('/portfolios', ['function'=>'index']);
get('/portfolios/:id', ['function'=>'show']);
get('/portfolios/new', ['function' => 'new']);

//users
post('/users', ['function' => 'create']);


get('/api/stocks', [
  'function'=>'index',
  'namespace'=>'api'
]);

get('/api/stocks/:symbol', [
  'function'=>'show',
  'namespace'=>'api'
]);

//sessions
post('/sessions', ['function' => 'create']);
delete('/sessions', ['function' => 'destroy']);

<?php
namespace Spark\Config;

get('/', ['function'=>'index']);
get('/portfolios', ['function'=>'index']);
get('/portfolios/new', ['function' => 'new']);
get('/portfolios/:id', ['function'=>'show']);


//users
post('/users', ['function' => 'create']);


//trades
post('/trades', ['function'=>'create']);


get('/api/stocks', [
  'function'=>'index',
  'namespace'=>'api'
]);

get('/api/stocks/:symbol', [
  'function'=>'show',
  'namespace'=>'api'
]);

//sessions
post('/login', ['function' => 'create', 'controller'=>'Sessions']);
delete('/logout', ['function' => 'destroy', 'controller'=>'Sessions']);

<?php
namespace Spark\Config;

get('/', ['function'=>'index']);
get('/portfolios', ['function'=>'index']);
get('/portfolios/new', ['function' => 'new']);
get('/portfolios/:id', ['function'=>'show']);
//api
post('/portfolios', ['function' => 'create']);


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


get('/api/portfolios/new', [
  'function'=>'new',
  'namespace'=>'api']);

//sessions
post('/login', ['function' => 'create', 'controller'=>'Sessions']);
delete('/logout', ['function' => 'destroy', 'controller'=>'Sessions']);

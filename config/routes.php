<?php
namespace Spark\Config;

//root
get('/', ['function'=>'index']);


//portfolios
get('/portfolios', ['function'=>'index']);
get('/portfolios/new', ['function' => '_new']);
get('/portfolios/:id', ['function'=>'show']);
post('/portfolios', ['function'=>'create']);

//users
post('/users', ['function' => 'create']);


//trades
post('/trades', ['function'=>'create']);


//api
get('/api/portfolios/:id', ['function' => 'show','namespace'=>'api']);
get('/api/trades', ['function' => 'index','namespace'=>'api']);

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

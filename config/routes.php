<?php
use app\Router;
$router->get('/', 'FundacaoController@listarFundacoes');
$router->get('/fundacao', 'FundacaoController@formulario');
$router->get('/fundacao/buscar', 'FundacaoController@buscarFundacao');
$router->get('/fundacao/cadastrar', 'FundacaoController@formulario');   
$router->get('/fundacao/editarFundacao', 'FundacaoController@editarFundacao'); 
$router->post('/fundacao/update', 'FundacaoController@atualizarFundacao');
$router->post('/fundacao/save', 'FundacaoController@cadastrar'); 
$router->post('/fundacao/delete', 'FundacaoController@deletarFundacao');   
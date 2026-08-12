<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\ProdutoController;
use App\Core\Database;
use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use App\Exceptions\ValidationException;
use App\Repositories\ProdutoRepository;
use App\Services\EstoqueService;

set_exception_handler(function (Throwable $e) {
    if ($e instanceof ValidationException) {
        Response::error($e->getMessage(), $e->getCode() ?: 422, $e->getErrors());
    }

    Response::error('Erro interno no servidor: ' . $e->getMessage(), 500);
});

$pdo = Database::getConnection();
$produtoRepo = new ProdutoRepository($pdo);
$estoqueService = new EstoqueService($produtoRepo);
$produtoController = new ProdutoController($estoqueService);

$router = new Router();

$router->add('GET', '/produtos', [$produtoController, 'index']);
$router->add('POST', '/produtos', [$produtoController, 'store']);

$router->dispatch(Request::getMethod(), Request::getUri());

<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Services\EstoqueService;

class ProdutoController
{
    public function __construct(private EstoqueService $service) {}

    public function index(): void
    {
        $produtos = $this->service->listarProdutos();
        Response::json(['status' => 'success', 'data' => $produtos]);
    }

    public function store(): void
    {
        $body = Request::getBody();
        $produto = $this->service->criarProduto($body);
        Response::json(['status' => 'success', 'data' => $produto->toArray()], 201);
    }
}

<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Models\Produto;
use App\Repositories\ProdutoRepository;

class EstoqueService
{
    public function __construct(
        private ProdutoRepository $produtoRepo
    ) {}

    public function criarProduto(array $data): Produto
    {
        $errors = [];
        if (empty($data['nome'])) {
            $errors['nome'] = 'O nome do produto é obrigatório.';
        }
        if (empty($data['sku'])) {
            $errors['sku'] = 'O SKU do produto é obrigatório.';
        }

        if (!empty($errors)) {
            throw new ValidationException('Dados inválidos para cadastro de produto.', $errors);
        }

        if ($this->produtoRepo->findBySku($data['sku'])) {
            throw new ValidationException('Já existe um produto cadastrado com este SKU.', ['sku' => 'SKU em uso.']);
        }

        $produto = new Produto(
            id: null,
            nome: trim($data['nome']),
            sku: strtoupper(trim($data['sku'])),
            quantidade: isset($data['quantidade']) ? max(0, (int)$data['quantidade']) : 0
        );

        return $this->produtoRepo->create($produto);
    }

    public function listarProdutos(): array
    {
        return array_map(fn(Produto $p) => $p->toArray(), $this->produtoRepo->findAll());
    }
}

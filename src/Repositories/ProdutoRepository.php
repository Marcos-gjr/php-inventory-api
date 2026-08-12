<?php

namespace App\Repositories;

use App\Models\Produto;
use PDO;

class ProdutoRepository
{
    public function __construct(private PDO $pdo) {}

    public function create(Produto $produto): Produto
    {
        $sql = "INSERT INTO produtos (nome, sku, quantidade) VALUES (:nome, :sku, :quantidade)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nome'       => $produto->nome,
            ':sku'        => $produto->sku,
            ':quantidade' => $produto->quantidade,
        ]);

        $produto->id = (int)$this->pdo->lastInsertId();
        return $this->findById($produto->id);
    }

    public function findById(int $id): ?Produto
    {
        $stmt = $this->pdo->prepare("SELECT * FROM produtos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();

        return $data ? Produto::fromArray($data) : null;
    }

    public function findBySku(string $sku): ?Produto
    {
        $stmt = $this->pdo->prepare("SELECT * FROM produtos WHERE sku = :sku");
        $stmt->execute([':sku' => $sku]);
        $data = $stmt->fetch();

        return $data ? Produto::fromArray($data) : null;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM produtos ORDER BY id DESC");
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => Produto::fromArray($row), $rows);
    }
}

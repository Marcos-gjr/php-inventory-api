<?php

namespace App\Models;

class Produto
{
    public function __construct(
        public ?int $id,
        public string $nome,
        public string $sku,
        public int $quantidade = 0,
        public ?string $createdAt = null,
        public ?string $updatedAt = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: isset($data['id']) ? (int)$data['id'] : null,
            nome: $data['nome'] ?? '',
            sku: $data['sku'] ?? '',
            quantidade: isset($data['quantidade']) ? (int)$data['quantidade'] : 0,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id'         => $this->id,
            'nome'       => $this->nome,
            'sku'        => $this->sku,
            'quantidade' => $this->quantidade,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}

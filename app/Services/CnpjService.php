<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CnpjService
{
    public function isCnpj(string $document): bool
    {
        return strlen($document) === 14;
    }

    public function fetch(string $cnpj): ?array
    {
        return Cache::remember("cnpj:{$cnpj}", now()->addDay(), function () use ($cnpj) {
            try {
                $response = Http::timeout(3)->retry(1, 200)
                    ->get("https://brasilapi.com.br/api/cnpj/v1/{$cnpj}");

                return $response->successful() ? $response->json() : null;
            } catch (\Exception $e) {
                Log::warning("BrasilAPI failed: " . $e->getMessage());
                return null;
            }
        });
    }

    public function formatAddress(array $data): string
    {
        return trim(implode(', ', array_filter([
            $data['descricao_tipo_logradouro'] ?? '',
            $data['logradouro'] ?? '',
            $data['numero'] ?? '',
            $data['bairro'] ?? '',
            $data['municipio'] ?? '',
            $data['uf'] ?? '',
            $data['cep'] ?? '',
        ])));
    }
}

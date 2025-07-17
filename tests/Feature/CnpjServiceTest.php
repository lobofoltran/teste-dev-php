<?php

use App\Services\CnpjService;
use Illuminate\Support\Facades\Http;

it('fetches CNPJ data correctly', function () {
    Http::fake([
        'https://brasilapi.com.br/api/cnpj/v1/*' => Http::response([
            'razao_social' => 'Empresa Exemplo',
            'logradouro' => 'Rua Teste',
            'numero' => '123',
            'bairro' => 'Centro',
            'municipio' => 'Curitiba',
            'uf' => 'PR',
            'cep' => '80000000',
        ], 200),
    ]);

    $service = new CnpjService();
    $result = $service->fetch('12345678000100');

    expect($result['razao_social'])->toBe('Empresa Exemplo');
});

it('returns null on 404 response', function () {
    Http::fake([
        'https://brasilapi.com.br/api/cnpj/v1/*' => Http::response(['message' => 'CNPJ inválido'], 404),
    ]);

    $service = new CnpjService();
    $result = $service->fetch('00000000000000');

    expect($result)->toBeNull();
});

<?php

use App\Services\CnpjService;

it('detects valid CNPJ by length', function () {
    $service = new CnpjService();

    expect($service->isCnpj('12345678000195'))->toBeTrue();
    expect($service->isCnpj('12345678900'))->toBeFalse();
});

it('formats CNPJ address correctly', function () {
    $cnpjData = [
        'logradouro' => 'Rua Teste',
        'numero' => '123',
        'bairro' => 'Centro',
        'municipio' => 'Curitiba',
        'uf' => 'PR',
        'cep' => '80000000',
    ];

    $service = new CnpjService();

    $formatted = $service->formatAddress($cnpjData);

    expect($formatted)->toBe('Rua Teste, 123, Centro, Curitiba, PR, 80000000');
});


<?php

use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Supplier Model', function () {
    it('does not allow duplicate document', function () {
        Supplier::create([
            'name' => 'Fornecedor 1',
            'document' => '12345678000195',
        ]);

        expect(function () {
            Supplier::create([
                'name' => 'Fornecedor 2',
                'document' => '12345678000195',
            ]);
        })->toThrow(\Illuminate\Database\QueryException::class);
    });

    it('creates a supplier with all valid attributes', function () {

        $supplier = Supplier::create([
            'name' => 'Fornecedor Completo',
            'document' => '12345678000195',
            'email' => 'contato@empresa.com',
            'phone' => '41999999999',
            'address' => 'Rua A, 123 - Centro',
        ]);

        expect($supplier)->toBeInstanceOf(Supplier::class);
        expect($supplier->exists)->toBeTrue();
        expect($supplier->name)->toBe('Fornecedor Completo');
        expect($supplier->document)->toBe('12345678000195');
        expect($supplier->email)->toBe('contato@empresa.com');
        expect($supplier->phone)->toBe('41999999999');
        expect($supplier->address)->toBe('Rua A, 123 - Centro');
    });

    it('accepts null values for optional fields', function () {
        $supplier = Supplier::create([
            'name' => 'Fornecedor Sem Contato',
            'document' => '12345678000195',
            'email' => null,
            'phone' => null,
            'address' => null,
        ]);

        expect($supplier->email)->toBeNull();
        expect($supplier->phone)->toBeNull();
        expect($supplier->address)->toBeNull();
    });

    it('initializes with default values when using new', function () {
        $supplier = new Supplier([
            'name' => 'Fornecedor A',
            'document' => '12345678000195',
        ]);

        expect($supplier->email)->toBeNull();
        expect($supplier->exists)->toBeFalse(); // ainda não persistido
    });

});

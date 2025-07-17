<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CpfCnpj implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $numeric = preg_replace('/\D/', '', $value); // remove pontuação

        if (strlen($numeric) === 11) {
            if (!self::isValidCpf($numeric)) {
                $fail("The :attribute must be a valid CPF.");
            }
        } elseif (strlen($numeric) === 14) {
            if (!self::isValidCnpj($numeric)) {
                $fail("The :attribute must be a valid CNPJ.");
            }
        } else {
            $fail("The :attribute must be a valid CPF or CNPJ.");
        }
    }

    private static function isValidCpf(string $cpf): bool
    {
        $c = preg_replace('/\D/', '', $cpf);

        if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            return false;
        }

        for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--)
            ;

        if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--)
            ;

        if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;
    }

    private static function isValidCnpj(string $cnpj): bool
    {
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;

        $c = preg_replace('/((?![0-9A-Z]).)/', '', strtoupper($cnpj));

        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        if (strlen($c) != 14) {
            return false;
        } elseif (preg_match("/^{$c[0]}{14}$/", $c) > 0) {
            return false;
        }

        for ($i = 0, $n = 0; $i < 12; $n += (ord($c[$i]) - 48) * $b[++$i])
            ;

        if ($c[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($i = 0, $n = 0; $i <= 12; $n += (ord($c[$i]) - 48) * $b[$i++])
            ;

        if ($c[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;
    }
}

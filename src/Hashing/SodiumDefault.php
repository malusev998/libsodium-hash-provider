<?php


namespace SodiumHashing\Hashing;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Facades\Hash;

class SodiumDefault implements Hasher
{
    private $memLimit;
    private $opsLimit;
    private $checkBcrypt;

    public function __construct(array $config)
    {
        $this->memLimit = $config['memory'] ?? SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE;
        $this->opsLimit = $config['time'] ?? SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE;
        $this->checkBcrypt = $config['check_bcrypt'] ?? false;
    }

    public function info($hashedValue): array
    {
        return password_get_info($hashedValue);
    }

    public function make($value, array $options = []): string
    {
        return sodium_crypto_pwhash_str(
            $value,
            $options['time'] ?? $this->opsLimit,
            $options['memory'] ?? $this->memLimit
        );
    }

    public function check($value, $hashedValue, array $options = []): bool
    {
        if ($this->checkBcrypt && $this->info($hashedValue)['algo'] === PASSWORD_BCRYPT) {
            return Hash::createBcryptDriver()->check($value, $hashedValue);
        }

        return sodium_crypto_pwhash_str_verify(
            $hashedValue,
            $value
        );
    }

    public function needsRehash($hashedValue, array $options = []): bool
    {
        return sodium_crypto_pwhash_str_needs_rehash(
            $hashedValue,
            $options['memory'] ?? $this->memLimit,
            $options['time'] ?? $this->opsLimit
        );
    }
}

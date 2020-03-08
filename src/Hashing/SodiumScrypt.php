<?php

namespace SodiumHashing\Hashing;

use Illuminate\Contracts\Hashing\Hasher;

class SodiumScrypt implements Hasher
{
    private $memLimit;
    private $opsLimit;

    public function __construct(array $config)
    {
        $this->memLimit = $config['memory'] ?? SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE;
        $this->opsLimit = $config['time'] ?? SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE;
    }

    public function info($hashedValue): array
    {
        return password_get_info($hashedValue);
    }

    public function make($value, array $options = []): string
    {
        return sodium_crypto_pwhash_scryptsalsa208sha256_str(
            $value,
            $options['memory'] ?? $this->memLimit,
            $options['time'] ?? $this->opsLimit
        );
    }

    public function check($value, $hashedValue, array $options = []): bool
    {
        return sodium_crypto_pwhash_scryptsalsa208sha256_str_verify(
            $value,
            $hashedValue
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

<?php

namespace SodiumHashing\Manager;

use Illuminate\Contracts\Container\Container;
use Illuminate\Hashing\HashManager;
use SodiumHashing\Hashing\SodiumDefault;
use SodiumHashing\Hashing\SodiumScrypt;

class SodiumHashManager extends HashManager
{
    protected $manager;

    public function __construct(HashManager $manager, Container $container)
    {
        parent::__construct($container);
        $this->manager = $manager;
    }


    public function createSodiumHashDefaultDriver(): SodiumDefault
    {
        return new SodiumDefault($this->config->get('sodium_hashing.default'));
    }

    public function createSodiumHashScryptDriver(): SodiumScrypt
    {
        return new SodiumScrypt($this->config->get('sodium_hashing.scrypt'));
    }
}

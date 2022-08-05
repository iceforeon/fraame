<?php

namespace App\Traits;

trait Hashid
{
    public function getHashIdField()
    {
        return 'hashid';
    }

    public function createSalt()
    {
        return str()
            ->of(config('services.hashid.salt'))
            ->append('-')
            ->append($this->getTable())
            ->toString();
    }

    public function generateHashid()
    {
        $this->{$this->getHashIdField()} = (new \App\Service\Hashid)
            ->from($this)
            ->salt($this->createSalt())
            ->generate();
    }

    protected static function bootHashid()
    {
        self::creating(fn ($model) => $model->generateHashid());
    }
}

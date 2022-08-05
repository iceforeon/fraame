<?php

namespace App\Service;

use Hashids\Hashids;
use Illuminate\Database\Eloquent\Model;

class Hashid
{
    public $salt;

    public $length;

    public $alphabet;

    const STARTING_VALUE = 999;

    public function __construct(public ?Model $model = null)
    {
        $this->salt = config('services.hashid.salt');
        $this->length = config('services.hashid.length');
        $this->alphabet = config('services.hashid.alphabet');
    }

    public function salt($salt = null)
    {
        $this->salt = $salt ?? config('services.hashid.salt');

        return $this;
    }

    public function length($length = null)
    {
        $this->length = $length ?? config('services.hashid.length');

        return $this;
    }

    public function alphabet($alphabet = null)
    {
        $this->alphabet = $alphabet ?? config('services.hashid.alphabet');

        return $this;
    }

    public function from(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    public function includeTrashed()
    {
        return in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses($this->model));
    }

    public function generate()
    {
        $id = $this->latestModelId();

        do {
            $id++;
            $hashid = (new Hashids($this->salt, $this->length, $this->alphabet))->encode($id);
        } while ($this->hashidExists($hashid));

        return $hashid;
    }

    public function latestModelId()
    {
        return get_class($this->model)::query()
            ->when($this->includeTrashed(), fn ($q) => $q->withTrashed())
            ->select('id')
            ->latest()
            ->first()
            ->id ?? self::STARTING_VALUE;
    }

    public function hashidExists($hashId)
    {
        return get_class($this->model)::query()
            ->when($this->includeTrashed(), fn ($q) => $q->withTrashed())
            ->where($this->model->getHashIdField(), $hashId)
            ->exists();
    }
}

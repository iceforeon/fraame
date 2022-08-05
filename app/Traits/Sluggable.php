<?php

namespace App\Traits;

trait Sluggable
{
    public function getSourceField()
    {
        return 'title';
    }

    public function getSlugField()
    {
        return 'slug';
    }

    public function generateSlug()
    {
        $this->{$this->getSlugField()} = (new \App\Service\Slug)
            ->from($this)
            ->generate();
    }

    protected static function bootSluggable()
    {
        self::creating(fn ($model) => $model->generateSlug());
        self::updating(fn ($model) => $model->generateSlug());
    }
}

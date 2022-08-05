<?php

namespace App\Traits;

use App\Service\Slug;

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
        $this->{$this->getSlugField()} = (new Slug)->from($this)->generate();
    }

    protected static function bootSluggable()
    {
        self::creating(fn ($model) => $model->generateSlug());
        self::updating(fn ($model) => $model->generateSlug());
    }
}

<?php

namespace App\Service;

use Illuminate\Database\Eloquent\Model;

class Slug
{
    public function __construct(public ?Model $model = null)
    {
    }

    public function from(Model $model = null)
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
        $slug = ! str()->of($this->model->slug)->trim()->isEmpty()
            ? $this->slugFromInput()
            : $this->slugFromSource();

        $count = $this->occurrence($slug);

        if ($count == 0) {
            return $slug;
        }

        $count = $count == 1 ? 0 : $count;

        do {
            $count++;
            $processedSlug = str()
                ->of($slug)
                ->replaceMatches('/[^A-Za-z0-9\-]/', ' ')
                ->append(' ')
                ->append($count)
                ->slug()
                ->toString();
        } while ($this->slugExist($processedSlug));

        return $processedSlug;
    }

    public function slugFromInput()
    {
        return str()
            ->of($this->model->{$this->model->getSlugField()})
            ->replaceMatches('/[^A-Za-z0-9\-]/', ' ')
            ->slug()
            ->toString();
    }

    public function slugFromSource()
    {
        return str()
            ->of($this->model->{$this->model->getSourceField()})
            ->replaceMatches('/[^A-Za-z0-9\-]/', ' ')
            ->slug()
            ->toString();
    }

    public function occurrence($slug)
    {
        return get_class($this->model)::query()
            ->when($this->model->id, fn ($q) => $q->whereNot('id', $this->model->id))
            ->when($this->includeTrashed(), fn ($q) => $q->withTrashed())
            ->where($this->model->getSlugField(), $slug)
            ->count();
    }

    public function slugExist($slug)
    {
        return (bool) get_class($this->model)::query()
            ->when($this->model->id, fn ($q) => $q->whereNot('id', $this->model->id))
            ->when($this->includeTrashed(), fn ($q) => $q->withTrashed())
            ->where($this->model->getSlugField(), $slug)
            ->exists();
    }
}

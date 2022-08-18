<?php

namespace App\Jobs;

use App\Enums\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PickTodaysFeatured implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public Category $category)
    {
    }

    public function handle()
    {
        $model = "\App\Models\\$this->category->name";

        $model::query()
            ->approved()
            ->whereNull('featured_at')
            ->orWhereDate('featured_at', '<=', now()->subMonth(1)->startOfDay())
            ->inRandomOrder()
            ->get()
            ->first()
            ->update(['featured_at' => now()->startOfDay()]);
    }
}

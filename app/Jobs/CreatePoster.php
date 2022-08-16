<?php

namespace App\Jobs;

use App\Enums\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Spatie\Browsershot\Browsershot;

class CreatePoster implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $deleteWhenMissingModels = true;

    public function __construct(public Model $model, public Category $category)
    {
    }

    public function handle()
    {
        try {
            $base64Image = Browsershot::url(route('poster', $this->model->hashid).'?key='.config('app.poster_route_key').'&category='.$this->category->value)
                ->noSandbox()
                ->waitUntilNetworkIdle()
                ->select('#poster')
                ->base64Screenshot();

            $file = Image::make($base64Image);

            $filename = Str::uuid().'.png';

            Storage::disk('media')->put($filename, (string) $file->encode(), 'public');

            $this->model->update(['poster_path' => $filename]);
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
        }
    }
}

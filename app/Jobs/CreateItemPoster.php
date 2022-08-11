<?php

namespace App\Jobs;

use App\Enums\ItemType;
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

class CreateItemPoster implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public Model $model, public ItemType $type)
    {
    }

    public function handle()
    {
        try {
            $base64Image = Browsershot::url(route('item-poster', $this->model->hashid).'?key='.config('app.poster_route_key').'&type='.$this->type->value)
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

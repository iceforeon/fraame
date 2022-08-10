<?php

namespace App\Jobs;

use App\Enums\ItemType;
use HeadlessChromium\BrowserFactory;
use HeadlessChromium\Page;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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
        // try {
            $browser = (new BrowserFactory('google-chrome'))
                ->createBrowser(['noSandbox' => true]);

            $page = $browser->createPage();

            $page->navigate(route('item-poster', $this->model->hashid).'?key='.config('app.poster_route_key').'&type='.$this->type->value)
                ->waitForNavigation(Page::NETWORK_IDLE, 90000);

            $page->waitUntilContainsElement('div.poster-idle', 80000);

            $evaluation = $page->evaluate('document.getElementById("poster").clientHeight');

            $page->setViewport(550, $evaluation->getReturnValue());

            $base64Image = $page->screenshot()->getBase64();

            $filename = Str::uuid().'.png';

            $file = Image::make($base64Image);

            Storage::disk('media')->put($filename, (string) $file->encode(), 'public');

            $this->model->update(['poster_path' => $filename]);
        // } catch (\Exception $exception) {
        //     \Log::error($exception->getMessage());
        // } finally {
            $browser->close();
        // }
    }
}

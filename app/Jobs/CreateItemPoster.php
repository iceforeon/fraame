<?php

namespace App\Jobs;

use App\Models\Item;
use HeadlessChromium\BrowserFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CreateItemPoster implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function handle()
    {
        $browser = (new BrowserFactory('google-chrome'))
            ->createBrowser(['noSandbox' => true]);

        try {
            $page = $browser->createPage();

            $page->navigate(route('item-poster', $this->item->hashid).'?key='.config('app.poster_route_key'))
                ->waitForNavigation();

            $page->waitUntilContainsElement('div.poster-idle', 50000);

            $evaluation = $page->evaluate('document.getElementById("poster").clientHeight');

            $page->setViewport(550, $evaluation->getReturnValue());

            $base64Image = $page->screenshot()->getBase64();

            $filename = Str::uuid().'.png';

            $file = Image::make($base64Image);

            Storage::put($filename, (string) $file->encode(), 'public');
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
        } finally {
            $browser->close();
        }
    }
}

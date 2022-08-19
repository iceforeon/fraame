<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use JoelButcher\Facebook\Facebook;

class PostImageToFacebook implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct()
    {
    }

    public function handle()
    {
        $facebook = new Facebook(config('services.facebook'));

        $payload = [
            'url' => 'http://fraa.me/media/5a3a2e10-b8eb-4f3c-8677-29394db977c3.png',
            'message' => 'The Godfather (1972)',
        ];

        try {
            $response = $facebook->post(config('services.facebook.page_id').'/photos', $payload);

            info($response->getGraphNode());
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            \Log::info($e->getMessage());
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            \Log::info($e->getMessage());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        }
    }
}

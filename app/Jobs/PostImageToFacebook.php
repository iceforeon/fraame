<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PostImageToFacebook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $facebook = new Facebook(config('services.facebook'));

        $payload = [
            'url' => 'https://fraame.co/path-to-image.jpg',
            'message' => 'Labore commodo exercitation non aliquip',
        ];

        try {
            $response = $facebook->post(config('services.facebook.page_id').'/photos', $payload);

            dd($response->getGraphNode());
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            Log::info($e->getMessage());
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            Log::info($e->getMessage());
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MockApiService
{
    public function getPosts(): array
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception("Failed to retrieve posts. Status code: " . $response->getStatusCode());
        }
    }

    public function getComments(): array
    {
        $response = Http::get("https://jsonplaceholder.typicode.com/comments");

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception("Failed to retrieve comments for post . Status code: " . $response->getStatusCode());
        }
    }
}

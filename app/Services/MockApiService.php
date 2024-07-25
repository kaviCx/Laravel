<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MockApiService
{

    public function getPostsOrComments(string $type): array
{
    $url = "https://jsonplaceholder.typicode.com/";

    if ($type === 'posts') {
        $url .= "posts";
    } elseif ($type === 'comments') {
        $url .= "comments";
    } else {
        throw new \Exception("Invalid type. Use 'posts' or 'comments'.");
    }

    $response = Http::get($url);

    if ($response->successful()) {
        return $response->json();
    } else {
        throw new \Exception("Failed to retrieve {$type}. Status code: " . $response->getStatusCode());
    }
}
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class QrisService
{
    public static function storagePath(): string
    {
        return storage_path('app/qris.json');
    }

    public static function getImageUrl(): ?string
    {
        $storedFile = self::storagePath();

        if (file_exists($storedFile)) {
            $payload = json_decode(file_get_contents($storedFile), true);
            if (!empty($payload['image_url'])) {
                return $payload['image_url'];
            }
        }

        return env('QRIS_IMAGE_URL', null);
    }

    public static function saveImageUrl(string $imageUrl): bool
    {
        $payload = ['image_url' => $imageUrl];
        return file_put_contents(self::storagePath(), json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) !== false;
    }
}

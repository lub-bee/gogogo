<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class ImagePipeline
{
    /**
     * Max long-edge for the main image (pixels).
     */
    public const MAX_EDGE = 1920;

    /**
     * Max long-edge for the thumbnail (pixels).
     */
    public const THUMB_EDGE = 400;

    /**
     * WebP quality (0-100).
     */
    public const QUALITY = 82;

    /**
     * Process an uploaded file: auto-orient, resize, encode WebP, generate thumbnail.
     *
     * @return array{path: string, thumbnail_path: string}  Paths relative to the public disk.
     */
    public function process(UploadedFile $file): array
    {
        $manager = new ImageManager(new Driver());
        $uuid = Str::uuid()->toString();

        // Read + orient
        $image = $manager->read($file->getPathname());
        $image->orient();

        // --- Main image: scale down if larger than MAX_EDGE ---
        $width = $image->width();
        $height = $image->height();
        if ($width > self::MAX_EDGE || $height > self::MAX_EDGE) {
            $image->scaleDown(self::MAX_EDGE, self::MAX_EDGE);
        }

        $mainEncoded = $image->encode(new WebpEncoder(self::QUALITY));
        $mainPath = "media/{$uuid}.webp";
        Storage::disk('public')->put($mainPath, (string) $mainEncoded);

        // --- Thumbnail: scale down to THUMB_EDGE ---
        $image->scaleDown(self::THUMB_EDGE, self::THUMB_EDGE);
        $thumbEncoded = $image->encode(new WebpEncoder(self::QUALITY));
        $thumbPath = "media/thumbs/{$uuid}.webp";
        Storage::disk('public')->put($thumbPath, (string) $thumbEncoded);

        return [
            'path' => $mainPath,
            'thumbnail_path' => $thumbPath,
        ];
    }
}

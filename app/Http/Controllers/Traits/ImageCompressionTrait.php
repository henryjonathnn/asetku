<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

trait ImageCompressionTrait 
{
    /**
     * Compress image using native PHP functions
     * 
     * @param UploadedFile $file Uploaded image file
     * @param string $directory Storage directory
     * @param int $maxWidth Maximum width for resizing
     * @param int $quality Compression quality (0-100)
     * @return string|null Compressed image path
     */
    protected function compressImage(UploadedFile $file, $directory, $maxWidth = 1920, $quality = 75)
    {
        // Generate unique filename
        $fileName = time() . '_' . $file->getClientOriginalName();
        $storagePath = "public/{$directory}/{$fileName}";

        // Get image info
        $sourceImage = $this->createImageFromFile($file);
        
        if (!$sourceImage) {
            return null;
        }

        // Get original dimensions
        $width = imagesx($sourceImage);
        $height = imagesy($sourceImage);

        // Calculate new dimensions while maintaining aspect ratio
        $newWidth = min($width, $maxWidth);
        $newHeight = floor($height * ($newWidth / $width));

        // Create new true color image
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

        // Handle transparency for PNG and GIF
        $this->preserveTransparency($sourceImage, $resizedImage);

        // Resize image
        imagecopyresampled(
            $resizedImage, 
            $sourceImage, 
            0, 0, 0, 0, 
            $newWidth, $newHeight, 
            $width, $height
        );

        // Ensure directory exists
        Storage::makeDirectory("public/{$directory}");

        // Save compressed image based on mime type
        $saved = $this->saveCompressedImage($resizedImage, $storagePath, $file, $quality);

        // Free up memory
        imagedestroy($sourceImage);
        imagedestroy($resizedImage);

        return $saved ? str_replace('public/', '', $storagePath) : null;
    }

    /**
     * Create image resource from uploaded file
     */
    private function createImageFromFile(UploadedFile $file)
    {
        $mimeType = $file->getMimeType();
        $path = $file->getRealPath();

        try {
            switch ($mimeType) {
                case 'image/jpeg':
                    return imagecreatefromjpeg($path);
                case 'image/png':
                    return imagecreatefrompng($path);
                case 'image/gif':
                    return imagecreatefromgif($path);
                case 'image/webp':
                    return imagecreatefromwebp($path);
                default:
                    return null;
            }
        } catch (\Exception $e) {
            // Log error if needed
            return null;
        }
    }

    /**
     * Preserve transparency for PNG and GIF
     */
    private function preserveTransparency($source, $destination)
    {
        imagealphablending($destination, false);
        imagesavealpha($destination, true);
        $transparent = imagecolorallocatealpha($destination, 255, 255, 255, 127);
        imagefilledrectangle($destination, 0, 0, imagesx($destination), imagesy($destination), $transparent);
    }

    /**
     * Save compressed image based on mime type
     */
    private function saveCompressedImage($image, $storagePath, UploadedFile $file, $quality)
    {
        $mimeType = $file->getMimeType();

        try {
            switch ($mimeType) {
                case 'image/jpeg':
                    return imagejpeg($image, storage_path('app/' . $storagePath), $quality);
                case 'image/png':
                    // PNG quality is compression level (0-9)
                    $pngQuality = round(9 * ($quality / 100));
                    return imagepng($image, storage_path('app/' . $storagePath), $pngQuality);
                case 'image/gif':
                    return imagegif($image, storage_path('app/' . $storagePath));
                case 'image/webp':
                    return imagewebp($image, storage_path('app/' . $storagePath), $quality);
                default:
                    return false;
            }
        } catch (\Exception $e) {
            // Log error if needed
            return false;
        }
    }
}
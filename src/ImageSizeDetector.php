<?php

namespace DShovchko\ImagesChecker;

class ImageSizeDetector
{
    protected static $cache = [];
    protected static $timeout = 3;

    public static function getSizes(string $src): array
    {
        if (!isset(self::$cache[$src])) {
            $width = null;
            $height = null;
            
            try {
                // Create context with timeout
                $opts = [
                    'http' => [
                        'timeout' => self::$timeout,
                        'user_agent' => 'Flarum Image Dimensions Extension'
                    ]
                ];
                $context = stream_context_create($opts);
                
                // Download image data with timeout
                $imageData = file_get_contents($src, false, $context);
                
                if ($imageData !== false) {
                    $result = getimagesizefromstring($imageData);
                    
                    if ($result !== false) {
                        $width = $result[0];
                        $height = $result[1];
                    }
                }
            } catch (\Throwable $e) {
                // Ignore errors, return null
            }
        
            self::$cache[$src] = [$width, $height];
        }
        
        return self::$cache[$src];
    }

    public static function getHeight(string $src)
    {
        list($width, $height) = self::getSizes($src);
        return $height;
    }

    public static function getWidth(string $src)
    {
        list($width, $height) = self::getSizes($src);
        return $width;
    }
}

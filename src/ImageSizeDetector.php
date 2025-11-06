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
                // Створюємо контекст з timeout
                $context = stream_context_create([
                    'http' => [
                        'timeout' => self::$timeout,
                        'user_agent' => 'Flarum Image Dimensions Extension'
                    ]
                ]);
                
                $result = @getimagesize($src, $context);
                
                if ($result !== false) {
                    $width = $result[0];
                    $height = $result[1];
                }
            } catch (\Exception $e) {
                // Ігноруємо помилки, повертаємо null
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

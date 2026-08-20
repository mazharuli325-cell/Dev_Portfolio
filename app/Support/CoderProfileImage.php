<?php

namespace App\Support;

use Imagick;
use ImagickDraw;
use ImagickPixel;
use Throwable;

class CoderProfileImage
{
    public static function frame(?string $path): ?string
    {
        if (blank($path) || str_contains($path, '://') || str_ends_with($path, '-coder.png')) {
            return $path;
        }

        $relativePath = ltrim($path, '/\\');
        $sourcePath = public_path($relativePath);

        if (! is_file($sourcePath) || ! extension_loaded('imagick')) {
            return $path;
        }

        $pathInfo = pathinfo($relativePath);
        $directory = str_replace('\\', '/', $pathInfo['dirname'] ?? '');
        $filename = $pathInfo['filename'] ?? 'profile';
        $outputRelativePath = trim($directory . '/' . $filename . '-coder.png', './');
        $outputPath = public_path($outputRelativePath);

        try {
            self::render($sourcePath, $outputPath);
        } catch (Throwable) {
            return $path;
        }

        return $outputRelativePath;
    }

    private static function render(string $sourcePath, string $outputPath): void
    {
        $image = new Imagick($sourcePath);
        $image->setImageFormat('png');
        $image->autoOrient();
        $image->setImagePage(0, 0, 0, 0);

        self::cover($image, 900, 1125);

        $image->modulateImage(82, 108, 96);
        $image->contrastImage(true);

        $overlay = new Imagick();
        $overlay->newImage(900, 1125, new ImagickPixel('transparent'), 'png');

        $overlayDraw = new ImagickDraw();
        $overlayDraw->setFillColor(new ImagickPixel('rgba(3, 8, 13, 0.34)'));
        $overlayDraw->rectangle(0, 0, 900, 1125);
        $overlayDraw->setFillColor(new ImagickPixel('rgba(0, 255, 153, 0.08)'));
        $overlayDraw->polygon([
            ['x' => 0, 'y' => 1125],
            ['x' => 900, 'y' => 1125],
            ['x' => 900, 'y' => 770],
            ['x' => 0, 'y' => 930],
        ]);
        $overlay->drawImage($overlayDraw);
        $image->compositeImage($overlay, Imagick::COMPOSITE_OVER, 0, 0);

        $draw = new ImagickDraw();

        try {
            $draw->setFont('Consolas');
        } catch (Throwable) {
            // Keep ImageMagick's default font if Consolas is unavailable.
        }

        $draw->setStrokeColor(new ImagickPixel('rgba(67, 255, 154, 0.78)'));
        $draw->setStrokeWidth(4);
        $draw->setFillColor(new ImagickPixel('transparent'));
        $draw->roundRectangle(20, 20, 880, 1105, 18, 18);

        $draw->setStrokeWidth(0);
        $draw->setFillColor(new ImagickPixel('rgba(6, 12, 20, 0.74)'));
        $draw->roundRectangle(44, 44, 650, 302, 12, 12);
        $draw->setFillColor(new ImagickPixel('rgba(255, 107, 138, 0.96)'));
        $draw->circle(74, 75, 82, 75);
        $draw->setFillColor(new ImagickPixel('rgba(255, 209, 102, 0.96)'));
        $draw->circle(105, 75, 113, 75);
        $draw->setFillColor(new ImagickPixel('rgba(67, 255, 154, 0.96)'));
        $draw->circle(136, 75, 144, 75);

        self::writeTerminalLine($draw, '$ whoami', 'rgba(67, 255, 154, 0.96)', 68, 116, 25);
        self::writeTerminalLine($draw, 'mazharul_islam', 'rgba(238, 244, 251, 0.92)', 68, 153, 25);
        self::writeTerminalLine($draw, '$ stack --focus', 'rgba(67, 255, 154, 0.96)', 68, 200, 25);
        self::writeTerminalLine($draw, 'laravel react node mysql', 'rgba(102, 217, 239, 0.92)', 68, 237, 25);
        self::writeTerminalLine($draw, '$ deploy --env=production', 'rgba(67, 255, 154, 0.96)', 68, 278, 25);

        $ghostLines = [
            'const build = true;',
            'Route::get("/", fn() => view());',
            'npm run build',
            'php artisan migrate --force',
            'SELECT * FROM projects;',
        ];
        $y = 392;

        foreach ($ghostLines as $line) {
            self::writeTerminalLine($draw, $line, 'rgba(67, 255, 154, 0.23)', 462, $y, 20);
            $y += 42;
        }

        $image->drawImage($draw);
        $image->stripImage();
        $image->writeImage($outputPath);
    }

    private static function cover(Imagick $image, int $targetWidth, int $targetHeight): void
    {
        $sourceWidth = $image->getImageWidth();
        $sourceHeight = $image->getImageHeight();
        $scale = max($targetWidth / $sourceWidth, $targetHeight / $sourceHeight);
        $resizeWidth = (int) ceil($sourceWidth * $scale);
        $resizeHeight = (int) ceil($sourceHeight * $scale);

        $image->resizeImage($resizeWidth, $resizeHeight, Imagick::FILTER_LANCZOS, 1);
        $image->cropImage(
            $targetWidth,
            $targetHeight,
            max(0, (int) (($resizeWidth - $targetWidth) / 2)),
            max(0, (int) (($resizeHeight - $targetHeight) / 2)),
        );
        $image->setImagePage(0, 0, 0, 0);
    }

    private static function writeTerminalLine(
        ImagickDraw $draw,
        string $text,
        string $color,
        int $x,
        int $y,
        int $fontSize,
    ): void {
        $draw->setFontSize($fontSize);
        $draw->setFillColor(new ImagickPixel($color));
        $draw->annotation($x, $y, $text);
    }
}

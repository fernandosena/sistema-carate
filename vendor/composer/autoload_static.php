<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit81ff5e2843da8a9fe25b697e67c025f4
{
    public static $files = array (
        '44ef1d8ec27ad01e41d8f15ce932b11b' => __DIR__ . '/../..' . '/source/Boot/Config.php',
        '05de05ae944629deebff09b1e7131018' => __DIR__ . '/../..' . '/source/Boot/Helpers.php',
        'f5000d2cafcb7460820f4facc487d84c' => __DIR__ . '/../..' . '/source/Boot/Minify/Web.php',
        'be3e0276455264c302a711e19d872c82' => __DIR__ . '/../..' . '/source/Boot/Minify/App.php',
    );

    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WebPConvert\\' => 12,
        ),
        'S' => 
        array (
            'Source\\' => 7,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'M' => 
        array (
            'MatthiasMullie\\PathConverter\\' => 29,
            'MatthiasMullie\\Minify\\' => 22,
        ),
        'L' => 
        array (
            'League\\Plates\\' => 14,
        ),
        'I' => 
        array (
            'ImageMimeTypeGuesser\\' => 21,
        ),
        'F' => 
        array (
            'Fpdf\\' => 5,
        ),
        'C' => 
        array (
            'CoffeeCode\\Uploader\\' => 20,
            'CoffeeCode\\Router\\' => 18,
            'CoffeeCode\\Paginator\\' => 21,
            'CoffeeCode\\Optimizer\\' => 21,
            'CoffeeCode\\Cropper\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WebPConvert\\' => 
        array (
            0 => __DIR__ . '/..' . '/rosell-dk/webp-convert/src',
        ),
        'Source\\' => 
        array (
            0 => __DIR__ . '/../..' . '/source',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'MatthiasMullie\\PathConverter\\' => 
        array (
            0 => __DIR__ . '/..' . '/matthiasmullie/path-converter/src',
        ),
        'MatthiasMullie\\Minify\\' => 
        array (
            0 => __DIR__ . '/..' . '/matthiasmullie/minify/src',
        ),
        'League\\Plates\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/plates/src',
        ),
        'ImageMimeTypeGuesser\\' => 
        array (
            0 => __DIR__ . '/..' . '/rosell-dk/image-mime-type-guesser/src',
        ),
        'Fpdf\\' => 
        array (
            0 => __DIR__ . '/..' . '/fpdf/fpdf/src/Fpdf',
        ),
        'CoffeeCode\\Uploader\\' => 
        array (
            0 => __DIR__ . '/..' . '/coffeecode/uploader/src',
        ),
        'CoffeeCode\\Router\\' => 
        array (
            0 => __DIR__ . '/..' . '/coffeecode/router/src',
        ),
        'CoffeeCode\\Paginator\\' => 
        array (
            0 => __DIR__ . '/..' . '/coffeecode/paginator/src',
        ),
        'CoffeeCode\\Optimizer\\' => 
        array (
            0 => __DIR__ . '/..' . '/coffeecode/optimizer/src',
        ),
        'CoffeeCode\\Cropper\\' => 
        array (
            0 => __DIR__ . '/..' . '/coffeecode/cropper/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit81ff5e2843da8a9fe25b697e67c025f4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit81ff5e2843da8a9fe25b697e67c025f4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit81ff5e2843da8a9fe25b697e67c025f4::$classMap;

        }, null, ClassLoader::class);
    }
}

<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit63c9214b88ea36f7f4c4d71ec7e16d5f
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'TelegramBot\\Api\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'TelegramBot\\Api\\' => 
        array (
            0 => __DIR__ . '/..' . '/telegram-bot/api/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit63c9214b88ea36f7f4c4d71ec7e16d5f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit63c9214b88ea36f7f4c4d71ec7e16d5f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit63c9214b88ea36f7f4c4d71ec7e16d5f::$classMap;

        }, null, ClassLoader::class);
    }
}

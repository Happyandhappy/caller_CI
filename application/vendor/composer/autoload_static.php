<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit276993f1d623330137658c243792ad4d
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twilio\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twilio\\' => 
        array (
            0 => __DIR__ . '/..' . '/twilio/sdk/Twilio',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit276993f1d623330137658c243792ad4d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit276993f1d623330137658c243792ad4d::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

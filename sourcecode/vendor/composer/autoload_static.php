<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit64db261a97a3ddd32cd78c1a513232fb
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
            0 => __DIR__ . '/..' . '/twilio/sdk/src/Twilio',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit64db261a97a3ddd32cd78c1a513232fb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit64db261a97a3ddd32cd78c1a513232fb::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

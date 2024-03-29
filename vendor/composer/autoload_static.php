<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit33bb2e837f5bff133b486c79ef8b0804
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Passbook\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Passbook\\' => 
        array (
            0 => __DIR__ . '/..' . '/eo/passbook/src/Passbook',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit33bb2e837f5bff133b486c79ef8b0804::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit33bb2e837f5bff133b486c79ef8b0804::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit33bb2e837f5bff133b486c79ef8b0804::$classMap;

        }, null, ClassLoader::class);
    }
}

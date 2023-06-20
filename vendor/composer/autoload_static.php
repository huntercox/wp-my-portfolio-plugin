<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite434ca7a69e77b4503043afd0be16b72
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MyPortfolio\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MyPortfolio\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/MyPortfolio',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'MyPortfolio\\AdminPages\\MenuPage' => __DIR__ . '/../..' . '/src/MyPortfolio/AdminPages/MenuPage.php',
        'MyPortfolio\\AdminPages\\SettingsPage1' => __DIR__ . '/../..' . '/src/MyPortfolio/AdminPages/SettingsPage1.php',
        'MyPortfolio\\AdminPages\\SettingsPage2' => __DIR__ . '/../..' . '/src/MyPortfolio/AdminPages/SettingsPage2.php',
        'MyPortfolio\\AdminPages\\SettingsPage3' => __DIR__ . '/../..' . '/src/MyPortfolio/AdminPages/SettingsPage3.php',
        'MyPortfolio\\MyPortfolio' => __DIR__ . '/../..' . '/src/MyPortfolio/MyPortfolio.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite434ca7a69e77b4503043afd0be16b72::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite434ca7a69e77b4503043afd0be16b72::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite434ca7a69e77b4503043afd0be16b72::$classMap;

        }, null, ClassLoader::class);
    }
}
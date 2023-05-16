<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit658c85d7ee6b9216d9d8ceaa4b199d2b
{
    public static $classMap = array (
        'Pagup\\Bialty\\Controllers\\DomController' => __DIR__ . '/../..' . '/admin/controllers/DomController.php',
        'Pagup\\Bialty\\Controllers\\MetaboxController' => __DIR__ . '/../..' . '/admin/controllers/MetaboxController.php',
        'Pagup\\Bialty\\Controllers\\NoticeController' => __DIR__ . '/../..' . '/admin/controllers/NoticeController.php',
        'Pagup\\Bialty\\Controllers\\SettingsController' => __DIR__ . '/../..' . '/admin/controllers/SettingsController.php',
        'Pagup\\Bialty\\Core\\Asset' => __DIR__ . '/../..' . '/core/Asset.php',
        'Pagup\\Bialty\\Core\\Option' => __DIR__ . '/../..' . '/core/Option.php',
        'Pagup\\Bialty\\Core\\Plugin' => __DIR__ . '/../..' . '/core/Plugin.php',
        'Pagup\\Bialty\\Core\\Request' => __DIR__ . '/../..' . '/core/Request.php',
        'Pagup\\Bialty\\Settings' => __DIR__ . '/../..' . '/admin/settings.php',
        'Pagup\\Bialty\\Traits\\DomHelper' => __DIR__ . '/../..' . '/admin/traits/DomHelper.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit658c85d7ee6b9216d9d8ceaa4b199d2b::$classMap;

        }, null, ClassLoader::class);
    }
}
<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit080e8893984b7a4c1181b058322ef8b1
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit080e8893984b7a4c1181b058322ef8b1', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit080e8893984b7a4c1181b058322ef8b1', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit080e8893984b7a4c1181b058322ef8b1::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}

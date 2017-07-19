<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    use System\IO\FileNotFoundException;
    {
        DEFINED('TemPHPlate') or DIE('Restricted Access');

        /**
         * Requires class-files automatically.
         */
        spl_autoload_register(function ($class)
        {
            $path = null;

            if (!file_exists(($path = GetPath($class))))
            {
                $path = GetPath($class, TemPHPlateNamespace);
            }

            if (file_exists($path))
            {
                require $path;

                if (method_exists($class, 'Initialize'))
                {
                    $class::Initialize();
                }
            }
        });

        /**
         * Tries to determine the specified class.
         *
         * @param string $class
         * The name of the class.
         * 
         * @param string $namespace
         * The namespace of the class.
         * 
         * @param string $basePath
         * The base-path of the namespace.
         * 
         * @return string
         * The path to the specified class.
         */
        function GetPath($class, $namespace = '', $basePath = __DIR__)
        {
            $namespace .= '\\';
            $lastSeparator = strrpos($class, '\\');
            $subNamespace = substr($class, 0, $lastSeparator + 1);
            $class = substr($class, strlen($subNamespace));

            if (substr_compare($subNamespace, $namespace, 0, strlen($namespace)) === 0)
            {
                $subNamespace = substr($subNamespace, strlen($namespace));
            }
        
            $result = str_replace(['\\', '/', '_'], DIRECTORY_SEPARATOR, __DIR__.DIRECTORY_SEPARATOR.$subNamespace.$class).'.php';
            
            return $result;
        }
    }

    /* Files located at special directories */
    require('Properties'.DIRECTORY_SEPARATOR.'Settings.php');
?>
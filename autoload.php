<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    use System\IO\FileNotFoundException;
    {
        require('vendor'.DIRECTORY_SEPARATOR.'autoload.php');

        /**
         * Requires class-files automatically.
         */
        spl_autoload_register(function ($class)
        {
            $path = null;

            if (!file_exists(($path = GetPath($class))))
            {
                if (!file_exists(($path = GetPath($class, 'ManuTh\\TemPHPlate'))))
                {
                    $path = GetPath($class, TemPHPlateNamespace);
                }
            }

            if (file_exists($path))
            {
                require_once $path;

                if (method_exists($class, '__InitializeStatic'))
                {
                    $method = new ReflectionMethod($class, '__InitializeStatic');
                    if ($method->isStatic())
                    {
                        $method->setAccessible(true);
                        $method->invoke(null);
                    }
                    else
                    {
                        $object = (new ReflectionClass($class))->newInstanceWithoutConstructor();
                        $method->invoke($object);
                    }
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
            $lastSeparator = strrpos($class, '\\');
            $subNamespace = substr($class, 0, $lastSeparator + 1);
            $class = substr($class, strlen($subNamespace));
            
            if (strlen($namespace) > 0 && $namespace[strlen($namespace) - 1] != '\\')
            {
                $namespace .= '\\';
            }

            if (substr_compare($subNamespace, $namespace, 0, strlen($namespace)) === 0)
            {
                $subNamespace = substr($subNamespace, strlen($namespace));
                $result = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, __DIR__.DIRECTORY_SEPARATOR.$subNamespace.$class).'.php';
                return $result;
            }
        }
    }

    // /* Files located at special directories */
    // require('Properties'.DIRECTORY_SEPARATOR.'Settings.php');
?>
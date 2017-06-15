<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    use \manuth\TemPHPlate\Properties\Settings;
    use \System\Exception;
    {
        DEFINED('TemPHPlate') or DIE('Restricted Access');

        /**
         * Requires class-files automatically.
         */
        spl_autoload_register(function ($class)
        {
            // The root-namespace of TemPHPlate.
            $namespace = 'manuth\\TemPHPlate\\';

            try
            {
                require GetPath($class);
            }
            catch (Exception $e)
            {
                try
                {
                    require GetPath($class, $namespace, __DIR__.DIRECTORY_SEPARATOR.'TemPHPlate');
                }
                catch (Exception $e)
                {
                    require GetPath($class, TemPHPlateNamespace);
                }
            }

            if (method_exists($class, 'Initialize'))
            {
                $class::Initialize();
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

            if (substr_compare($class, $namespace, 0, strlen($namespace)) == 0)
            {
                $subNamespace = substr($subNamespace, strlen($namespace));
            }

            $class = substr($class, strlen($subNamespace));            
            $result = str_replace(['\\', '/', '_'], DIRECTORY_SEPARATOR, __DIR__.DIRECTORY_SEPARATOR.$subNamespace.$class).'.php';

            if (file_exists($result))
            {
                return $result;
            }
            // ToDo Throw an error if the file's not found
        }
    }

    require('Properties'.DIRECTORY_SEPARATOR.'Settings.php');
?>
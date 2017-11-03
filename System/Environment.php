<?php
    namespace System;
    use System\IO\Path;
    {
        /**
         * Provides information about, and means to manipulate, the current environment and platform.
         */
        class Environment
        {
            /**
             * Gets the path to the root of the document.
             *
             * @var string
             */
            public static $DocumentRoot;

            /**
             * Gets the requested directory.
             * @var string
             */
            public static $RequestDirectory;

            /**
             * Gets the requested file.
             * @var string
             */
            public static $RequestFile;

            /**
             * @ignore
             */
            private static function __InitializeStatic()
            {
                self::$DocumentRoot = Path::Normalize(dirname($_SERVER['PHP_SELF']));
                self::$RequestFile = Path::Normalize(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
                self::$RequestDirectory = Path::Normalize(dirname(self::$RequestFile.'.'));
            }
        }
    }
?>
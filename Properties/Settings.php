<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace ManuTh\TemPHPlate\Properties;
    use System\Web\Forms\MenuBar;
    {
        /**
         * Provides settings for the Project
         */
        class Settings
        {
            /**
             * Gets or sets the locales to use to execute php
             * 
             * @var string[]
             */
            public static $Locales = array
            (
                // Windows-Format
                'de-CH',
                'de-DE',
                // Linux-Format
                'de_CH',
                'de_DE',
                'de_CH.UTF8',
                'de_DE.UTF8'
            );

            /**
             * Gets or sets default menu-bar of the project.
             *
             * @var MenuBar
             */
            public static $MenuBar;

            /**
             * Gets or sets default page to load when the page isn't found.
             *
             * @var string
             */
            public static $FallbackPage = 'Page';

            /**
             * Gets or sets the default icon.
             *
             * @var string
             */
            public static $Icon = '/favicon.ico';

            /**
             * Gets or sets the default apple-touch-icon.
             *
             * @var string
             */
            public static $AppleTouchIcon = null;

            /**
             * @ignore
             */
            public static function __InitializeStatic()
            {
                $menuBarPath = implode(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'Properties', 'MenuBar.json'));
                if (file_exists($menuBarPath))
                {
                    self::$MenuBar = MenuBar::FromJSON(json_decode(file_get_contents($menuBarPath)));
                }
                else
                {
                    self::$MenuBar = new MenuBar();
                }
            }
        }
    }
?>
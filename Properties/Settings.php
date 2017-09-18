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
             * The locales to use to execute php
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
             * The default menu-bar of the project.
             *
             * @var MenuBar
             */
            public static $MenuBar;
            public static $FallbackPage = 'Page';

            /**
             * Initializes the settings.
             *
             * @return void
             */
            public static function Initialize()
            {
                $menuBarPath = implode(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'Properties', 'MenuBar.json'));
                if (file_exists($menuBarPath))
                {
                    self::$MenuBar = MenuBar::FromJSON(json_decode(file_get_contents($menuBarPath))->menuBar);
                }
                else
                {
                    self::$MenuBar = new MenuBar();
                }
            }
        }
    }
?>
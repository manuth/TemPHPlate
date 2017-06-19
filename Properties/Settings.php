<?php
    namespace ManuTh\TemPHPlate\Properties;
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

            /**
             * Initializes the settings.
             *
             * @return void
             */
            public static function Initialize()
            {
                self::$MenuBar = MenuBar::FromJSON('Properties'.DIRECTORY_SEPARATOR.'MenuBar.json');
            }
        }
    }
?>
<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    use ManuTh\TemPHPlate\Properties\Settings;
    {
        /**
         * Represents a page.
         * 
         * @property MenuBar $MenuBar
         * Gets or sets the menu-bar of the page.
         */
        class Page extends WebContent
        {
            /**
             * The menu-bar of the page.
             *
             * @var MenuBar
             */
            private $menuBar;

            public function Page()
            {
                $this->MenuBar = Settings::$MenuBar;
            }

            /**
             * @ignore
             */
            protected function getMenuBar()
            {
                return $this->menuBar;
            }

            /**
             * @ignore
             */
            protected function setMenuBar($value)
            {
                $this->menuBar = $value;
            }

            /**
             * Prints the object.
             *
             * @return void
             */
            protected function PrintInternal()
            {
            }
        }
    }
?>
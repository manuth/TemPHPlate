<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web\Forms;
    use System\Object;
    {
        /**
         * Represents an item of a menu-bar.
         */
        class MenuItem extends Control
        {
            /**
             * Initializes a new instance of the `MenuItem` class.
             */
            public function MenuItem()
            {
            }

            /**
             * Initializes a new instance of the `MenuItem` class with a name and a text.
             *
             * @param string $name
             * The identifier of the menu-item.
             * 
             * @param string $text
             * The text of the menu-item.
             */
            public function MenuItem0(?string $name, ?string $text)
            {
                $this->Name = $id;
                $this->Text = $text;
            }
        }
    }
?>
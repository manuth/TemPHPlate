<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web\Forms;
    {
        /**
         * Represents a menu-item that provides a link to another page.
         */
        class LinkedMenuItem extends MenuItem
        {
            /**
             * Initializes a new instance of the `LinkedMenuItem` class.
             */
            public function LinkedMenuItem()
            {
            }

            /**
             * Initializes a new instance of the `LinkedMenuItem` class with an id, a text and an url.
             *
             * @param string $id
             * The identifier of the menu-item.
             * 
             * @param string $text
             * The text of the menu-item.
             * 
             * @param string $url
             * The url to the page the menu-item refers to.
             */
            public function LinkedMenuItem0(string $id, string $text, string $url)
            {
                $this->Base($id, $text);
                $this->URL = $url;
            }

            /**
             * Gets or sets the `URI` to the page to load.
             *
             * @var string
             */
            public $URL = '';

            /**
             * Gets or sets a value indicating whether to load the page in a new browser-instance.
             *
             * @var boolean
             */
            public $NewTab = false;
        }
    }
?>
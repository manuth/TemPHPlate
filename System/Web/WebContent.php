<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    use System\Globalization\CultureInfo;
    {
        /**
         * Represents content of a website.
         */
        abstract class WebContent extends Printable
        {
            /**
             * Gets or sets the title of the content.
             *
             * @var string
             */
            public $Title = '';

            /**
             * Gets or sets the locale of the content.
             *
             * @var CultureInfo
             */
            public $Locale;

            /**
             * Gets or sets the style-definitions of the content.
             *
             * @var StyleDefinition[]
             */
            public $StyleDefinitions = array();

            /**
             * Gets or sets the script-definitions of the content.
             *
             * @var ScriptDefinition[]
             */
            public $ScriptDefinitions = array();

            /**
             * Gets or sets the template of the content.
             *
             * @var Template
             */
            public $Template;

            /**
             * Initializes a new instance of the WebContent class.
             */
            public function WebContent()
            {
            }

            /**
             * Initializes a new instance of the WebContent class with a template.
             */
            public function WebContent1($template)
            {
                $this->Template = $template;
            }
        }
    }
?>
<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    {
        /**
         * Represents CSS-code.
         */
        class InlineStyle extends StyleDefinition
        {
            /**
             * Gets or sets the CSS-code.
             *
             * @var string
             */
            public $Code;

            /**
             * Initializes a new instance of the InlineStyle class.
             */
            public function InlineStyle()
            {
            }

            /**
             * Initializes a new instance of the InlineStyle class with CSS-code.
             *
             * @param string $code
             * The CSS-code.
             */
            public function InlineStyle1(?string $code)
            {
                $this->Code = $code;
            }

            /**
             * Draws the object.
             *
             * @return string
             * The content of the drawable object.
             */
            public function Draw() : string
            {
                if ($this->Code !== null)
                {
                    return '
                        <style>'.$this->Code.'
                        </style>';
                }
                else
                {
                    return '';
                }
            }
        }
    }
?>
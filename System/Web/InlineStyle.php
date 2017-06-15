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
            public function InlineStyle1($code)
            {
                $this->Code = $code;
            }

            /**
             * Prints the object.
             *
             * @return string
             * The content of the printable object.
             */
            public function Print()
            {
                return '
                    <style>
                        '.$this->Code.'
                    </style>';
            }
        }
    }
?>
<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    {
        /**
         * Represents JavaScript-code.
         */
        class InlineScript extends ScriptDefinition
        {
            /**
             * Gets or sets the JavaScript-code.
             *
             * @var string
             */
            public $Code;

            /**
             * Initializes a new instance of the InlineScript class.
             */
            public function InlineScript()
            {
            }

            /**
             * Initializes a new instance of the InlineScript class with JavaScript-code.
             *
             * @param string $code
             * The JavaScript-code.
             */
            public function InlineScript1($code)
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
                    <script type="text/javascript">
                        '.$this->Code.'
                    </script>';
            }
        }
    }
?>
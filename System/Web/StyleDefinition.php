<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    use System\Object;
    {
        /**
         * Represents a CSS-style-definition.
         */
        abstract class StyleDefinition extends Object implements IDrawable
        {
            /**
             * Genmerates a style-definition from a code-block.
             *
             * @param string $code
             * The code of the style-definition.
             * 
             * @return InlineStyle
             * The style-definition that contains the code.
             */
            public static function FromCode(string $code) : InlineStyle
            {
                return new InlineStyle($code);
            }

            /**
             * Generates a style-definition from a file.
             *
             * @param string $fileName
             * The path to the Cascading StyleSheet-file.
             * 
             * @return StyleSheet
             * The style-definition that contains the file.
             */
            public static function FromFile(string $fileName) : StyleSheet
            {
                return new StyleSheet($fileName);
            }

            /**
             * Draws the object.
             *
             * @return string
             * The content of the drawable object.
             */
            public abstract function Draw() : string;
        }
    }
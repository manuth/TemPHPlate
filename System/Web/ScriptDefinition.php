<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    use System\Object;
    {
        /**
         * Represents a JavaScript-definition.
         */
        abstract class ScriptDefinition extends Object implements IDrawable
        {
            /**
             * Genmerates a script-definition from a code-block.
             *
             * @param string $code
             * The code of the script.
             * 
             * @return InlineScript
             * The script-definition that contains the code.
             */
            public static function FromCode(string $code) : InlineScript
            {
                return new InlineScript($code);
            }

            /**
             * Generates a script-definition from a file.
             *
             * @param string $fileName
             * The path to the script-file.
             * 
             * @return ScriptFile
             * The script-definition that contains the file.
             */
            public static function FromFile(string $fileName) : ScriptFile
            {
                return new ScriptFile($fileName);
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
<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    {
        /**
         * Represents a JavaScript-file.
         */
        class ScriptFile extends ScriptDefinition
        {
            /**
             * Gets or sets the path to the JavaScript-file.
             *
             * @var string
             */
            public $FileName;

            /**
             * Initializes a new instance of the ScriptFile class.
             */
            public function ScriptFile()
            {
            }

            /**
             * Initializes a new instance of the ScriptFile class with a path to the file.
             *
             * @param string $fileName
             * The path to the JavaScript-file.
             */
            public function ScriptFile1(string $fileName)
            {
                $this->FileName = $fileName;
            }

            /**
             * Draws the object.
             *
             * @return string
             * The content of the drawable object.
             */
            public function Draw() : string
            {
                if ($this->FileName != null)
                {
                    return '
                        <script src="'.htmlspecialchars($this->FileName).'"></script>';
                }
                else
                {
                    return '';
                }
            }
        }
    }
?>
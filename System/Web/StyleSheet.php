<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    {
        /**
         * Represents a Cascading StyleSheet-file.
         */
        class StyleSheet extends StyleDefinition
        {
            /**
             * Gets or sets the path to the Cascading StyleSheet-file.
             *
             * @var string
             */
            public $FileName;

            /**
             * Initializes a new instance of the StyleSheet class.
             */
            public function StyleSheet()
            {
            }

            /**
             * Initializes a new instance of the StyleSheet class with a path to the file.
             *
             * @param string $fileName
             * The path to the Cascading StyleSheet-file.
             */
            public function StyleSheet1(string $fileName)
            {
                $this->FileName = $fileName;
            }

            /**
             * Prints the object.
             *
             * @return string
             * The content of the printable object.
             */
            public function Print() : string
            {
                return '
                    <link href="'.htmlspecialchars($this->FileName).'" rel="stylesheet" />';
            }
        }
    }
?>
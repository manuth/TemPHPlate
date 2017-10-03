<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache
     */
    namespace System\YAML;
    use System\Object;
    use Mni\FrontYAML\Document;
    {
        /**
         * Represents a document.
         * 
         * @property-read array $YAML
         * Gets the YAML variables of the document.
         * 
         * @property-read string $Content
         * Gets the content of the document.
         */
        class YAMLDocument extends Object
        {
            /**
             * The inner document.
             *
             * @var Document
             */
            private $document;

            /**
             * Initializes a new instance of the `YAMLDocument` class with YAML-variables and a content.
             *
             * @param array $yaml
             * The YAML variables of the document.
             * 
             * @param string $content
             * The content of the document.
             */
            public function YAMLDocument(array $yaml, string $content)
            {
                $this->document = new Document($yaml, $content);
            }

            /**
             * @ignore
             */
            public function getYAML()
            {
                return $this->document->getYAML();
            }

            /**
             * @ignore
             */
            public function getContent()
            {
                return $this->document->getContent();
            }
        }
    }
?>
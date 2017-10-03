<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache
     */
    namespace System\YAML;
    use System\Object;
    use Mni\FrontYAML\Parser;
    use Mni\FrontYAML\YAML;
    use Mni\FrontYAML\Markdown\MarkdownParser;
    {
        /**
         * Provides a YAML-parser.
         */
        class YAMLParser extends Object
        {
            /**
             * The parser.
             *
             * @var Parser
             */
            private $parser;

            /**
             * Gets a default instance of the `YAMLParser` class.
             *
             * @var self
             */
            public static $Default;

            public $Type;

            /**
             * Initializes a new instance of the `YAMLPArser` class.
             */
            public function YAMLParser()
            {
                $this->parser = new Parser();
            }

            /**
             * Initializes a new instance of the `YAMLParser` class with a YAMl-parser and a Markdown-parser.
             *
             * @param YAML\YAMLParser $yamlParser
             * Either a `YAMLParser` or **null** in order to use the default parser.
             * 
             * @param MarkdownParser $markdownParser
             * Either `MarkdownParser` or **null** in order to use the default parser.
             */
            public function YAMLParser1(?YAML\YAMLParser $yamlParser, ?MarkdownParser $markdownParser)
            {
                $this->parser = new Parser($yamlParser, $markdownParser);
            }

            /**
             * Parses the specified YAML string to a `YAMLDocument`.
             * 
             * @param string $value
             * The YAML to be deserialized.
             *
             * @return YAMLDocument
             * The deserialized `YAMLDocument`.
             */
            public function Parse(string $value, bool $parseMarkdown = false)
            {
                $document = $this->parser->parse($value, $parseMarkdown);
                return new YAMLDocument($document->getYAML(), $document->getContent());
            }

            /**
             * @ignore
             */
            public static function __InitializeStatic()
            {
                self::$Default = new self();
            }
        }
    }
?>
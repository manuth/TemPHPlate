<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache
     */
    namespace System\Web;
    use System\Collections\{
        ArrayList,
        Dictionary,
        KeyValuePair
    };
    use System\IO\Path;
    use System\YAML\YAMLDocument;
    use System\YAML\YAMLParser;
    use Mni\FrontYAML\Bridge\Parsedown\ParsedownParser;
    {
        /**
         * Represents a webpage that wraps a file.
         * 
         * @property-read DocumentType $DocumentType
         * Gets the type of the document that is wrapped by this page.
         * 
         * @property-read array $Data
         * Gets the YAML-variables of the document.
         */
        class DocumentPage extends Page
        {
            /**
             * The regular expression for searching for variables.
             */
            private const variableExpression = '/{{\\s*([^}]*?)\\s*}}/';

            /**
             * The regular expression for searching for functions.
             */
            private const functionExpression = '/{%\\s*([^}]*?)\\s*%}/';
            
            /**
             * The document that is wrapped by this page.
             *
             * @var YAMLDocument
             */
            private $document;

            /**
             * The type of the document that is wrapped by this page.
             *
             * @var DocumentType
             */
            private $documentType;

            /**
             * Initializes a new instance of the `DocumentPage` class with a filename.
             *
             * @param string $fileName
             * The fully qualified path to the file that is to be wrapped by the page.
             */
            public function DocumentPage(string $fileName)
            {
                $this->documentType = self::DetectDocumentType($fileName);
                $this->document = YAMLParser::$Default->Parse(file_get_contents($fileName));

                if (array_key_exists('Template', $this->Data))
                {
                    $templateClasses = new ArrayList(array(
                        DefaultNamespace.'\\Templates\\'.$this->Data['Template'],
                        TemPHPlateNamespace.'\\Templates\\'.$this->Data['Template']));
                    
                    $templateClass = $templateClasses->First(
                        function ($class)
                        {
                            return class_exists($class);
                        });
                    
                    $this->Template = new $templateClass($this);
                }
            }

            /**
             * @ignore
             */
            public function getDocumentType()
            {
                return $this->documentType;
            }

            /**
             * @ignore
             */
            public function getData()
            {
                return $this->document->YAML;
            }

            /**
             * Determines the `DocumentType` of a file.
             *
             * @param string $fileName
             * The fully qualified path to the file whose `DocumentType` is to be detected.
             * 
             * @return DocumentType
             * The `DocumentType` of the file.
             */
            private static function DetectDocumentType(string $fileName) : DocumentType
            {
                $dictionary = new Dictionary();
                $dictionary->Add(
                    DocumentType::$PHP,
                    new ArrayList(array('php', 'php3', 'php4', 'php5', 'inc')));
                $dictionary->Add(
                    DocumentType::$MarkDown,
                    new ArrayList(array('markdown', 'mdown', 'mkdn', 'mkd', 'md')));
                $dictionary->Add(
                    DocumentType::$HTML,
                    new ArrayList(array('html', 'htm', 'xhtml')));
                $dictionary->Add(
                    DocumentType::$Other,
                    new ArrayList(array('txt')));

                return $dictionary->First(
                    function (KeyValuePair $keyValuePair) use ($fileName)
                    {
                        return $keyValuePair->Value->Any(
                            function ($value) use ($fileName)
                            {
                                return preg_match("/\.$value$/", $fileName) > 0;
                            }
                        );
                    })->Key;
            }

            /**
             * Draws the object.
             *
             * @return void
             */
            protected function DrawInternal()
            {
                $variableReplacer = function (array $match)
                {
                    $variableName = $match[1];

                    if ($variableName == 'base')
                    {
                        return Path::MakeRelativeWebPath(Environment::$RequestDirectory, Environment::$DocumentRoot);
                    }
                    else if (array_key_exists($variableName, $this->Data))
                    {
                        return $this->Data[$variableName];
                    }
                };

                $functionReplacer = function (array $match)
                {
                    ob_start();
                    eval($match[1]);
                    return ob_get_clean();
                };

                $content = $this->document->Content;

                if ($this->DocumentType == DocumentType::$PHP)
                {
                    $content = eval('?>'.$content);
                }
                else
                {
                    $content = preg_replace_callback(self::variableExpression, $variableReplacer, $content);
                    $content = preg_replace_callback(self::functionExpression, $functionReplacer, $content);

                    if ($this->DocumentType == DocumentType::$MarkDown)
                    {
                        $content = (new ParsedownParser())->parse($content);
                    }
                }

                echo $content;
            }
        }
    }
?>
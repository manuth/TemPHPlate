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
    use System\Environment;
    use System\Globalization\CultureInfo;
    use System\IO\Path;
    use System\YAML\YAMLDocument;
    use System\YAML\YAMLParser;
    use Mni\FrontYAML\Bridge\Parsedown\ParsedownParser;
    {
        /**
         * Represents a webpage that wraps a file.
         * 
         * @property-read string $FileName
         * Gets the fully qualified path to the document that is wrapped by this page.
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
            private const variableExpression = '/{{[\\s]*([\\s\\S]*?)[\\s]*}}/';

            /**
             * The regular expression for searching for functions.
             */
            private const functionExpression = '/{%[\\s]*([\\s\\S]*?)[\\s]*%}/';
            
            /**
             * The document that is wrapped by this page.
             *
             * @var YAMLDocument
             */
            private $document;

            /**
             * The fully qualified path to the document that is wrapped by this page.
             *
             * @var string
             */
            private $fileName;

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
                $this->FileName = $fileName;
                $this->documentType = self::DetectDocumentType($fileName);
                $this->document = YAMLParser::$Default->Parse(file_get_contents($fileName));

                foreach ($this->Data as $key => $value)
                {
                    switch ($key)
                    {
                        case 'Title':
                        case 'Icon':
                        case 'AppleTouchIcon':
                            $this->$key = $value;
                            break;
                        case 'Locale':
                            $this->Locale = new \System\Globalization\CultureInfo($value);
                            break;
                        case 'Template':
                            $templateClasses = new ArrayList(array(
                                DefaultNamespace.'\\Templates\\'.$this->Data['Template'],
                                TemPHPlateNamespace.'\\Templates\\'.$this->Data['Template'],
                                'Templates\\'.$this->Data['Template']));
                            
                            $templateClass = $templateClasses->First(
                                function ($class)
                                {
                                    return class_exists($class);
                                });
                            
                            $this->Template = new $templateClass($this);
                            break;
                    }
                }
            }

            /**
             * @ignore
             */
            public function getFileName()
            {
                return $this->fileName;
            }

            /**
             * @ignore
             */
            protected function setFileName(string $value)
            {
                $this->fileName = $value;
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
                    ob_start();
                    $dir = getcwd();
                    chdir(dirname($this->FileName));
                    include $this->FileName;
                    chdir($dir);
                    $this->document = YAMLParser::$Default->Parse(ob_get_clean());
                    $content = $this->document->Content;
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

                if ($this->DocumentType == DocumentType::$Other)
                {
                    $content = nl2br(htmlspecialchars($content));
                }

                echo $content;
            }
        }
    }
?>
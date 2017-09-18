<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    use System\Globalization\CultureInfo;
    use System\Collections\ArrayList;
    {
        /**
         * Represents content of a website.
         */
        abstract class WebContent extends Drawable
        {
            /**
             * Gets or sets the title of the content.
             *
             * @var string
             */
            public $Title = '';

            /**
             * Gets or sets the locale of the content.
             *
             * @var CultureInfo
             */
            public $Locale;

            /**
             * Gets or sets the style-definitions of the content.
             *
             * @var StyleCollection
             */
            public $StyleDefinitions;

            /**
             * Gets or sets the script-definitions of the content.
             *
             * @var ScriptCollection
             */
            public $ScriptDefinitions;

            /**
             * Gets or sets the template of the content.
             *
             * @var Template
             */
            public $Template;

            /**
             * Initializes a new instance of the WebContent class.
             */
            public function WebContent()
            {
                $this->StyleDefinitions = new StyleCollection();
                $this->ScriptDefinitions = new ScriptCollection();
            }

            /**
             * Initializes a new instance of the WebContent class with a template.
             * 
             * @param Template $template
             * The template of the WebContent.
             */
            public function WebContent1(Template $template)
            {
                $this->Template = $template;
            }
            
            /**
             * Returns all StyleDefinitions of the content.
             *
             * @return StyleCollection
             */
            protected function FetchStyles() : StyleCollection
            {
                $styles = new ArrayList();

                for ($content = $this; $content != null; $content = $content->Template)
                {
                    $styles->AddRange($content->StyleDefinitions);
                }

                $collection = new StyleCollection();
                $collection->AddRange($styles->Distinct());
                return $collection;
            }
                        
            /**
             * Returns all ScriptDefinitions of the content.
             *
             * @return ScriptCollection
             */
            protected function FetchScripts() : ScriptCollection
            {
                $scripts = new ArrayList();

                for ($content = $this; $content != null; $content = $content->Template)
                {
                    $scripts->AddRange($content->ScriptDefinitions);
                }

                $collection = new ScriptCollection();
                $collection->AddRange($scripts->Distinct());
                return $collection;
            }

            /**
             * Draws the object.
             *
             * @return string
             * The content of the drawable object.
             */
            public final function Draw() : string
            {
                $content;
                $formatter;

                if ($this->Template === null)
                {
                    $content = parent::Draw();

                    $formatter = function (string $content)
                    {
                        return "
                        <html lang=\"{$this->Locale}\">
                            <head>
                                <title>{$this->Title}</title>
                                {$this->FetchStyles()->Draw()}
                            </head>
                            <body>
                                {$content}
                                {$this->FetchScripts()->Draw()}
                            </body>
                        </html>";
                    };
                }
                else
                {
                    $content = $this->Template->Draw();

                    $formatter = function ($content)
                    {
                        return $content;
                    };
                }

                return $formatter($content);
            }
        }
    }
?>
<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    use System\Globalization\CultureInfo;
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
             * Draws the object.
             *
             * @return string
             * The content of the drawable object.
             */
            public final function Draw() : string
            {
                $formatter;

                if ($this->Template === null)
                {
                    $styleDefinitions = new StyleCollection();
                    $scriptDefinitions = new ScriptCollection();

                    for ($template = $this; $template != null; $template = $template->Template)
                    {
                        $styleDefinitions->AddRange($template->StyleDefinitions);
                        $scriptDefinitions->AddRange($template->ScriptDefinitions);
                    }

                    $formatter = function ($content) use ($styleDefinitions, $scriptDefinitions)
                    {
                        return "
                        <html lang=\"{$this->Locale}\">
                            <head>
                                <title>{$this->Title}</title>
                                {$styleDefinitions->Draw()}
                            </head>
                            <body>
                                {$content}
                                {$scriptDefinitions->Draw()}
                            </body>
                        </html>";
                    };
                }
                else
                {
                    $formatter = function ($content)
                    {
                        return $content;
                    };
                }
                
                return $formatter(parent::Draw());
            }
        }
    }
?>
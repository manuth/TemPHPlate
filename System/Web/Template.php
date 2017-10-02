<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    use System\Globalization\CultureInfo;
    use System\Web\Forms\Rendering\Renderer;
    use System\Web\Forms\Rendering\IRenderer;
    use System\Web\Forms\Rendering\IRenderable;
    {
        /**
         * Represents a template.
         * 
         * @property WebContent $Content
         * Gets or sets the content of the template.
         * 
         * @property-read Page $Page
         * Gets or sets the page of the template.
         */
        class Template extends WebContent
        {
            /**
             * The content of the template.
             *
             * @var WebContent
             */
            private $content;

            /**
             * Initializes a new instance of the template class with content.
             *
             * @param WebContent $content
             * The content of the template.
             */
            public function Template1(WebContent $content)
            {
                $this->Content = $content;

                if ($this->Page instanceof Page)
                {
                    $this->Page->Renderer = $this->Renderer;
                }
            }
            
            /**
             * The renderer of the page.
             *
             * @var IRenderer
             */
            public $Renderer;

            /**
             * @ignore
             */
            protected function getContent() : WebContent
            {
                return $this->content;
            }

            /**
             * @ignore
             */
            protected function setContent(WebContent $content)
            {
                $this->content = $content;
            }

            /**
             * @ignore
             */
            public function getPage() : WebContent
            {
                if ($this->Content instanceof Template)
                {
                    return $this->Content->Page;
                }
                else
                {
                    return $this->Content;
                }
            }

            /**
             * @ignore
             */
            public function getTitle() : string
            {
                return $this->Page->Title;
            }

            
            /**
             * @ignore
             */
            public function setTitle(string $value)
            {
                $this->Page->Title = $value;
            }

            
            /**
             * @ignore
             */
            public function getLocale() : CultureInfo
            {
                return $this->Page->Locale;
            }

            
            /**
             * @ignore
             */
            public function setLocale(CultureInfo $value)
            {
                $this->Page->Locale = $value;
            }

            /**
             * @ignore
             */
            public function getIcon() : string
            {
                return $this->Page->Icon;
            }

            
            /**
             * @ignore
             */
            public function setIcon(string $value)
            {
                $this->Page->Icon = $value;
            }

            
            /**
             * @ignore
             */
            public function getAppleTouchIcon() : string
            {
                return $this->Page->AppleTouchIcon;
            }

            
            /**
             * @ignore
             */
            public function setAppleTouchIcon(string $value)
            {
                $this->Page->AppleTouchIcon = $value;
            }

            /**
             * Initializes the object.
             */
            protected function __Initialize()
            {
                parent::__Initialize();
                $this->Renderer = new Renderer();
                unset($this->Title);
                unset($this->Locale);
                unset($this->Icon);
                unset($this->AppleTouchIcon);
            }
            
            /**
             * Draws the object.
             *
             * @return void
             */
            public function DrawInternal()
            {
                return $this->Content->DrawInternal();
            }
            
            /**
             * Returns all StyleDefinitions of the content.
             *
             * @return StyleCollection
             */
            protected function FetchStyles() : StyleCollection
            {
                return $this->Page->FetchStyles();
            }
            
            /**
             * Returns all ScriptDefinitions of the content.
             *
             * @return ScriptCollection
             */
            protected function FetchScripts() : ScriptCollection
            {
                return $this->Page->FetchScripts();
            }
        }
    }
?>
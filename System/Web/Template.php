<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    use System\Globalization\CultureInfo;
    use System\Web\Forms\Control;
    use System\Web\Forms\MenuBar;
    use System\Web\Forms\Rendering\Renderer;
    use System\Web\Forms\Rendering\IRenderer;
    use System\Web\Forms\Rendering\IRenderable;
    {
        /**
         * Represents a template.
         * 
         * @property Page $Content
         * Gets or sets the content of the template.
         * 
         * @property-read Page $Page
         * Gets or sets the page of the template.
         */
        class Template extends Page
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
            }

            /**
             * @ignore
             */
            public function getContent() : WebContent
            {
                return $this->content;
            }

            /**
             * @ignore
             */
            public function setContent(WebContent $content)
            {
                $this->content = $content;
            }

            /**
             * @ignore
             */
            public function getTitle() : ?string
            {
                return $this->Content->Title;
            }

            
            /**
             * @ignore
             */
            public function setTitle(?string $value)
            {
                $this->Content->Title = $value;
            }

            
            /**
             * @ignore
             */
            public function getLocale() : ?CultureInfo
            {
                return $this->Content->Locale;
            }

            
            /**
             * @ignore
             */
            public function setLocale(?CultureInfo $value)
            {
                $this->Content->Locale = $value;
            }

            /**
             * @ignore
             */
            public function getIcon() : ?string
            {
                return $this->Content->Icon;
            }

            
            /**
             * @ignore
             */
            public function setIcon(?string $value)
            {
                $this->Content->Icon = $value;
            }

            
            /**
             * @ignore
             */
            public function getAppleTouchIcon() : ?string
            {
                return $this->Content->AppleTouchIcon;
            }

            
            /**
             * @ignore
             */
            public function setAppleTouchIcon(?string $value)
            {
                $this->Content->AppleTouchIcon = $value;
            }
            
            /**
             * @ignore
             */
            public function getMenuBar()
            {
                return $this->Content->MenuBar;
            }

            /**
             * @ignore
             */
            public function setMenuBar(MenuBar $value)
            {
                $this->Content->MenuBar = $value;
            }
            
            /**
             * @ignore
             */
            public function getSupportsMenuBar()
            {
                return $this->Content->SupportsMenuBar;
            }

            /**
             * @ignore
             */
            public function setRenderer(Renderer $value)
            {
                parent::setRenderer($value);
                $this->Content->Renderer = $value;
            }
            
            /**
             * Renders a renderable item.
             *
             * @param Control $item
             * The item to render.
             * 
             * @return string
             * A string that represents the rendered item.
             */
            public function Render(Control $item) : string
            {
                return $this->Content->Render($item);
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
             * Determines the head of the content.
             *
             * @return string
             * The head of the content.
             */
            protected function FetchHead() : string
            {
                return $this->Content->FetchHead();
            }
            
            /**
             * Returns all StyleDefinitions of the content.
             *
             * @return StyleCollection
             */
            protected function FetchStyles() : StyleCollection
            {
                return $this->Content->FetchStyles();
            }
            
            /**
             * Returns all ScriptDefinitions of the content.
             *
             * @return ScriptCollection
             */
            protected function FetchScripts() : ScriptCollection
            {
                return $this->Content->FetchScripts();
            }
        }
    }
?>
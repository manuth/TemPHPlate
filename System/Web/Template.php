<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    {
        /**
         * Represents a template.
         * 
         * @property WebContent $Content
         * Gets or sets the content of the template.
         * 
         * @property-read WebContent $Page
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
            }


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
                $this->Title = &$content->Title;
                $this->Locale = &$content->Locale;
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

            /**
             * Draws the object.
             *
             * @return void
             */
            public function DrawInternal()
            {
                return $this->Content->DrawInternal();
            }
        }
    }
?>
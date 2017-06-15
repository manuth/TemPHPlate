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
         * @property-read WebContent $Page
         * Gets or sets the page of the template.
         */
        class Template extends WebContent
        {
            /**
             * Gets or sets the content of the template.
             *
             * @var WebContent
             */
            public $Content;

            /**
             * Initializes a new instance of the template class with content.
             *
             * @param WebContent $content
             * The content of the template.
             */
            public function Template1($content)
            {
                $this->Content = $content;
            }

            /**
             * @ignore
             */
            public function getPage()
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

            public function PrintInternal()
            {
                
            }
        }
    }
?>
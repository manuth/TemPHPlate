<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace ManuTh\TemPHPlate\Templates;
    use System\Web\StyleDefinition;
    use System\Web\ScriptDefinition;
    use System\Web\Template;
    use System\Web\WebContent;
    {
        /**
         * Provides a template that uses the Bootstrap-framework.
         */
        class BootstrapTemplate extends Template
        {
            /**
             * Initializes a new instance of the `BootstrapTemplate` class with a content.
             *
             * @param WebContent $content
             * The content this template is assigned to.
             */
            public function BootstrapTemplate(WebContent $content)
            {
                $this->Base($content);
                $this->StyleDefinitions->AddRange(
                    array(
                        StyleDefinition::FromFile('https://getbootstrap.com/dist/css/bootstrap.min.css'),
                        StyleDefinition::FromCode(
                            '
                            body
                            {
                                padding-top: 5rem;
                            }
                            
                            html
                            {
                                height: 100%;
                            }')));
                $this->ScriptDefinitions->AddRange(
                    array(
                        ScriptDefinition::FromFile('https://code.jquery.com/jquery-3.2.1.slim.min.js'),
                        ScriptDefinition::FromFile('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js'),
                        ScriptDefinition::FromFile('https://getbootstrap.com/dist/js/bootstrap.min.js')));
            }

            /**
             * @ignore
             */
            public function getHead() : string
            {
                return '
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">';
            }
            
            /**
             * Initializes the object.
             */
            protected function __Initialize()
            {
                parent::__Initialize();
                $this->Renderer = new Rendering\BootstrapRenderer();
            }

            /**
             * Draws the object.
             *
             * @return void
             */
            function DrawInternal()
            {
                echo $this->Render($this->Page->MenuBar);
                echo '
                    <div class="container">';
                parent::DrawInternal();
                echo '
                    </div>';
            }
        }
    }
?>
<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace ManuTh\TemPHPlate\Pages;
    use System\Web;
    use System\Web\Forms\Rendering\PaintEventArgs;
    use System\Web\Forms\MenuItem;
    use ManuTh\TemPHPlate\Templates\BootstrapTemplate;
    {
        /**
         * A page
         */
        class Page extends Web\Page
        {
            /**
             * Initializes a new instance of the `Page` class.
             */
            public function Page()
            {
                $this->Template = new BootstrapTemplate($this);
                $this->Renderer->Paint->Add(\Closure::fromCallable(array($this, 'OnItemPaint')));
            }

            private function OnItemPaint($sender, PaintEventArgs $e)
            {
                if ($e->Item instanceof MenuItem)
                {
                    if ($e->Item->Name == 'home')
                    {
                        $e->Cancel = true;
                    }
                }
            }

            /**
             * Draws the object.
             *
             * @return void
             */
            protected function DrawInternal()
            {
                echo '
                    <div class="container">
                        <h1>Hello</h1>
                        World
                    </div>';
            }
        }
    }
?>
<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace ManuTh\TemPHPlate\Pages\Documents;
    use System\Web;
    use ManuTh\TemPHPlate\Templates\BootstrapTemplate;
    {
        /**
         * A page
         */
        class Page extends Web\Page
        {
            /**
             * Initializes a new instance of the `Page` class.
             *
             * @return void
             */
            public function Page()
            {
                $this->Template = new BootstrapTemplate($this);
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
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

            /**
             * @ignore
             */
            public function __Initialize() : array
            {
                return array('Template' => new BootstrapTemplate($this));
            }
        }
    }
?>
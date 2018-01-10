<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace MyCompany\MyWebsite\Pages;
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
                $this->Title = 'TemPHPlate';
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
                    <h1>'.$this->Title.'</h1>
                    <p>
                        <img src="./meme.jpg" />
                    </p>
                    <p>
                        Next you may wanna edit your menu-bar.<br />
                        Open up <code>/Properties/MenuBar.json</code> for doing so.
                    </p>';
            }
        }
    }
?>
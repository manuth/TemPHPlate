<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    use ManuTh\TemPHPlate\Properties\Settings;
    use System\Globalization\CultureInfo;
    use System\Web\Forms\Control;
    use System\Web\Forms\MenuBar;
    use System\Web\Forms\Rendering\Renderer;
    use System\Web\Forms\Rendering\IRenderer;
    use System\Web\Forms\Rendering\IRenderable;
    {
        /**
         * Represents a page.
         * 
         * @property MenuBar $MenuBar
         * Gets or sets the menu-bar of the page.
         * 
         * @property-read bool $SupportsMenuBar
         * Gets a value indicating whether the page supports menu-bars.
         * 
         * @property Renderer $Renderer
         * Gets or sets the renderer of the page.
         */
        class Page extends WebContent implements IRenderer
        {
            /**
             * The menu-bar of the page.
             *
             * @var MenuBar
             */
            private $menuBar;

            /**
             * Gets or sets the renderer of the page.
             *
             * @var IRenderer
             */
            private $renderer;

            /**
             * Initializes a new instance of the `Page` class.
             */
            public function Page()
            {
            }

            /**
             * @ignore
             */
            public function getMenuBar()
            {
                return $this->menuBar;
            }

            /**
             * @ignore
             */
            public function setMenuBar(MenuBar $value)
            {
                $this->menuBar = $value;
            }

            /**
             * @ignore
             */
            public function getSupportsMenuBar()
            {
                return true;
            }

            /**
             * @ignore
             */
            public function getRenderer() : Renderer
            {
                return $this->renderer;
            }

            /**
             * @ignore
             */
            public function setRenderer(Renderer $value)
            {
                $this->renderer = $value;
            }
            
            /**
             * Draws the object.
             *
             * @return void
             */
            protected function DrawInternal()
            {
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
                if (!($item instanceof MenuBar) || $this->SupportsMenuBar)
                {
                    return $this->Renderer->Render($item);
                }
            }

            /**
             * @ignore
             */
            private function __Initialize() : array
            {
                return array(
                    'renderer' => new Renderer(),
                    'menuBar' => Settings::$MenuBar);
            }
        }
    }
?>
<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    use ManuTh\TemPHPlate\Properties\Settings;
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
         */
        class Page extends WebContent implements IRenderer
        {
            /**
             * The menu-bar of the page.
             *
             * @var MenuBar
             */
            private $menuBar;

            public function Page()
            {
            }

            /**
             * Gets or sets the renderer of the page.
             *
             * @var IRenderer
             */
            public $Renderer;

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
             * Renders a renderable item.
             *
             * @param IRenderable $item
             * The item to render.
             * 
             * @return string
             * A string that represents the rendered item.
             */
            public function Render(IRenderable $item) : string
            {
                return $this->Renderer->Render($item);
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
             * Initializes the object.
             */
            protected function __Initialize()
            {
                parent::__Initialize();
                $this->Renderer = new Renderer();
                $this->MenuBar = Settings::$MenuBar;
            }
        }
    }
?>
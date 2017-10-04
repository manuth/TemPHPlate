<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    use ManuTh\TemPHPlate\Properties\Settings;
    use System\Globalization\CultureInfo;
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
         */
        abstract class Page extends WebContent implements IRenderer
        {
            /**
             * The menu-bar of the page.
             *
             * @var MenuBar
             */
            private $menuBar;

            /**
             * Initializes a new instance of the `Page` class.
             */
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
             * @ignore
             */
            public function getSupportsMenuBar()
            {
                return true;
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
                    'Renderer' => new Renderer(),
                    'Locale' => CultureInfo::GetCurrentCulture(),
                    'Icon' => Settings::$Icon,
                    'AppleTouchIcon' => Settings::$AppleTouchIcon,
                    'MenuBar' => Settings::$MenuBar);
            }
        }
    }
?>
<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web\Forms\Rendering;
    use System\Object;
    use System\Web\Forms\Control;
    use System\Web\Forms\MenuBar;
    use System\Web\Forms\MenuItem;
    use System\Web\Forms\MenuItemGroup;
    use System\Web\Forms\MenuItemSeparator;
    use System\Web\Forms\LinkedMenuItem;
    {
        /**
         * Provides the functionality to render renderable items.
         */
        class Renderer extends Object implements IRenderer
        {
            /**
             * The paint-eventhandler.
             *
             * @var PaintEventHandler
             */
            private $paint;

            /**
             * Initializes a new instance of the `Renderer` class.
             */
            public function Renderer()
            {
            }

            /**
             * @ignore
             */
            public function getPaint()
            {
                return $this->paint;
            }

            /**
             * @ignore
             */
            private function setPaint($value)
            {
                $this->paint = $value;
            }

            /**
             * Renders a renderable item.
             *
             * @param Control $item
             * The item that is to be rendered.
             * 
             * @return string
             * A string that represents the rendered item.
             */
            public function Render(Control $item) : string
            {
                $eventArgs = new PaintEventArgs($item);
                ($this->Paint)($this, $eventArgs);

                if (!$eventArgs->Cancel && $item->Visible)
                {
                    return $this->RenderComponent($item);
                }
                else
                {
                    return '';
                }
            }
            
            /**
             * @ignore
             */
            public function __Initialize() : array
            {
                return array('Paint' => new PaintEventHandler());
            }

            /**
             * Renders a Control.
             *
             * @param Control $control
             * The Control that is to be rendered.
             * 
             * @return string
             * A string that represents the rendered control.
             */
            protected function RenderComponent0(Control $control) : string
            {
                return $control->Text;
            }
            
            /**
             * Renders a MenuBar.
             *
             * @param MenuBar $menuBar
             * The MenuBar that is to be rendered.
             * 
             * @return string
             * A string that represents the rendered item.
             */
            protected function RenderComponent1(MenuBar $menuBar) : string
            {
                $result =
                    "<ul>
                        {$menuBar->Text}";
                foreach ($menuBar->Items as $item)
                {
                    $result .= $this->Render($item);
                }

                $result .= '
                    </ul>';
                return $result;
            }
            
            /**
             * Renders a MenuItemGroup.
             *
             * @param MenuItemGroup $menuItem
             * The MenuItemGroup that is to be rendered.
             * 
             * @return string
             * A string that represents the rendered item.
             */
            protected function RenderComponent2(MenuItemGroup $menuItem) : string
            {
                $result =
                    "<li>
                        <ul>
                            {$menuItem->Text}";
                foreach ($menuItem->Items as $item)
                {
                    $result .= $this->Render($item);
                }

                $result .= '
                        </ul>
                    </li>';
                return $result;
            }

            /**
             * Renders a MenuItem.
             *
             * @param MenuItem $menuItem
             * The MenuItem that is to be rendered.
             * 
             * @return string
             * A string that represents the rendered item.
             */
            protected function RenderComponent3(MenuItem $menuItem)
            {
                return "
                    <li>{$menuItem->Text}</li>";
            }

            /**
             * Renders a LinkedMenuItem.
             *
             * @param LinkedMenuItem $menuItem
             * The LinkedMenuItem that is to be rendered.
             * 
             * @return string
             * A string that represents the rendered item.
             */
            protected function RenderComponent4(LinkedMenuItem $menuItem)
            {
                return '
                    <li><a href="'.htmlspecialchars($menuItem->URL).'"'.($menuItem->NewTab ? ' target="_blank"' : '').'>'.htmlspecialchars($menuItem->Text).'</a></li>';
            }

            /**
             * Renders a MenuItemSeparator.
             *
             * @param MenuItemSeparator $menuItem
             * The MenuItemSeparator that is to be rendered.
             * 
             * @return string
             * A string that represents the rendered item.
             */
            protected function RenderComponent5(MenuItemSeparator $menuItem)
            {
                return '
                    <li><hr /></li>';
            }
        }
    }
?>
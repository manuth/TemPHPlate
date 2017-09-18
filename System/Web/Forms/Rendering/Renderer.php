<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web\Forms\Rendering;
    use System\Object;
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
             * Initializes a new instance of the `Renderer` class.
             */
            public function Renderer()
            {
            }

            /**
             * Renders a renderable item.
             *
             * @param IRenderable $item
             * The item that is to be rendered.
             * 
             * @return string
             * A string that represents the rendered item.
             */
            public function Render(IRenderable $item) : string
            {
                return $this->RenderComponent($item);
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
            protected function RenderComponent0(MenuBar $menuBar) : string
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
            protected function RenderComponent1(MenuItemGroup $menuItem) : string
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
            protected function RenderComponent2(MenuItem $menuItem)
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
            protected function RenderComponent3(LinkedMenuItem $menuItem)
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
            protected function RenderComponent4(MenuItemSeparator $menuItem)
            {
                return '
                    <li><hr /></li>';
            }
        }
    }
?>
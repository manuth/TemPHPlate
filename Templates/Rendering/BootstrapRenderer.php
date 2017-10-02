<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace ManuTh\TemPHPlate\Templates\Rendering;
    use System\Environment;
    use System\Web\Forms\MenuBar;
    use System\Web\Forms\MenuItem;
    use System\Web\Forms\LinkedMenuItem;
    use System\Web\Forms\MenuItemGroup;
    use System\Web\Forms\MenuItemSeparator;
    use System\Web\Forms\Rendering\Renderer;
    {
        /**
         * Provides the functionality to render components for the bootstrap-framework.
         */
        class BootstrapRenderer extends Renderer
        {
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
                $text = htmlspecialchars($menuBar->Text);
                $name = htmlspecialchars($menuBar->Name);
                $result = '
                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
                        <div class="container">
                            <a class="navbar-brand" href="'.htmlspecialchars($menuBar->URL).'">'.$text.'</a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#'.$name.'" aria-controls="'.$name.'" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="'.$name.'">
                                <ul class="navbar-nav mr-auto">';

                foreach ($menuBar->Items as $item)
                {
                    $result .= $this->Render($item);
                }

                $result .= '
                                </ul>
                            </div>
                        </div>
                    </nav>';
                
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
                $name = htmlspecialchars($menuItem->Name);
                $text = htmlspecialchars($menuItem->Text);
                $result = '
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="'.$name.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$text.'</a>
                        <div class="dropdown-menu" aria-labelledby="'.$name.'">';
                
                foreach ($menuItem->Items as $item)
                {
                    $result .= $this->RenderSubItem($item);
                }

                $result .= '
                        </div>
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
            protected function RenderComponent3(MenuItem $menuItem) : string
            {
                return '
                    <li class="navbar-text">
                        '.htmlspecialchars($menuItem->Text).'
                    </li>';
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
            protected function RenderComponent4(LinkedMenuItem $menuItem) : string
            {
                return '
                    <li class="nav-item">
                        <a class="nav-link'.($menuItem->IsActive ? ' active' : '').'" href="'.htmlspecialchars($menuItem->URL).'"'.($menuItem->NewTab ? ' target="_blank"' : '').'>'.htmlspecialchars($menuItem->Text).'</a>
                    </li>';
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
            protected function RenderComponent5(MenuItemSeparator $menuItem) : string
            {
                return '
                    <li class="navbar-text text-muted">
                        '.htmlspecialchars('  │  ').'
                    </li>';
            }
            
            /**
             * Renders a sub-item of a MenuItemGroup.
             *
             * @param MenuItem $menuItem
             * The MenuItem that is to be rendered.
             * 
             * @return string
             * A string that represents the rendered item.
             */
            protected function RenderSubItem1(MenuItem $menuItem) : string
            {
                return '
                    <a class="dropdown-header">'.htmlspecialchars($menuItem->Text).'</a>';
            }

            /**
             * Renders a sub-item of a MenuItemGroup.
             *
             * @param MenuItem $menuItem
             * The MenuItem that is to be rendered.
             * 
             * @return string
             * A string that represents the rendered item.
             */
            protected function RenderSubItem2(LinkedMenuItem $menuItem) : string
            {
                $link = htmlspecialchars($menuItem->URL);
                $text = htmlspecialchars($menuItem->Text);
                return '
                    <a class="dropdown-item" href="'.$link.'"'.($menuItem->NewTab ? ' target="_blank"' : '').'>'.$text.'</a>';
            }

            /**
             * Renders a sub-item of a MenuItemGroup.
             *
             * @param MenuItem $menuItem
             * The MenuItem that is to be rendered.
             * 
             * @return string
             * A string that represents the rendered item.
             */
            protected function RenderSubItem3(MenuItemSeparator $separator) : string
            {
                return '
                    <div class="dropdown-divider"></div>';
            }
        }
    }
?>
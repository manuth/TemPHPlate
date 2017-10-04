<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web\Forms\Rendering;
    use System\EventHandler;
    use System\Web\Forms\Control;
    {
        /**
         * Provides the functionality to render renderable items.
         * 
         * @property-read PaintEventHandler $Paint
         * Occurs when an item is drawn.
         */
        interface IRenderer
        {
            /**
             * Renders a renderable item.
             *
             * @param Control $item
             * The item to render.
             * 
             * @return string
             * A string that represents the rendered item.
             */
            function Render(Control $item) : string;
        }
    }
?>
<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web\Forms\Rendering;
    {
        /**
         * Provides the functionality to render renderable items.
         */
        interface IRenderer
        {
            /**
             * Renders a renderable item.
             *
             * @param IRenderable $item
             * The item to render.
             * 
             * @return string
             * A string that represents the rendered item.
             */
            function Render(IRenderable $item) : string;
        }
    }
?>
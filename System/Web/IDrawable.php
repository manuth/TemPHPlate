<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    {
        /**
         * Provides the functionality to draw an object.
         */
        interface IDrawable
        {
            /**
             * Draws the object.
             *
             * @return string
             * The content of the drawn object.
             */
            function Draw() : string;
        }
    }
?>
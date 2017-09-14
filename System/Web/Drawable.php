<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    use System\Object;
    {
        /**
         * Represents a drawable object.
         */
        abstract class Drawable extends Object implements IDrawable
        {
            /**
             * Draws the object.
             *
             * @return string
             * The content of the drawable object.
             */
            public function Draw() : string
            {
                ob_start();
                $this->DrawInternal();
                return ob_get_clean();
            }

            /**
             * Draws the object.
             *
             * @return void
             */
            protected abstract function DrawInternal();
        }
    }
?>
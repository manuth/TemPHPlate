<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    use System\Object;
    {
        /**
         * Represents a printable object.
         */
        abstract class Printable extends Object implements IPrintable
        {
            /**
             * Prints the object.
             *
             * @return string
             * The content of the printable object.
             */
            public function Print()
            {
                ob_start();
                $this->PrintInternal();
                return ob_get_clean();
            }

            /**
             * Prints the object.
             *
             * @return string
             * The content of the printable object.
             */
            protected abstract function PrintInternal();
        }
    }
?>
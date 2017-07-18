<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    {
        /**
         * Provides the functionality to print an object.
         */
        interface IPrintable
        {
            /**
             * Prints the object.
             *
             * @return string
             * The content of the printed object.
             */
            function Print() : string;
        }
    }
?>
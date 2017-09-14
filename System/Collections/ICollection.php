<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Collections;
    {
        /**
         * Defines size and enumerators for all collections.
         * 
         * @property-read int $Count
         * Gets the number of elements contained in the ICollection.
         */
        interface ICollection
        {
            /**
             * @ignore
             * @return int
             */
            function getCount() : int;
        }
    }
?>
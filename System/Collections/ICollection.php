<?php
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
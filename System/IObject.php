<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System;
    {
        /**
         * Supports all classes in the class hierarchy.
         * This is the ultimate base class of all classes in the Framework; it is the root of the type hierarchy.
         */
        interface  IObject
        {
            /**
             * Returns a string which represents the object.
             *
             * @return string
             */
            function ToString() : string;

            /**
             * Serves as the default hash function.
             *
             * @return int
             * A hash code for the current object.
             */
            function GetHashCode() : int;

            /**
             * Gets the Type of the current instance.
             *
             * @return Type
             * The exact runtime type of the current instance.
             */
            public function GetType() : ?Type;
        }
    }
?>
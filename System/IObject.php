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
             * Casts the object to another type.
             *
             * @param \string $class
             * The type to convert the object to.
             * 
             * @return \object
             * The casted object.
             */
            function Cast(string $class);

            /**
             * Returns a string which represents the object.
             *
             * @return string
             */
            function ToString();
        }
    }
?>
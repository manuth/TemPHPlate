<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System;
    use System\Exception;
    {
        /**
         * Supports all classes in the class hierarchy.
         * This is the ultimate base class of all classes in the Framework; it is the root of the type hierarchy.
         * 
         * @property \ReflectionClass $CastedType
         * Gets or sets the current type of the object.
         */
        class Object
        {
            use ObjectBase;

            /**
             * Initializes a new instance of the Object class.
             */
            public function Object()
            {
            }
        }
    }
?>
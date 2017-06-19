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
        class Object implements IObject
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
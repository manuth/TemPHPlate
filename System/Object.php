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
            use ObjectBase
            {

                Cast as private CastInternal;
                ToString as private ToStringInternal;
                GetHashCode as private GetHashCodeInternal;
            }

            /**
             * Initializes a new instance of the Object class.
             */
            public function Object()
            {
            }

            /**
             * Casts the object to another type.
             *
             * @param \string $class
             * The type to convert the object to.
             * 
             * @return \object
             * The casted object.
             */
            public function Cast($class)
            {
                return $this->CastInternal($cast);
            }

            /**
             * Returns a string which represents the object.
             *
             * @return string
             */
            public function ToString()
            {
                return $this->ToStringInternal();
            }

            /**
             * Serves as the default hash function.
             *
             * @return int
             * A hash code for the current object.
             */
            public function GetHashCode()
            {
                return $this->GetHashCodeInternal();
            }
        }
    }
?>
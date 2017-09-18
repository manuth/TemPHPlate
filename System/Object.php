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
            /**
             * Initializes a new instance of the Object class.
             */
            public function Object()
            {
                $this->__Initialize();
            }

            /**
             * Casts the object to another type.
             *
             * @param string $class
             * The type to convert the object to.
             * 
             * @return mixed
             * The casted object.
             */
            public function Cast(string $class)
            {
                return $this->CastInternal($cast);
            }

            /**
             * Returns a string which represents the object.
             *
             * @return string
             * A string that represents the current object.
             */
            public function ToString() : string
            {
                return $this->ToStringInternal();
            }

            /**
             * Serves as the default hash function.
             *
             * @return int
             * A hash code for the current object.
             */
            public function GetHashCode() : int
            {
                return $this->GetHashCodeInternal();
            }

            /**
             * Gets the Type of the current instance.
             *
             * @return Type
             * The exact runtime type of the current instance.
             */
            public function GetType() : ?Type
            {
                return $this->GetTypeInternal();
            }
            
            /**
             * Initializes the object.
             */
            protected function __Initialize()
            {
            }
            
            use ObjectBase
            {
                ToString as private ToStringInternal;
                GetHashCode as private GetHashCodeInternal;
                GetType as private GetTypeInternal;
            }
        }
    }
?>
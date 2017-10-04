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
                return Type::GetByName(get_class($this));
            }
            
            /**
             * Determines whether the specified object is equal to the current object.
             *
             * @param mixed $obj
             * The object to compare with the current object.
             * 
             * @return bool
             * **true** if the specified object is equal to the current object; otherwise, **false**.
             */
            public function Equals($obj) : bool
            {
                return $this->EqualsInternal($obj);
            }
            
            /**
             * @ignore
             */
            private function __Initialize() : array
            {
                return $this->__InitializeInternal();
            }
            
            use ObjectBase
            {
                ToString as private ToStringInternal;
                GetHashCode as private GetHashCodeInternal;
                GetType as private GetTypeInternal;
                Equals as private EqualsInternal;
                __Initialize as private __InitializeInternal;
            }
        }
    }
?>
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

            /**
             * Performs a comparison of two objects of the same type and returns a value indicating whether one object is less than, equal to, or greater than the other.
             *
             * @param mixed $x
             * The first object to compare.
             * 
             * @param mixed $y
             * The second object to compare.
             *
             * @return int
             * A signed integer that indicates the relative values of _x_ and _y_.
             */
            public static function Compare($x, $y)
            {
                if ($x instanceof IComparble && $y instanceof IComparable)
                {
                    return $x->CompareTo($y);
                }
                else if (is_string($x) && is_string($y))
                {
                    for ($i = 0; $i < min(array(strlen($x), strlen($y))); $i++)
                    {
                        if (strncasecmp($x, $y, $i) == 0 && strncmp($x, $y, $i) != 0)
                        {
                            return strncmp($x, $y, $i) * -1;
                        }
                    }
                    
                    return strcasecmp($x, $y);
                }
                else
                {
                    if ($x === $y)
                    {
                        return 0;
                    }
                    else
                    {
                        return $x > $y ? 1 : -1;
                    }
                }
            }
        }
    }
?>
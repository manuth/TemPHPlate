<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Collections;
    use System\Object;
    {
        /**
         * Defines a method that a type implements to compare two objects.
         */
        class Comparer extends Object
        {
            /**
             * The method to compare the objects.
             *
             * @var callable
             */
            private $comparer;

            /**
             * Returns a default sort order comparer.
             *
             * @var Comparer
             */
            public static $Default;

            /**
             * Initializes a new instance of the Comparer class.
             */
            public function Comparer()
            {
                $this->This(
                    function($x, $y)
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
                    });
            }

            /**
             * Initializes a new instance of the Comparer class with a comparsion-method.
             *
             * @param callable $comparer
             * The method that is used to compare objects.
             */
            public function Comparer1(callable $comparer)
            {
                $this->comparer = $comparer;
            }

            /**
             * Initializes the static values inside the class.
             *
             * @return void
             */
            public static function Initialize()
            {
                self::$Default = new Comparer();
            }

            /**
             * Performs a comparison of two objects of the same type and returns a value indicating whether one object is less than, equal to, or greater than the other.
             *
             * @param mixed $x
             * The first object to compare.
             * 
             * @param mixed $y
             * The first object to compare.
             * 
             * @return int
             * A signed integer that indicates the relative values of _x_ and _y_, as shown in the following table.
             */
            public function Compare($x, $y)
            {
                return ($this->comparer)($x, $y);
            }
        }
    }
?>
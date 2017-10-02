<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Collections;
    use System\Object;
    {
        /**
         * Defines methods to support the comparison of objects for equality.
         */
        class EqualityComparer extends Object
        {
            /**
             * The method to compare objects for equality.
             *
             * @var callable
             */
            private $comparer;

            /**
             * The default equality-comparer.
             *
             * @var EqualityComparer
             */
            public static $Default;

            /**
             * Initializes a new instance of the EqualityComparer class.
             */
            public function EqualityComparer()
            {
                $this->This(
                    function ($x, $y)
                    {
                        return $x === $y;
                    });
            }

            /**
             * Initializes a new instance of the EqualityComparer class with a comparsion-method.
             *
             * @param callable $comparer
             * The method that is used to compare objects.
             */
            public function EqualityComparer1(callable $comparer)
            {
                $this->comparer = $comparer;
            }

            /**
             * Initializes the static values inside the class.
             *
             * @return void
             */
            public static function __InitializeStatic()
            {
                self::$Default = new EqualityComparer();
            }

            /**
             * Determines whether the specified objects are equal.
             *
             * @param mixed $x
             * The first object to compare.
             * 
             * @param mixed $y
             * The first object to compare.
             * 
             * @return bool
             * **true** if the specified objects are equal; otherwise, **false**.
             */
            public function Equals($x, $y = null) : bool
            {
                if (func_num_args() == 2)
                {
                    return ($this->comparer)($x, $y);
                }
                else
                {
                    return parent::Equals($x);
                }
            }
        }
    }
?>
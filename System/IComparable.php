<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System;
    {
        /**
         * Defines a generalized comparison method that a value type or class implements to order or sort its instances.
         */
        interface IComparable
        {
            /**
             * Compares the current instance with another object of the same type and returns an integer that indicates whether the current instance precedes, follows, or occurs in the same position in the sort order as the other object.
             *
             * @param mixed $obj
             * An object to compare with this instance.
             * 
             * @return int
             * A value that indicates the relative order of the objects being compared. The return value has these meanings:
             * 
             * | Value             | Meaning                                                               |
             * |-------------------|-----------------------------------------------------------------------|
             * | Less than zero    | This instance precedes _obj_ in the sort order.                       |
             * | Zero              | This instance occurs in the same position in the sort order as _obj_. |
             * | Greater than zero | This instance follows _obj_ in the sort order.                        |
             */
            public function CompareTo($obj) : int;
        }
    }
?>
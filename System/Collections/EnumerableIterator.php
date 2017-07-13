<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Collections;
    {
        /**
         * An Enumerable that which wraps an iterator.
         */
        class EnumerableIterator extends Enumerable
        {
            /**
             * The iterator to iterate over.
             *
             * @var Iterator
             */
            private $function;

            /**
             * Initializes a new instance of the EnumerableIterator class.
             *
             * @param \Generator $generator
             * The generator to create the iterator.
             */
            public function EnumerableIterator1($generator)
            {
                $this->function = $generator;
            }

            /**
             * Returns an enumerator that iterates through the collection.
             *
             * @return Traversable
             * An enumerator that can be used to iterate through the collection.
             */
            public function GetEnumerator()
            {
                return new Enumerator($this->function);
            }
        }
    }
?>
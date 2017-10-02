<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Collections;
    use System\Object;
    {
        /**
         * Supports a simple iteration over a collection.
         * 
         * @property-read mixed $Current
         * Gets the element in the collection at the current position of the enumerator.
         * 
         * @property-read mixed $Valid
         * Gets a value indicating whether the current item could be determined.
         */
        class Enumerator extends Object implements \Iterator
        {
            /**
             * The function to iterate.
             *
             * @var \Closure
             */
            private $function;

            /**
             * The iterator.
             *
             * @var \Iterator
             */
            private $innerIterator;

            /**
             * Initializes a new instance of the Enumerator class with a function to iterate.
             *
             * @param \Closure $function
             * The function to iterate.
             */
            public function Enumerator1(\Closure $function)
            {
                $this->function = $function;
                $this->innerIterator = $function();
            }

            /**
             * @ignore
             * @return mixed
             */
            public function getCurrent()
            {
                return $this->current();
            }

            /**
             * @ignore
             * @return bool
             */
            public function getValid() : bool
            {
                return $this->valid();
            }

            /**
             * Returns the current element.
             *
             * @return mixed
             * The current element.
             */
            public function current()
            {
                return $this->innerIterator->current();
            }

            /**
             * Returns the key of the current element.
             *
             * @return mixed
             * The key of the current element.
             */
            public function key()
            {
                return $this->innerIterator->key();
            }

            /**
             * Advances the enumerator to the next element of the collection.
             *
             * @return void
             */
            public function next()
            {
                $this->innerIterator->next();
            }

            /**
             * Resets the current position to its initial state.
             *
             * @return void
             */
            public function rewind()
            {
                $this->innerIterator = ($this->function)();
            }

            /**
             * Returns a value indicating whether the current element is valid.
             *
             * @return bool
             * A value indicating whether the current element is valid.
             */
            public function valid() : bool
            {
                return $this->innerIterator->valid();
            }

            /**
             * Advances the enumerator to the next element of the collection.
             *
             * @return bool
             * **true** if the enumerator was successfully advanced to the next element; **false** if the enumerator has passed the end of the collection.
             */
            public function MoveNext() : bool
            {
                $this->next();
                return $this->Valid;
            }

            /**
             * Sets the enumerator to its initial position, which is before the first element in the collection.
             *
             * @return void
             */
            public function Reset()
            {
                $this->rewind();
            }
        }
    }
?>
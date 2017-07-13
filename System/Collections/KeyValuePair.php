<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Collections;
    use System\Object;
    {
        /**
         * Defines a key/value pair that can be set or retrieved.
         * 
         * @property-read mixed $Key
         * Gets the key on the key/value pair.
         * 
         * @property-read mixed $Vlaue
         * Gets the value on the key/value pair.
         */
        class KeyValuePair extends Object
        {
            /**
             * The key on the key/value pair.
             *
             * @var mixed
             */
            private $key;
            
            /**
             * The value in the key/value pair.
             *
             * @var mixed
             */
            private $value;

            /**
             * Initializes a new instance of the KeyValuePair structure with the specified key and value.
             *
             * @param mixed $key
             * @param mixed $value
             */
            public function KeyValuePair2($key, $value)
            {
                $this->key = $key;
                $this->value = $value;
            }

            /**
             * @ignore
             * @return mixed
             */
            public function getKey()
            {
                return $this->key;
            }

            /**
             * @ignore
             * @return mixed
             */
            public function getValue()
            {
                return $this->value;
            }
        }
    }
?>
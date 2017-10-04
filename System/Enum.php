<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache
     */
    namespace System;
    {
        /**
         * Provides the base class for enumerations.
         * 
         * @property-read mixed $Value
         * Gets the enum-value.
         */
        class Enum extends Object
        {
            /**
             * The enum-value.
             *
             * @var mixed
             */
            private $value;
            
            /**
             * Initializes a new instance of the `Enum` class.
             */
            public function Enum()
            {
            }

            /**
             * @ignore
             */
            public function getValue()
            {
                return $this->value;
            }

            /**
             * @ignore
             */
            public function __InitializeStatic()
            {
                $counter = 0;
                $class = new \ReflectionClass($this);
                $className = $class->name;
                $properties = $class->getProperties();
                
                foreach ($properties as $property)
                {
                    /**
                     * @var \ReflectionProperty $property
                     */
                    if ($property->isStatic())
                    {
                        $value = $property->getValue();

                        if ($value !== null && is_numeric($value))
                        {
                            $counter = $value;
                        }
                        else
                        {
                            $value = $counter;
                        }

                        $entry = new $className();
                        $entry->value = $value;

                        $property->setValue($entry);
                        $counter++;
                    }
                }
            }
        }
    }
?>
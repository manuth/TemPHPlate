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
            private function setValue($value)
            {
                $this->Value = $value;
            }

            /**
             * Determines whether one or more bit fields are set in the current instance.
             *
             * @param mixed $flag
             * An enumeration value.
             * 
             * @return bool
             * **true** if the bit field or bit fields that are set in _flag_ are also set in the current instance; otherwise, **false**.
             */
            public function HasFlag($flag)
            {
                if ($flag instanceof Enum)
                {
                    $flag = $flag->Value;
                }

                return ($this->Value & $flag) == $flag;
            }

            /**
             * Adds a flag to the current instance.
             *
             * @param mixed $flag
             * An enumeration value.
             * 
             * @return void
             */
            public function SetFlag($flag)
            {
                if ($flag instanceof Enum)
                {
                    $flag = $flag->Value;
                }

                $this->Value |= $flag;
            }
            
            /**
             * Unsets a flag from the current instance.
             *
             * @param mixed $flag
             * An enumeration value.
             */
            public function ClearFlag($flag)
            {
                if ($flag instanceof Enum)
                {
                    $flag = $flag->Value;
                }
                
                $this->Value &= ~$flag;
            }

            /**
             * Returns a string which represents the object.
             *
             * @return string
             * A string that represents the current object.
             */
            public function ToString() : string
            {
                $result = '';
                $values = array();

                foreach ((new \ReflectionClass($this))->getProperties() as $property)
                {
                    /**
                     * @var \ReflectionProperty $property
                     */
                    if ($property->isStatic())
                    {
                        $value = $property->getValue();
                        
                        if ($this->HasFlag($value))
                        {
                            $values[] = $property->getName();
                        }
                    }
                }

                return join(', ', $values);
            }
            
            /**
             * @ignore
             */
            private function __InitializeStatic()
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
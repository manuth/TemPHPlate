<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System;
    use System\Collections\ArrayList;
    {
        /**
         * Provides basic functionalities for objects.
         */
        trait ObjectBase
        {
            /**
             * The current type of the object.
             *
             * @var \ReflectionClass
             */
            private $castedType;

            /**
             * The data of the object.
             *
             * @var array
             */
            private $data = array();

            /**
             * Automatically calls the proper constructor.
             */
            public function __construct()
            {
                $this->CastedType = new \ReflectionClass($this);
                $this->InvokeConstructor(func_get_args());
            }

            /**
             * Provides the functionallity for get-property-accessors.
             * @ignore
             */
            public function __get(string $property)
            {
                var_dump(debug_backtrace()[1]);
                var_dump($property);
                $functionname = 'get'.$property;
                return $this->$functionname();
            }

            /**
             * Provides the functionality for set-property-accessors.
             * @ignore
             */
            public function __set(string $property, $value)
            {
                $functionname = 'set'.$property;
                return $this->$functionname($value);
            }


            /**
             * @ignore
             */
            private function getCastedType()// : Type TODO
            {
                if ($this->castedType === null)
                {
                    $this->castedType = new \ReflectionClass($this);
                }

                return $this->castedType;
            }

            /**
             * @ignore
             */
            private function setCastedType(/* TODO Type */$value)
            {
                $this->castedType = $value;
            }

            /**
             * Casts the object to another type.
             *
             * @param string $class
             * The type to convert the object to.
             * 
             * @return mixed
             * The casted object.
             */
            public function Cast(string $class)
            {
                $class = new \ReflectionClass($class);

                $orgClass = new \ReflectionClass($this);
                if ($class->isSubclassOf($orgClass) || $orgClass->isSubclassOf($class))
                {
                    $castedObject = $class->newInstanceWithoutConstructor();

                    $upCast = $orgClass->isSubclassOf($class);

                    foreach ($orgClass->getProperties(
                        \ReflectionProperty::IS_PUBLIC |
                        \ReflectionProperty::IS_PROTECTED |
                        \ReflectionProperty::IS_PRIVATE) as $orgProperty)
                    {
                        $orgProperty->setAccessible(true);

                        if ($class->hasProperty($orgProperty->name))
                        {
                            $property = $class->getProperty($orgProperty->name);
                            $property->setAccessible(true);
                            $property->setValue($castedObject, $orgProperty->getValue($this));
                        }
                        else if ($upCast)
                        {
                            // Store values into the data-variable if an upcast is performed.
                            $castedObject->data[$orgProperty->name] = $orgProperty->getValue($this);
                        }
                    }

                    if (!$upCast)
                    {
                        // Restore the values from the data-variable if a downcast is preformed.
                        foreach ($this->data as $key => $value)
                        {
                            if ($class->hasProperty($key))
                            {
                                $property = $class->getProperty($key);
                                $property->setAccessible(true);
                                $property->setValue($castedObject, $value);
                            }
                        }
                    }
                }
                else
                {
                    throw new Exception(sprintf('Cannot cast to %s', $class->getShortName()));
                }
                return $castedObject;
            }

            /**
             * Returns a string which represents the object.
             *
             * @return string
             */
            public final function __toString() : string
            {
                return $this->ToString();
            }

            /**
             * Returns a string which represents the object.
             *
             * @return string
             */
            public function ToString() : string
            {
                return 'Type: '.(new \ReflectionClass($this))->name;
            }

            /**
             * Serves as the default hash function.
             *
             * @return int
             * A hash code for the current object.
             */
            public function GetHashCode() : int
            {
                return hexdec(spl_object_hash($this));
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
                return $this === $obj;
            }

            /**
             * Calls a base-constructor.
             */
            protected function Base()
            {
                $type = $this->CastedType;
                $this->CastedType = $this->CastedType->getParentClass();
                $args = func_get_args();
                $this->InvokeConstructor($args);
                $this->CastedType = $type;
            }

            /**
             * Calls a constructor of the same class.
             */
            protected function This()
            {
                $args = func_get_args();
                $this->InvokeConstructor($args);
            }

            /**
             * Determines whether the constructor calls another constructor.
             *
             * @param \ReflectionMethod $constructor
             * A constructor.
             * 
             * @return bool
             * A value indicating whether the constructor calls another constructor.
             */
            private static function HasConstructorCall(\ReflectionMethod $constructor) : bool
            {
                $sourceCode = implode(
                    "",
                    array_slice(
                        file($constructor->getFileName()),
                        $constructor->getStartLine(),
                        $constructor->getEndLine() - $constructor->getStartLine()
                    )
                );

                return preg_match('/\{[\s]*\$this[\s]*->[\s]*(?:Base|This)[\s]*\(.*\)[\s\S]*\}/', $sourceCode);
            }

            /**
             * Determines whether the class allows auto-construct.
             * 
             * @return bool
             * A value indicating whether the class allows auto-construct.
             */
            private function getAllowsAutoConstruct() : bool
            {
                $class = $this->CastedType;
                $constructors = $this->GetConstructors();
                $autoConstructor = array_filter($constructors, function($constructor) use ($class)
                {
                    return $constructor->name === $class->getShortName();
                });
                return count($constructors) === 0 || count($autoConstructor) > 0;
            }

            /**
             * Determines all constructors of a class.
             * 
             * @return \ReflectionMethod[]
             * The constructors of the class.
             */
            private function GetConstructors() : array
            {
                $result = array();
                
                foreach ($this->CastedType->getMethods() as $method)
                {
                    if ($method->class === $this->CastedType->name)
                    {
                        if (preg_match(sprintf('/^%s[0-9]*$/', $this->CastedType->getShortName()), $method->name))
                        {
                            $result[] = $method;
                        }
                    }
                }
                return $result;
            }

            /**
             * Invokes a constructor.
             *
             * @param array $args
             * The parameters of the constructor.
             */
            private function InvokeConstructor(array $args)
            {
                $count = count($args);
                $className = $this->CastedType->getShortName();
                $functionName = $className.($count > 0 ? $count : '');
                $constructors = $this->GetConstructors();
                $matchingConstructor = array_values(
                    array_filter($constructors, function($constructor) use ($functionName)
                    {
                        return $constructor->name === $functionName;
                    })
                );

                if (count($matchingConstructor) === 0)
                {
                    $matchingConstructor = null;
                }
                else
                {
                    $matchingConstructor = $matchingConstructor[0];
                }

                if ($matchingConstructor || count($args) === 0)
                {
                    if ($this->CastedType->getParentClass())
                    {
                        if (
                            ($matchingConstructor && !self::HasConstructorCall($matchingConstructor)) ||
                            $matchingConstructor === null
                        )
                        {
                            $type = $this->CastedType;
                            $this->CastedType = $this->CastedType->getParentClass();
                            $autoConstruct = $this->getAllowsAutoConstruct();
                            $this->CastedType = $type;

                            if ($autoConstruct)
                            {
                                $this->Base();
                            }
                            else
                            {
                                // ToDo throw error if the base class has no parameterless constructor
                                throw new NotImplementedException();
                            }
                        }
                    }

                    if ($matchingConstructor)
                    {
                        call_user_func_array(array($matchingConstructor, 'invoke'), array_merge(array($this), $args));
                    }
                }
                else
                {
                    //ToDo throw error if the constructor couldn't be found
                    throw new NotImplementedException();
                }
            }

            /**
             * Merges the properties of $obj into this object.
             *
             * @param mixed $obj
             * The object to merge into this object.
             */
            private function Merge($obj)
            {
                $class = new \ReflectionClass($this);

                foreach ($class->getProperties(
                    \ReflectionProperty::IS_PUBLIC |
                    \ReflectionProperty::IS_PROTECTED |
                    \ReflectionProperty::IS_PRIVATE) as $property)
                {
                    $property->setAccessible(true);
                    $property->setValue($this, $property->getValue($obj));
                }
            }
        }
    }
?>
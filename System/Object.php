<?php

    namespace System;
    use System\Exception;
    {
        /**
         * Supports all classes in the class hierarchy.
         * This is the ultimate base class of all classes in the Framework; it is the root of the type hierarchy.
         */
        class Object
        {
            /**
             * The data of the object.
             *
             * @var array
             */
            private $data = array();

            /**
             * Initializes a new instance of the Object class.
             */
            public function Object()
            {
            }

            /**
             * Automatically calls the proper constructor.
             */
            public function __construct()
            {
                $this->InvokeConstructor(func_get_args());
            }

            /**
             * Provides the functionality for set-property-accessors.
             * @ignore
             */
            public function __set($property, $value)
            {
                $functionname = 'set'.$property;
                return $this->$functionname($value);
            }

            /**
             * Provides the functionallity for get-property-accessors.
             * @ignore
             */
            public function __get($property)
            {
                $functionname = 'get'.$property;
                return $this->$functionname();
            }

            /**
             * Casts the object to another type.
             *
             * @param \string $class
             * The type to convert the object to.
             * 
             * @return object
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
             * Calls a base-constructor.
             */
            protected function Base()
            {
                $base = $this->Cast(get_parent_class($this));
                $args = func_get_args();
                $base->InvokeConstructor($args);
                $base = $base->Cast(get_class($this));
                $this->Merge($base);
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
            private static function HasConstructorCall(\ReflectionMethod $constructor)
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
            private function getAllowsAutoConstruct()
            {
                $class = new \ReflectionClass($this);
                $constructors = $this->GetConstructors();
                $autoConstructor = array_filter($constructors, function($constructor) use ($class)
                {
                    return $constructor->name == $class->getShortName();
                });
                return count($constructors) == 0 || count($autoConstructor) > 0;
            }

            /**
             * Determines all constructors of a class.
             * 
             * @return \ReflectionMethod[]
             * The constructors of the class.
             */
            private function GetConstructors()
            {
                $result = array();
                $class = new \ReflectionClass($this);

                foreach ($class->getMethods() as $method)
                {
                    if ($method->class == $class->name)
                    {
                        if (preg_match(sprintf('/^%s[0-9]*$/', $class->getShortName()), $method->name))
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
                $class = new \ReflectionClass($this);
                $className = $class->getShortName();
                $functionName = $className.($count > 0 ? $count : '');
                $constructors = $this->GetConstructors();
                $matchingConstructor = array_values(
                    array_filter($constructors, function($constructor) use ($functionName)
                    {
                        return $constructor->name == $functionName;
                    })
                );

                if (count($matchingConstructor) == 0)
                {
                    $matchingConstructor = null;
                }
                else
                {
                    $matchingConstructor = $matchingConstructor[0];
                }

                if ($matchingConstructor || count($args) == 0)
                {
                    if (get_parent_class($this))
                    {
                        $base = $this->Cast(get_parent_class($this));

                        if (
                            ($matchingConstructor && !self::HasConstructorCall($matchingConstructor)) ||
                            $matchingConstructor == null
                        )
                        {
                            if ($base->getAllowsAutoConstruct())
                            {
                                $this->Base();
                            }
                            else
                            {
                                // ToDo throw error if the base class has no parameterless constructor
                            }
                        }
                    }

                    if ($matchingConstructor)
                    {
                        $matchingConstructor->invoke($this, $args);
                    }
                }
                else
                {
                    //ToDo throw error if the constructor couldn't be found
                }
            }

            /**
             * Merges the properties of $obj into this object.
             *
             * @param object $obj
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
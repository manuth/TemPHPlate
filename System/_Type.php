<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System
    {
        /**
         * Represents type declarations: class types, interface types, array types, value types and enumeration types.
         */
        class _Type
        {
            /**
             * The ReflectionClass of the type.
             *
             * @var \ReflectionClass|string
             */
            private $phpType;

            /**
             * Initializes a new instance of the _Type class.
             */
            protected function __construct()
            {
            }

            /**
             * Gets the type from which the current _Type directly inherits.
             * @return _Type
             */
            public function getBaseType() : ?self
            {
                if (($this->phpType instanceof \ReflectionClass) && $this->phpType->getParentClass())
                {
                    $type = new _Type();
                    $parentType = $this->phpType->getParentClass();
                    $type->phpType = $parentType;
                    return $type;
                }
                else
                {
                    return null;
                }
            }

            /**
             * Gets the fully qualified name of the type, including its namespace but not its assembly.
             * @return string
             */
            public function getFullName() : string
            {
                if ($this->phpType instanceof \ReflectionClass)
                {
                    return $this->phpType->getName();
                }
                else
                {
                    return (string)$this->phpType;
                }
            }

            /**
             * Gets a value that indicates whether the type is an array.
             * @return bool
             */
            public function getIsArray() : bool
            {
                return $this->getFullName() == 'array';
            }

            /**
             * Gets a value indicating whether the _Type is abstract and must be overridden.
             * @return bool
             */
            public function getIsAbstract() : bool
            {
                return ($this->phpType instanceof \ReflectionClass) && $this->phpType->isAbstract();
            }

            /**
             * Gets a value indicating whether the _Type is a class or a delegate; that is, not a value type or interface.
             * @return bool
             */
            public function getIsClass() : bool
            {
                return ($this->phpType instanceof \ReflectionClass) && (!$this->phpType->isInterface() && !$this->phpType->isTrait());
            }

            /**
             * Gets a value indicating whether the current _Type represents an enumeration.
             * @return bool
             */
            public function getIsEnum() : bool
            {
                return $this->IsSubclassOf(self::GetByName('System\Enum'));
            }

            /**
             * Gets a value indicating whether the _Type is an interface; that is, not a class or a value type.
             * @return bool
             */
            public function getIsInterface() : bool
            {
                return $this->getFullName() == 'iterable' || (($this->phpType instanceof \ReflectionClass) && $this->phpType->isInterface());
            }

            /**
             * Gets a value indicating whether the _Type is declared sealed.
             * @return bool
             */
            public function getIsSealed() : bool
            {
                return ($this->phpType instanceof \ReflectionClass) && $this->phpType->isFinal();
            }

            /**
             * Gets a value indicating whether the _Type is a value type.
             * @return bool
             */
            public function getIsValueType() : bool
            {
                return !($this->phpType instanceof \ReflectionClass) && $this->getFullName() != 'iterable';
            }

            /**
             * Gets the name of the current member.
             * @return string
             */
            public function getName() : string
            {
                if ($this->phpType instanceof \ReflectionClass)
                {
                    return $this->phpType->getShortName();
                }
                else
                {
                    return (string)$this->phpType;
                }
            }

            /**
             * Gets the namespace of the _Type.
             * @return string
             */
            public function getNamespace() : string
            {
                if ($this->phpType instanceof \ReflectionClass)
                {
                    return $this->phpType->getNamespaceName();
                }
                else
                {
                    return null;
                }
            }

            /**
             * s the object to another type.
             *
             * @param string $class
             * The type to convert the object to.
             * 
             * @return mixed
             * The ed object.
             */
            public function Cast(string $class)
            {
                return $this->CastInternal($class);
            }

            /**
             * Returns a string which represents the object.
             *
             * @return string
             * A string that represents the current object.
             */
            public function ToString() : string
            {
                return $this->ToStringInternal();
            }

            /**
             * Serves as the default hash function.
             *
             * @return int
             * A hash code for the current object.
             */
            public function GetHashCode() : int
            {
                return $this->GetHashCodeInternal();
            }

            /**
             * Gets the Type of the current instance.
             *
             * @return Type
             * The exact runtime type of the current instance.
             */
            public function GetType() : ?Type
            {
                return $this->GetTypeInternal();
            }
            
            /**
             * Returns all the methods of the current _Type.
             *
             * @return \ReflectionMethod[]
             * An array of \ReflectionMethod objects representing all the methods defined for the current _Type.
             */
            public function GetMethods() : array
            {
                if ($this->phpType instanceof \ReflectionClass)
                {
                    return $this->phpType->getMethods();
                }
                else
                {
                    return array();
                }
            }

            /**
             * Searches for the specified method whose parameters match the specified argument types.
             *
             * @param string $name
             * The string containing the name of the method to get.
             * 
             * @param array $types
             * An array of Type objects representing the number, order, and type of the parameters for the method to get.
             * 
             * @return \ReflectionMethod
             * An object representing the method whose parameters match the specified argument types, if found; otherwise, **null**.
             */            
            public function GetMethod(string $name, ?array $types = null) : ?\ReflectionMethod
            {
                $result = array();
                $methods = $this->GetMethodsByName($name);

                if ($types !== null)
                {
                    if (in_array(null, $types, true))
                    {
                        throw new ArgumentNullException('types');
                    }
                    else
                    {
                        foreach ($methods as $method)
                        {
                            if (count($types) >= $method->getNumberOfRequiredParameters() && count($types) <= $method->getNumberOfParameters())
                            {
                                if (
                                    (function () use ($method, $types)
                                    {
                                        $parameters = $method->getParameters();
                                        for ($i = 0; $i < count($types); $i++)
                                        {
                                            if ($parameters[$i]->hasType())
                                            {
                                                if ($types[$i]->getFullName() == 'NULL')
                                                {
                                                    if (!$parameters[$i]->allowsNull())
                                                    {
                                                        return false;
                                                    }
                                                }
                                                else
                                                {
                                                    $type = self::GetByName((string)$parameters[$i]->getType());
    
                                                    if (!$type->IsAssignableFrom($types[$i]))
                                                    {
                                                        return false;
                                                    }
                                                }
                                            }
                                        }
                                        return true;
                                    })())
                                {
                                    $result[] = $method;
                                }
                            }
                        }
                    }
                }
                else
                {
                    $result = $methods;
                }

                if (count($result) == 1)
                {
                    return $result[0];
                }
                else
                {
                    return null;
                }
            }

            /**
             * Searches for an instance constructor whose parameters match the types in the specified array.
             *
             * @param _Type[] $types
             * An array of Type objects representing the number, order, and type of the parameters for the desired constructor.
             * 
             * @return \ReflectionMethod
             * An object representing the instance constructor whose parameters match the types in the parameter type array, if found; otherwise, null.
             */
            public function GetConstructor(array $types) : ?\ReflectionMethod
            {
                return $this->GetMethod($this->getName(), $types);
            }

            /**
             * Returns all the constructors defined for the current _Type.
             *
             * @return \ReflectionMethod[]
             * An array of ConstructorInfo objects representing all the instance constructors defined for the current _Type.
             */
            public function GetConstructors() : array
            {
                if ($this->getIsClass())
                {
                    return $this->GetMethodsByName($this->getName());
                }
                else
                {
                    return array();
                }
            }

            /**
             * Gets the _Type with the specified name, performing a case-sensitive search.
             *
             * @param string $typeName
             * The fully qualified name of the type to get.
             * 
             * @return _Type
             * The type with the specified name, if found; otherwise, **null**.
             */
            public static function GetByName(?string $typeName) : ?self
            {
                if ($typeName !== null)
                {
                    try
                    {
                        $type = new _Type();

                        // pre-processing type-name...
                        switch ($typeName)
                        {
                            case 'integer':
                                $typeName = 'int';
                        }

                        switch ($typeName)
                        {
                            case 'array':
                            case 'bool':
                            case 'callable':
                            case 'float':
                            case 'int':
                            case 'iterable':
                            case 'NULL':
                            case 'string':
                                $type->phpType = $typeName;
                                break;
                            default:
                                $phpType = new \ReflectionClass($typeName);
                                $type->phpType = $phpType;
                                break;
                        }
                        return $type;
                    }
                    catch (\ReflectionException $exception)
                    {
                        return null;
                    }
                }
                else
                {
                    throw new ArgumentNullException('typeName');
                }
            }

            /**
             * Determines whether an instance of a specified type can be assigned to an instance of the current type.
             *
             * @param self $c
             * The type to compare with the current type.
             * 
             * @return bool
             * *true* if any of the following conditions is true:
             * - _c_ and the current instance represent the same type.
             * - _c_ is derived either directly or indirectly from the current instance. _c_ is derived directly from the current instance if it inherits from the current instance; _c_ is derived indirectly from the current instance if it inherits from a succession of one or more classes that inherit from the current instance.
             * - The current instance is an interface that _c_ implements.
             * - _c_ is a generic type parameter, and the current instance represents one of the constraints of _c_.
             */
            public function IsAssignableFrom(self $c)
            {
                if ($this->getFullName() == 'iterable')
                {
                    return $c->getIsArray() || self::GetByName('\Traversable')->IsAssignableFrom($c);
                }
                else if ($this->getFullName() == 'callable')
                {
                    return self::GetByName('\Closure')->IsAssignableFrom($c);
                }
                else if (($this->phpType instanceof \ReflectionClass) && ($c->phpType instanceof \ReflectionClass))
                {
                    if ($this->getFullName() == $c->getFullName())
                    {
                        return true;
                    }
                    else
                    {
                        return $c->phpType->isSubclassOf($this->getFullName());
                    }
                }
                else
                {
                    return $this->getFullName() == $c->getFullName();
                }
            }

            /**
             * Determines whether the current _Type derives from the specified _Type.
             *
             * @param _Type $c
             * The type to compare with the current type.
             * 
             * @return bool
             * **true** if the current **_Type** derives from _c_; otherwise, **false**. This method also returns **false** if _c_ and the current **_Type** are equal.
             */
            public function IsSubclassOf(self $c) : bool
            {
                if ($this->getIsClass() && $c->getIsClass())
                {
                    return $this->phpType->isSubclassOf($c->getFullName());
                }
                else
                {
                    return false;
                }
            }

            /**
             * Returns all overloads of the method with the specified name.
             *
             * @param string $name
             * The name of the method whose overloads are to be returned.
             * 
             * @return \ReflectionMethod[]
             * The overloads of the method.
             */
            private function GetMethodsByName($name)
            {
                $result = array();

                foreach ($this->phpType->getMethods() as $method)
                {
                    if ($method->class === $this->phpType->name)
                    {
                        if (preg_match("/^{$name}[0-9]*$/", $method->name))
                        {
                            $result[] = $method;
                        }
                    }
                }

                return $result;
            }
        }
    }
?>
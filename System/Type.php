<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System
    {
        /**
         * Represents type declarations: class types, interface types, array types, value types and enumeration types.
         * 
         * @property-read Type $BaseType
         * Gets the type from which the current Type directly inherits.
         * 
         * @property-read string $FullName
         * Gets the fully qualified name of the type, including its namespace but not its assembly.
         * 
         * @property-read bool $IsAbstract
         * Gets a value indicating whether the Type is abstract and must be overridden.
         * 
         * @property-read bool $IsClass
         * Gets a value indicating whether the Type is a class or a delegate; that is, not a value type or interface.
         * 
         * @property-read bool $IsEnum
         * Gets a value indicating whether the current Type represents an enumeration.
         * 
         * @property-read bool $IsInterface
         * Gets a value indicating whether the Type is an interface; that is, not a class or a value type.
         * 
         * @property-read bool $IsSealed
         * Gets a value indicating whether the Type is declared sealed.
         * 
         * @property-read bool $IsValueType
         * Gets a value indicating whether the Type is a value type.
         * 
         * @property-read string $Name
         * Gets the name of the current member.
         * 
         * @property-read string $Namespace
         * Gets the namespace of the Type.
         */
        class Type extends Object
        {
            /**
             * The ReflectionClass of the type.
             *
             * @var \ReflectionClass|\ReflectionType
             */
            private $phpType;

            /**
             * Initializes a new instance of the Type class.
             */
            protected function Type()
            {
            }

            /**
             * @ignore
             * @return Type
             */
            public function getBaseType() : self
            {
                if (!$this->IsValueType)
                {
                    $type = new Type();
                    $parentType = $this->phpType->getParentClass();

                    if ($parentType)
                    {
                        $type->phpType = $parentType;
                        return $type;
                    }
                }
                return null;
            }

            /**
             * @ignore
             * @return string
             */
            public function getFullName() : string
            {
                if ($this->IsValueType)
                {
                    return (string)$this->phpType;
                }
                else
                {
                    return $this->phpType->getName();
                }
            }

            /**
             * @ignore
             * @return bool
             */
            public function getIsAbstract() : bool
            {
                return !$this->IsValueType && $this->phpType->isAbstract();
            }

            /**
             * @ignore
             * @return bool
             */
            public function getIsClass() : bool
            {
                return !$this->IsValueType && (!$this->phpType->isInterface() && !$this->phpType->isTrait());
            }

            /**
             * @ignore
             * @return bool
             */
            public function getIsEnum() : bool
            {
                return !$this->IsValueType && $this->phpType->isSubclassOf('System\Enum');
            }

            /**
             * @ignore
             * @return bool
             */
            public function getIsInterface() : bool
            {
                return !$this->IsValueType && $this->phpType->isInterface();
            }

            /**
             * @ignore
             * @return bool
             */
            public function getIsSealed() : bool
            {
                return !$this->IsValueType && $this->phpType->isFinal();
            }

            /**
             * @ignore
             * @return bool
             */
            public function getIsValueType() : bool
            {
                return !($this->phpType instanceof \ReflectionClass);
            }

            /**
             * @ignore
             * @return string
             */
            public function getName() : string
            {
                if ($this->IsValueType)
                {
                    return (string)$this->phpType;
                }
                else
                {
                    return $this->phpType->getShortName();
                }
            }

            /**
             * @ignore
             * @return string
             */
            public function getNamespace() : string
            {
                if ($this->IsValueType)
                {
                    return null;
                }
                else
                {
                    return $this->phpType->getNamespaceName();
                }
            }

            /**
             * Searches for an instance constructor whose parameters match the types in the specified array.
             *
             * @param Type[] $types
             * An array of Type objects representing the number, order, and type of the parameters for the desired constructor.
             * 
             * @return \ReflectionMethod
             * An object representing the instance constructor whose parameters match the types in the parameter type array, if found; otherwise, null.
             */
            public function GetConstructor(array $types) : ?\ReflectionMethod
            {
                $matchingConstructors = array();
                $constructors = $this->GetConstructors();
                
                if (in_array(null, $types, true))
                {
                    throw new ArgumentNullException('types');
                }
                else
                {
                    foreach ($constructors as $constructor)
                    {
                        if (count($types) >= $constructor->getNumberOfRequiredParameters() && count($types) <= $constructor->getNumberOfParameters())
                        {
                            if (
                                (function () use ($constructor, $types)
                                {
                                    $parameters = $constructor->getParameters();
                                    for ($i = 0; $i < count($types); $i++)
                                    {
                                        if (!$types[$i]->IsValueType && class_exists($parameters[$i]->getType()->getName()))
                                        {
                                            if (!$types[$i]->phpType->isSubclassOf($parameters[$i]->getType()->getName()))
                                            {
                                                return false;
                                            }
                                        }
                                        else
                                        {
                                            if ($types[$i]->FullName != $parameters[$i]->getType()->getName())
                                            {
                                                return false;
                                            }
                                        }
                                    }
                                })())
                            {}
                        }
                    }
                }
                return null;
            }

            /**
             * Returns all the constructors defined for the current Type.
             *
             * @return \ReflectionMethod[]
             * An array of ConstructorInfo objects representing all the instance constructors defined for the current Type.
             */
            public function GetConstructors() : array
            {
                $result = array();

                if (!$this->IsValueType)
                {
                    foreach ($this->phpType->getMethods() as $method)
                    {
                        if ($method->class === $this->phpType->name)
                        {
                            if (preg_match("/^{$this->phpType->getShortName()}[0-9]*$/", $method->name))
                            {
                                $result[] = $method;
                            }
                        }
                    }
                }

                return $result;
            }

            /**
             * Returns all the public methods of the current Type.
             *
             * @return \ReflectionMethod[]
             * An array of \ReflectionMethod objects representing all the public methods defined for the current Type.
             */
            public function GetMethods() : array
            {
                if ($this->IsValueType)
                {
                    return array();
                }
                else
                {
                    return $this->phpType->getMethods();
                }
            }

            /**
             * Gets the Type with the specified name, performing a case-sensitive search.
             *
             * @param string $typeName
             * The fully qualified name of the type to get.
             * 
             * @return Type
             * The type with the specified name, if found; otherwise, **null**.
             */
            public static function GetByName(string $typeName = null) : ?Type
            {
                if ($typeName !== null)
                {
                    try
                    {
                        $type = new Type();

                        switch ($typeName)
                        {
                            case 'array':
                            case 'callable':
                            case 'bool':
                            case 'float':
                            case 'int':
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
             * Determines whether the current Type derives from the specified Type.
             *
             * @param Type $c
             * The type to compare with the current type.
             * 
             * @return bool
             * **true** if the current **Type** derives from _c_; otherwise, **false**. This method also returns **false** if _c_ and the current **Type** are equal.
             */
            public function IsSubclassOf(Type $c) : bool
            {
                if (!$this->IsValueType)
                {
                    if ($this->FullName)
                    {

                    }
                    return $this->phpType->isSubclassOf($c->FullName);
                }
                else
                {
                    return false;
                }
            }
        }
    }
?>
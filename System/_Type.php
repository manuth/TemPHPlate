<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System;
    use System\Reflection\_Binder;
    use System\Reflection\_BindingFlags;
    use System\Reflection\AmbiguousMatchException;
    use System\Reflection\_RuntimeMethodInfo;
    use System\Reflection\_MethodInfo;
    {
        /**
         * Represents type declarations: class types, interface types, array types, value types and enumeration types.
         */
        class _Type
        {
            /**
             * The default bindingflags for searching type-members.
             * @var int
             */
            private const defaultBindingAttrs =
                _BindingFlags::Instance |
                _BindingFlags::Static |
                _BindingFlags::Public;

            /**
             * The ReflectionClass of the type.
             *
             * @var \ReflectionClass|string
             */
            private $phpType;

            /**
             * Gets a reference to the default binder, which implements internal rules for selecting the appropriate members to be called.
             *
             * @var _Binder
             */
            public static $DefaultBinder;

            /**
             * Initializes a new instance of the _Type class.
             */
            protected function __construct()
            {
            }

            /**
             * Gets the type from which the current _Type directly inherits.
             * 
             * @return _Type
             */
            public function getBaseType() : ?self
            {
                if (($this->phpType instanceof \ReflectionClass) && !$this->getIsInterface() && $this->phpType->getParentClass())
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
                return ($this->phpType instanceof \ReflectionClass) && (!$this->phpType->isInterface() && !$this->phpType->isTrait()) && !$this->getIsEnum();
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
            public function getNamespace() : ?string
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
             * Gets the _Type with the specified name, performing a case-sensitive search.
             *
             * @param string $typeName
             * The fully qualified name of the type to get.
             * 
             * @return _Type
             * The type with the specified name, if found; otherwise, **null**.
             */
            public static function GetByName(string $typeName) : ?self
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
                                break;
                            case '':
                                $typeName = 'mixed';
                                break;
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
                            case 'mixed':
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
             * Searches for an instance constructor whose parameters match the types in the specified array.
             *
             * @param _Type[] $types
             * An array of Type objects representing the number, order, and type of the parameters for the desired constructor.
             * 
             * @return _MethodInfo
             * An object representing the instance constructor whose parameters match the types in the parameter type array, if found; otherwise, null.
             */
            public function GetConstructor(array $types, $bindingAttr = null, $binder = null) : ?_MethodInfo
            {
                return $this->GetMethod($this->getName(), $types, $bindingAttr, $binder);
            }

            /**
             * Returns all the constructors defined for the current _Type.
             *
             * @return _MethodInfo[]
             * An array of ConstructorInfo objects representing all the instance constructors defined for the current _Type.
             */
            public function GetConstructors() : array
            {
                if ($this->getIsClass())
                {
                    return $this->GetMethodOverloads($this->getName(), true);
                }
                else
                {
                    return array();
                }
            }

            /**
             * Searches for the specified interface, specifying whether to do a case-insensitive search for the interface name.
             *
             * @param string $name
             * The string containing the name of the interface to get. For generic interfaces, this is the mangled name
             * 
             * @param bool $ignoreCase
             * **true** to ignore the case of that part of _name_ that specifies the simple interface name (the part that specifies the namespace must be correctly cased).
             * 
             * -or-
             * 
             * **false** to perform a case-sensitive search for all parts of _name_.
             * 
             * @return self
             * An object representing the interface with the specified name, implemented or inherited by the current `_Type`, if found; otherwise, **null**.
             */
            public function GetInterface(string $name, bool $ignoreCase = false) : ?self
            {
                $expression = "/^$name$/".($ignoreCase ? 'i' : '');
                $interfaces = array_filter(
                    $this->GetInterfaces(),
                    function (_Type $interface) use ($expression, $name)
                    {
                        return 
                            (preg_match($expression, $interface->getName()) > 0) ||
                            (preg_match($expression, $interface->getFullName())) ||
                            self::GetByName($name) == $interface;
                    });

                if (count($interfaces) == 1)
                {
                    return current($interfaces);
                }
                else
                {
                    return null;
                }
            }

            /**
             * Gets all the interfaces implemented or inherited by the current `_Type`.
             *
             * @return self[]
             * An array of Type objects representing all the interfaces implemented or inherited by the current `_Type`.
             */
            public function GetInterfaces() : array
            {
                if ($this->phpType instanceof \ReflectionClass)
                {
                    return array_map(
                        function ($interfaceName)
                        {
                            return self::GetByName($interfaceName);
                        },
                        $this->phpType->getInterfaceNames());
                }
                else
                {
                    return array();
                }
            }
            
            /**
             * Returns all the methods of the current _Type.
             *
             * @return _MethodInfo[]
             * An array of \ReflectionMethod objects representing all the methods defined for the current _Type.
             */
            public function GetMethods() : array
            {
                $result = array();

                if ($this->phpType instanceof \ReflectionClass)
                {
                    foreach ($this->phpType->getMethods() as $method)
                    {
                        $result[] = new _RuntimeMethodInfo($method);
                    }
                }

                return $result;
            }

            /**
             * Searches for the specified method whose parameters match the specified argument types.
             *
             * @param string $name
             * The string containing the name of the method to get.
             * 
             * @param self[] $types
             * An array of Type objects representing the number, order, and type of the parameters for the method to get.
             * 
             * @param _Binder $binder
             * An object that defines a set of properties and enables binding, which can involve selection of an overloaded method, coercion of argument types, and invocation of a member through reflection.
             * -or-
             * A **null** reference, to use the `DefaultBinder`.
             * 
             * @return _MethodInfo
             * An object representing the method whose parameters match the specified argument types, if found; otherwise, **null**.
             */
            public function GetMethod(string $name, ?array $types = null, int $bindingAttr = null, _Binder $binder = null) : ?_MethodInfo
            {
                $bindingAttr = $bindingAttr ?? (self::defaultBindingAttrs | _BindingFlags::NonPublic);
                $binder = $binder ?? self::$DefaultBinder;
                $methods;
                $nameComparer;

                if ($types === null)
                {
                    if ($this->phpType->hasMethod($name))
                    {
                        $methods = array(new _RuntimeMethodInfo($this->phpType->getMethod($name)));
                    }
                    else
                    {
                        $methods = array();
                    }

                    $nameComparer =
                        (($bindingAttr & _BindingFlags::IgnoreCase) == _BindingFlags::IgnoreCase) ?
                            function ($methodName)
                            {
                                return true;
                            }
                        :
                            function ($methodName) use ($name, $bindingAttr)
                            {
                                return $name == $methodName;
                            };
                }
                else
                {
                    $methods = $this->GetMethodOverloads($name);
                    $expression = "/^{$name}\d*$/".((($bindingAttr & _BindingFlags::IgnoreCase) == _BindingFlags::IgnoreCase) ? 'i' : '');
                    $nameComparer =
                        function ($methodName) use ($expression)
                        {
                            return preg_match($expression, $methodName) === 1;
                        };
                }

                $match = array();

                foreach ($methods as $method)
                {
                    if (
                        self::FilterMethod(
                                $method,
                                $bindingAttr,
                                $nameComparer))
                    {
                        $match[] = $method;
                    }
                }

                return $binder->SelectMethod($bindingAttr, $match, $types);
            }

            /**
             * Returns all the properties of the current `_Type`.
             *
             * @return \ReflectionProperty[]
             * An array of `\ReflectionProperty` objects representing all public properties of the current `_Type`.
             */
            public function GetProperties() : array
            {
                return $this->phpType->getProperties();
            }

            /**
             * Searches for the property with the specified name.
             * 
             * @param string $name
             * The string containing the name of the property to get.
             * 
             * @return \ReflectionProperty
             * An object representing the property with the specified name, if found; otherwise, **null**.
             */
            public function GetProperty(string $name) : ?\ReflectionProperty
            {
                if ($this->phpType->hasProperty($name))
                {
                    return $this->phpType->getProperty($name);
                }
                else
                {
                    return null;
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
            public function IsAssignableFrom(self $c) : bool
            {
                if ($this->getFullName() == $c->getFullName())
                {
                    return true;
                }
                else if ($this->getFullName() == 'iterable')
                {
                    return $c->getIsArray() || self::GetByName('\Traversable')->IsAssignableFrom($c);
                }
                else if ($this->getFullName() == 'callable')
                {
                    return self::GetByName('\Closure')->IsAssignableFrom($c);
                }
                else if (($this->phpType instanceof \ReflectionClass) && ($c->phpType instanceof \ReflectionClass))
                {
                    return $c->phpType->isSubclassOf($this->getFullName());
                }
                else
                {
                    return false;
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
                if ((!$this->getIsInterface() && !$this->getIsValueType()) && (!$c->getIsInterface() || !$this->getIsValueType()))
                {
                    return $this->phpType->isSubclassOf($c->getFullName());
                }
                else
                {
                    return false;
                }
            }
            
            /**
             * Returns a string which represents the object.
             *
             * @return string
             * A string that represents the current object.
             */
            public function ToString() : string
            {
                return $this->getFullName();
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
             * @ignore
             */
            private static function __InitializeStatic()
            {
                self::$DefaultBinder = 
                    new class extends _Binder
                    {
                        /**
                         * Selects a method from the given set of methods, based on the argument type.
                         *
                         * @param int $bindingAttr
                         * A bitwise combination of `_BindingFlags` values.
                         * 
                         * @param _MethodInfo[] $match
                         * The set of methods that are candidates for matching.
                         * For example, when a `Binder` object is used by Type.GetMethod,
                         * this parameter specifies the set of methods that reflection has determined to be possible matches,
                         * typically because they have the correct member name. 
                         * 
                         * @param self[] $types
                         * The parameter types used to locate a matching method.
                         * 
                         * @return _MethodInfo
                         * The matching method, if found; otherwise, **null**.
                         */
                        public function SelectMethod(int $bindingAttr, array $match, array $types = null) : ?_MethodInfo
                        {
                            if ($types === null)
                            {
                                if (count($match) == 0)
                                {
                                    return null;
                                }
                                else if (count($match) > 1)
                                {
                                    throw new AmbiguousMatchException();
                                }
                                else if (count($match) == 1)
                                {
                                    return $match[0];
                                }
                                else
                                {
                                    return null;
                                }
                            }
                            else
                            {
                                if (in_array(null, $types, true))
                                {
                                    throw new ArgumentNullException('types');
                                }
                                else
                                {
                                    $result = array();
                                    $highestSpecificity = 0;
                                    $getSpecificity =
                                        function (_Type $type) : int
                                        {
                                            $result = 0;

                                            while (($type = $type->getBaseType()) != null)
                                            {
                                                $result++;
                                            }

                                            return $result;
                                        };
                                    
                                    /**
                                     * @var _MethodInfo $method
                                     */
                                    foreach ($match as $method)
                                    {
                                        if (count($types) >= $method->getNumberOfRequiredParameters() && count($types) <= $method->getNumberOfParameters())
                                        {
                                            $specificity = 0;
                                            $parameters = $method->getParameters();

                                            for ($i = count($types) - 1; $i >= 0; $i--)
                                            {
                                                if ($parameters[$i]->hasType())
                                                {
                                                    if (strtoupper($types[$i]->getFullName()) == 'NULL')
                                                    {
                                                        if (!$parameters[$i]->allowsNull())
                                                        {
                                                            continue 2;
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $type = _Type::GetByName((string)$parameters[$i]->getType());
                                                        
                                                        if (!$type->IsAssignableFrom($types[$i]))
                                                        {
                                                            continue 2;
                                                        }
                                                        else
                                                        {
                                                            $specificity += $getSpecificity($type);
                                                        }
                                                    }
                                                }
                                            }

                                            $result[$specificity][$getSpecificity($method->getDeclaringType())][] = $method;
                                        }
                                    }
                                    
                                    if (count($result) > 0)
                                    {
                                        krsort($result);
                                        $backup = $result;
                                        $result = current($result);
                                        krsort($result);
                    
                                        $result = current($result);
                    
                                        if (count($result) == 1)
                                        {
                                            return current($result);
                                        }
                                        else
                                        {
                                            throw new AmbigousMatchException();
                                        }
                                    }
                                    else
                                    {
                                        return null;
                                    }
                                }
                            }
                        }
                    };
            }
            
            /**
             * Determines whether a method matches the specified bindingflags.
             *
             * @param _RuntimeMethodInfo $method
             * The method to check.
             * 
             * @param int $bindingAttr
             * The bindingflags to check the method against.
             * 
             * @return bool
             * A value indicating whether the method matches the specified bindingflags.
             */
            private static function FilterMethod(_RuntimeMethodInfo $method, int $bindingAttr, callable $nameComparer) : bool
            {
                return
                    (
                        (
                            ((($bindingAttr & _BindingFlags::Instance) == _BindingFlags::Instance) && !$method->getIsStatic()) ||
                            ((($bindingAttr & _BindingFlags::Static) == _BindingFlags::Static) && $method->getIsStatic())
                        ) &&
                        (
                            ((($bindingAttr & _BindingFlags::Public) == _BindingFlags::Public) && $method->getIsPublic()) ||
                            ((($bindingAttr & _BindingFlags::NonPublic) == _BindingFlags::NonPublic) && !$method->getIsPublic())
                        ) &&
                        $nameComparer($method->getName())
                    );
            }
            
            /**
             * Returns all overloads of the method with the specified name.
             *
             * @param string $name
             * The name of the method whose overloads are to be returned.
             * 
             * @param bool $strictClass
             * A value that indicates whether to excluded derivered methods.
             * 
             * @return \ReflectionMethod[]
             * The overloads of the method.
             */
            private function GetMethodOverloads(string $name, bool $strictClass = false)
            {
                $result = array();
                $expression = "/^{$name}[0-9]*$/";

                /**
                 * @var \ReflectionMethod $method
                 */
                foreach ($this->phpType->getMethods() as $method)
                {
                    if (!$strictClass || $method->class === $this->phpType->name)
                    {
                        if (preg_match($expression, $method->name))
                        {
                            $result[] = new _RuntimeMethodInfo($method);
                        }
                    }
                }

                return $result;
            }
        }
    }
?>
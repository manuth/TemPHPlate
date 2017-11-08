<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System;
    use System\Collections\ArrayList;
    use System\Reflection\_Binder;
    use System\_Type;
    use System\Reflection\AmbiguousMatchException;
    use System\Reflection\_BindingFlags;
    {
        /**
         * Provides basic functionalities for objects.
         */
        trait ObjectBase
        {
            /**
             * The default bindingflags for searching public type-members.
             * @var int
             */
            private static $publicBindingFlags =
                _BindingFlags::Instance |
                _BindingFlags::Public;
            
            /**
             * The default bindingflags for searching private type-members.
             * @var int
             */
            private static $privateBindingFlags =
                _BindingFlags::Instance |
                _BindingFlags::Public |
                _BindingFlags::NonPublic;

            /**
             * Returns the type of the current constructor-level.
             *
             * @var _Type
             */
            private $constructorLevelType;
            
            /**
             * The type of this object.
             *
             * @var _Type
             */
            private $type;

            /**
             * Automatically calls the proper constructor.
             */
            public function __construct()
            {
                $this->constructorLevelType = $this->type = _Type::GetByName(get_class($this));
                $this->Initialize();
                $callerClass = $this->GetCallerClass();
                $this->InvokeConstructor($callerClass, func_get_args());
            }

            /**
             * Provides the functionallity for get-property-accessors.
             * @ignore
             */
            public function __get(string $propertyName)
            {
                $callerClass = $this->GetCallerClass();
                $this->InvokeProperty($callerClass, 'get', $propertyName, $value);
                return $value;
            }

            /**
             * Provides the functionality for set-property-accessors.
             * @ignore
             */
            public function __set(string $propertyName, $value)
            {
                $callerClass = $this->GetCallerClass();
                $this->InvokeProperty($callerClass, 'set', $propertyName, $value);
            }

            /**
             * Provides the functionality to overload methods.
             * @ignore
             */
            public final function __call($name, $args)
            {
                $callerType = _Type::GetByName($this->GetCallerClass());
                $argumentTypes = array();
                
                foreach ($args as $arg)
                {
                    switch (gettype($arg))
                    {
                        case 'object' :
                            $argumentTypes[] = _Type::GetByName(get_class($arg));
                            break;
                        default :
                            $argumentTypes[] = _Type::GetByName(gettype($arg));
                            break;
                    }
                }

                $type = $this->type;
                
                $method = $this->VerifyMethod(
                    function(?string $name, ?array $types, ?int $bindingAttr, ?_Binder $binder) use ($type)
                    {
                        return $type->GetMethod($name, $types, $bindingAttr, $binder);
                    },
                    $callerType,
                    $name,
                    $argumentTypes);
                
                if ($method !== null)
                {
                    if (!$method->isPublic())
                    {
                        $method->setAccessible(true);
                    }
    
                    return $method->invokeArgs($this, $args);
                }
                else
                {
                    trigger_error('Call to undefined method '.get_class($this).'::'.$name.'()', E_USER_ERROR);
                    exit;
                }
            }

            /**
             * Returns a string which represents the object.
             *
             * @return string
             */
            public function __toString()
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
            public function GetType() : ?_Type
            {
                return _Type::GetByName(get_class($this));
            }

            /**
             * Initializes the object.
             *
             * @return void
             */
            private function Initialize()
            {
                $types = array();

                for ($type = _Type::GetByName(get_class($this)); $type != null; $type = $type->getBaseType())
                {
                    array_splice($types, 0, 0, array($type));
                }

                foreach ($types as $type)
                {
                    if (($method = $type->GetMethod('__Initialize')) && $method->class == $type->getFullName())
                    {
                        if (!$method->isPublic())
                        {
                            $method->setAccessible(true);
                        }

                        $values = $method->invoke($this);

                        foreach ($values as $propertyName => $value)
                        {
                            $property = $type->GetProperty($propertyName);

                            if ($property != null && (!$property->isPrivate() || $property->class == $type->getFullName()))
                            {
                                $property->setAccessible(true);
                                $property->setValue($this, $value);
                            }
                            else
                            {
                                $method = $type->GetMethod('set'.$propertyName);

                                if ($method != null && (!$method->isPrivate() || $method->class == $type->getFullName()))
                                {
                                    $method->setAccessible(true);
                                    $method->invoke($this, $value);
                                }
                                else
                                {
                                    trigger_error('Undefined property: '.get_class($this).'::$'.$propertyName, E_USER_ERROR);
                                    exit;
                                }
                            }
                        }
                    }
                }
            }
            
            /**
             * @ignore
             */
            private function __Initialize() : array
            {
                return array();
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
                $type = $this->constructorLevelType;
                $this->constructorLevelType = $this->constructorLevelType->getBaseType();
                $args = func_get_args();
                $this->InvokeConstructor($type->getFullName(), $args);
                $this->constructorLevelType = $type;
            }

            /**
             * Calls a constructor of the same class.
             */
            protected function This()
            {
                $args = func_get_args();
                $this->InvokeConstructor($this->constructorLevelType->getFullName(), $args);
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
             * Returns the class of the caller of a method.
             *
             * @param int $level
             * The backtrace-level of the function-call.
             * 
             * @return string
             * The name of the class of the caller.
             */
            private function GetCallerClass(int $level = 1) : string
            {
                $level += 1;
                $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $level + 1);
                
                if (
                    array_key_exists($level, $backtrace) &&
                    array_key_exists('class', $backtrace[$level]))
                {
                    return $backtrace[$level]['class'];
                }
                else
                {
                    return '';
                }
            }

            /**
             * Determines whether a method is accessible for a class.
             *
             * @param string $class
             * The class whose access to the method is to be checked.
             * 
             * @param \ReflectionMethod $method
             * The method whose accessibility is to be checked.
             * 
             * @return bool
             * Returns a value indicating whether $methodName is accessible for the $class.
             */
            private function IsAccessible(string $class, \ReflectionMethod $method) : bool
            {
                if ($method->isPrivate())
                {
                    return $method->getDeclaringClass() == new \ReflectionClass($class);
                }
                else if ($method->isProtected())
                {
                    return !empty($class) && _Type::GetByName($class)->IsAssignableFrom($this->type);
                }
                else
                {
                    return true;
                }
            }

            /**
             * Determines the \Reflectionmethod that is to be called.
             *
             * @param string $class
             * The class that tries to access the property.
             * 
             * @param string $methodName
             * The name of the method to access the property.
             * 
             * @param bool $throwErrors
             * Indicates whether to throw errors.
             * 
             * @return \ReflectionMethod
             * A \ReflectionMethod that represents the method that is to be called.
             */
            private function InvokeProperty(string $class, string $requestType, string $propertyName, &$value)
            {
                $verify = function (string $propertyName, ?\ReflectionMethod $method, string $callerClass, bool $throwErrors) : bool
                {
                    if ($method === null)
                    {
                        if ($throwErrors)
                        {
                            trigger_error('Undefined property: '.get_class($this).'::$'.$propertyName, E_USER_ERROR);
                            exit;
                        }

                        return false;
                    }
                    else if (!$this->IsAccessible($callerClass, $method))
                    {
                        if ($throwErrors)
                        {
                            trigger_error('Cannot access'.($method->isPrivate() ? ' private' : $method->isProtected() ? ' protected' : '').' property '.$method->class.'::$'.$propertyName, E_USER_ERROR);
                            exit;
                        }

                        return false;
                    }
                    else
                    {
                        return true;
                    }
                };
                $result;

                if (
                    $class &&
                    _Type::GetByName($class)->IsAssignableFrom($this->type) &&
                    method_exists($class, $requestType.$propertyName) &&
                    ($method = new \ReflectionMethod($class, $requestType.$propertyName))->getDeclaringClass() == new \ReflectionClass($class) &&
                    $method->isPrivate())
                {
                    $result = $method;
                }
                else if (method_exists($this, $requestType.$propertyName))
                {
                    $result = new \ReflectionMethod($this, $requestType.$propertyName);
                }
                else
                {
                    $result = null;
                }

                if ($verify($propertyName, $result, $class, true))
                {
                    if (!$result->isPublic())
                    {
                        $result->setAccessible(true);
                    }

                    if ($requestType == 'get')
                    {
                        $value = $result->invokeArgs($this, array());
                    }
                    else if ($requestType == 'set')
                    {
                        $result->invokeArgs($this, array($value));
                    }
                }
            }

            /**
             * Invokes a constructor.
             *
             * @param string $callerClass
             * The class that tries to invoke the constructor.
             * 
             * @param array $args
             * The arguments to use.
             * 
             * @return void
             */
            private function InvokeConstructor(string $callerClass, array $args)
            {
                $argumentTypes = array();
                
                foreach ($args as $arg)
                {
                    switch (gettype($arg))
                    {
                        case 'object' :
                            $argumentTypes[] = _Type::GetByName(get_class($arg));
                            break;
                        default :
                            $argumentTypes[] = _Type::GetByName(gettype($arg));
                            break;
                    }
                }

                $constructorLevelType = $this->constructorLevelType;

                $constructor = $this->VerifyMethod(
                    function(?string $name, ?array $types, ?int $bindingAttr, ?_Binder $binder) use ($constructorLevelType)
                    {
                        return $constructorLevelType->GetConstructor($types, $bindingAttr, $binder);
                    },
                    _Type::GetByName($callerClass),
                    null,
                    $argumentTypes);

                if (($constructor === null) && (count($argumentTypes) != 0))
                {
                    trigger_error('Call to undefined method '.$this->type->getFullName().'::'.$this->type->getName().'()', E_USER_ERROR);
                    exit;
                }
                else if (
                    $constructor != null ||
                    $this->constructorLevelType->getBaseType() == null ||
                    (
                        $this->constructorLevelType->getBaseType()->GetConstructor(array()) != null ||
                        count($this->constructorLevelType->getBaseType()->GetConstructors()) == 0))
                {
                    if ($this->constructorLevelType->getBaseType() != null)
                    {
                        if ($constructor == null || !self::HasConstructorCall($constructor))
                        {
                            if (
                                $this->constructorLevelType->getBaseType()->GetConstructor(array()) != null ||
                                count($this->constructorLevelType->getBaseType()->GetConstructors()) == 0)
                            {
                                $this->Base();
                            }
                            else
                            {
                                throw new NotImplementedException();
                            }
                        }
                    }

                    if ($constructor != null)
                    {
                        if (!$constructor->isPublic())
                        {
                            $constructor->setAccessible(true);
                        }

                        $constructor->invokeArgs($this, $args);
                    }
                }
                else
                {
                    
                }
            }

            /**
             * Verifies whether the `$selector` returns a method with the specified BindingFlags and Binder.
             * 
             * If not the selector will be invoked in order to find an inaccessible version of the method and trigger a propper error.
             *
             * @param \Closure $selector
             * A callable variable that selects a method.
             * 
             * @param _Type $callerType
             * The type that tries to call the method.
             * 
             * @param array $types
             * The types of the arguments to call the method.
             * 
             * @param int $bindingAttr
             * The binding-flags to look for the method.
             * 
             * @param _Binder $binder
             * The binder to look for the method.
             * 
             * @return \ReflectionMethod
             * The method with the propper name, accessor and argument-types.
             */
            private function VerifyMethod(\Closure $selector, ?_Type $callerType, ?string $name, ?array $types) : ?\ReflectionMethod
            {
                $bindingAttr = ($callerType !== null && $callerType->IsAssignableFrom($this->type)) ? self::$privateBindingFlags : self::$publicBindingFlags;

                $binder =
                    new class($callerType) extends _Binder
                    {
                        /**
                         * The type that is to be checked for accessibility.
                         *
                         * @var _Type
                         */
                        private $type;
                        
                        public function __construct($type)
                        {
                            $this->type = $type;
                        }

                        /**
                         * Selects a method from the given set of methods, based on the argument type.
                         *
                         * @param int $bindingAttr
                         * A bitwise combination of `_BindingFlags` values.
                         * 
                         * @param \ReflectionMethod[] $match
                         * The set of methods that are candidates for matching.
                         * For example, when a `Binder` object is used by Type.GetMethod,
                         * this parameter specifies the set of methods that reflection has determined to be possible matches,
                         * typically because they have the correct member name. 
                         * 
                         * @param array $types
                         * The parameter types used to locate a matching method.
                         * 
                         * @return \ReflectionMethod
                         * The matching method, if found; otherwise, **null**.
                         */
                        public function SelectMethod(int $bindingAttr, array $match, array $types = null) : ?\ReflectionMethod
                        {
                            $result = array();

                            /**
                             * @var \ReflectionMethod $method
                             */
                            foreach ($match as $method)
                            {
                                if (
                                    $method->isPublic() ||
                                    ($method->isProtected() && $this->type->IsAssignableFrom(_Type::GetByName($method->class))) ||
                                    ($method->isPrivate() && ($method->class == $this->type->getFullName())))
                                $result[] = $method;
                            }

                            return _Type::$DefaultBinder->SelectMethod($bindingAttr, $result, $types);
                        }
                    };

                $method = $selector($name, $types, $bindingAttr, $binder);

                if ($method !== null)
                {
                    return $method;
                }
                else
                {
                    $method = $selector($name, $types, self::$privateBindingFlags, _Type::$DefaultBinder);

                    if ($method != null)
                    {
                        trigger_error('Call to '.($method->isPrivate() ? 'private ' : ($method->isProtected() ? 'protected ' : '')).$method->class.'::'.$method->name.' from invalid context.', E_USER_ERROR);
                        exit;
                    }
                    else
                    {
                        return null;
                    }
                }
            }
        }
    }
?>
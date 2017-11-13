<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Reflection;
    use System\_Type;
    {
        /**
         * Discovers the attributes of a method and provides access to method metadata.
         */
        class _RuntimeMethodInfo extends _MethodInfo
        {
            /**
             * The `\ReflectionMethod` that is wrapped by this `_RuntimeMethodInfo`.
             * 
             * @var \ReflectionMethod
             */
            private $method;

            /**
             * Gets the class that declares this member.
             *
             * @return _Type
             */
            public function getDeclaringType() : _Type
            {
                return _Type::GetByName($this->method->class);
            }

            /**
             * Gets a value indicating whether the method is abstract.
             *
             * @return bool
             */
            public function getIsAbstract() : bool
            {
                return $this->method->isAbstract();
            }

            /**
             * Gets a value indicating whether the method is a constructor.
             *
             * @return bool
             */
            public function getIsConstructor() : bool
            {
                return preg_match("/^{$this->method->class}\d*$/", $this->method->name) === 1;
            }

            /**
             * Gets a value indicating whether the visibility of this method or constructor is described by its Family; that is, the method or constructor is visible only within its class and derived classes.
             *
             * @return bool
             */
            public function getIsFamily() : bool
            {
                return $this->method->isProtected();
            }

            /**
             * Gets a value indicating whether this method is **final**.
             *
             * @return bool
             */
            public function getIsFinal() : bool
            {
                return $this->method->isFinal();
            }
            
            /**
             * Gets a value indicating whether this member is private.
             *
             * @return bool
             */
            public function getIsPrivate() : bool
            {
                return $this->method->isPrivate();
            }

            /**
             * Gets a value indicating whether this is a public method.
             *
             * @return bool
             */
            public function getIsPublic() : bool
            {
                return $this->method->isPublic();
            }

            /**
             * Gets a value indicating whether the method is **static**.
             *
             * @return bool
             */
            public function getIsStatic() : bool
            {
                return $this->method->isStatic();
            }

            /**
             * Gets the name of the current member.
             * 
             * @return string
             */
            public function getName() : string
            {
                return $this->method->name;
            }

            /**
             * Gets the return type of this method.
             * 
             * @return _Type
             */
            public function getReturnType() : ?_Type
            {
                if ($this->method->hasReturnType())
                {
                    return _Type::GetByName((string)$this->method->getReturnType());
                }
                else
                {
                    return null;
                }
            }
            
            /**
             * Gets the number of parameters.
             *
             * @return int
             */
            public function getNumberOfParameters() : int
            {
                return $this->method->getNumberOfParameters();
            }

            /**
             * Gets the number of required parameters.
             *
             * @return int
             */
            public function getNumberOfRequiredParameters() : int
            {
                return $this->method->getNumberOfRequiredParameters();
            }

            /**
             * Gets the `\ReflectionMethod` wrapped by this `_RuntimeMethodInfo`.
             * 
             * @return \ReflectionMethod
             */
            public function getReflectionMethod() : ?\ReflectionMethod
            {
                return $this->method;
            }

            /**
             * Initializes a new instance of the `_RuntimeMethodInfo` class with a `\ReflectionMethod`.
             *
             * @param \ReflectionMethod $method
             * The method that is to be wrapped by the `_RuntimeMethodInfo`.
             */
            public function __construct(\ReflectionMethod $method)
            {
                $this->method = $method;
            }

            /**
             * Returns the MethodInfo object for the method on the direct or indirect base class in which the method represented by this instance was first declared.
             * 
             * @return _MethodInfo
             * A `_MethodInfo` object for the first implementation of this method.
             */
            public function GetBaseDefinition() : _MethodInfo
            {
                $result = $this->method;

                for (
                    $method = $result;
                    $method !== null;
                    $method =
                        method_exists($method->getDeclaringClass()->getParentClass()->name, $method->name) ?
                            $method->getDeclaringClass()->getParentClass()->getMethod($method->name) :
                            null)
                {
                    $result = $method;
                }

                return new self($result);
            }

            /**
             * Gets the source-code of the method.
             *
             * @return string
             * The source-code of the method.
             */
            public function GetMethodBody() : string
            {
                return implode(
                    "",
                    array_slice(
                        file($this->method->getFileName()),
                        $this->method->getStartLine(),
                        $this->method->getEndLine() - $this->method->getStartLine()));
            }

            /**
             * Gets the parameters of the specified method or constructor.
             *
             * @return \ReflectionParameter[]
             * An array of type `\ReflectionParameter` containing information that matches the signature of the method (or constructor) reflected by this `_MethodBase` instance.
             */
            public function GetParameters() : array
            {
                return $this->method->getParameters();
            }

            /**
             * Invokes the method or constructor represented by the current instance, using the specified parameters.
             *
             * @param mixed $obj
             * The object on which to invoke the method or constructor. If a method is static, this argument is ignored. If a constructor is static, this argument must be **null** or an instance of the class that defines the constructor.
             * 
             * @param array $parameters
             * An argument list for the invoked method or constructor. This is an array of objects with the same number, order, and type as the parameters of the method or constructor to be invoked. If there are no parameters, parameters should be **null**.
             * 
             * If the method or constructor represented by this instance takes a ref parameter, no special attribute is required for that parameter in order to invoke the method or constructor using this function. Any object in this array that is not explicitly initialized with a value will contain the default value for that object type. For reference-type elements, this value is null. For value-type elements, this value is 0, 0.0, or false, depending on the specific element type.
             * 
             * @return mixed
             * An object containing the return value of the invoked method, or **null** in the case of a constructor.
             */
            public function Invoke($obj, array $parameters)
            {
                /**
                 * @var _RuntimeMethodInfo $method
                 */
                if ($this->getIsPrivate())
                {
                    $method = $this->method;
                }
                else
                {
                    $method = new \ReflectionMethod($obj, $this->method->name);
                }
                
                if (!$method->isPublic())
                {
                    $method->setAccessible(true);
                }

                return $method->invokeArgs($obj, $parameters);
            }
        }
    }
?>
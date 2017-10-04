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
         * Gets the type from which the current `Type` directly inherits.
         * 
         * @property-read string $FullName
         * Gets the fully qualified name of the type, including its namespace but not its assembly.
         * 
         * @property-read bool $IsAbstract
         * Gets a value indicating whether the `Type` is abstract and must be overridden.
         * 
         * @property-read bool $IsArray
         * Gets a value that indicates whether the type is an array.
         * 
         * @property-read bool $IsClass
         * Gets a value indicating whether the `Type` is a class or a delegate; that is, not a value type or interface.
         * 
         * @property-read bool $IsEnum
         * Gets a value indicating whether the current `Type` represents an enumeration.
         * 
         * @property-read bool $IsInterface
         * Gets a value indicating whether the `Type` is an interface; that is, not a class or a value type.
         * 
         * @property-read bool $IsSealed
         * Gets a value indicating whether the `Type` is declared sealed.
         * 
         * @property-read bool $IsValueType
         * Gets a value indicating whether the `Type` is a value type.
         * 
         * @property-read string $Name
         * Gets the name of the current member.
         * 
         * @property-read string $Namespace
         * Gets the namespace of the `Type`.
         */
        class Type extends Object
        {
            /**
             * The ReflectionClass of the type.
             *
             * @var _Type
             */
            private $type;

            /**
             * Initializes a new instance of the `Type` class.
             */
            protected function Type()
            {
            }

            /**
             * @ignore
             * @return Type
             */
            public function getBaseType() : ?self
            {
                return self::FromType($this->type->getBaseType());
            }

            /**
             * @ignore
             * @return string
             */
            public function getFullName() : string
            {
                return $this->type->getFullName();
            }

            /**
             * @ignore
             * @return bool
             */
            public function getIsAbstract() : bool
            {
                return $this->type->getIsAbstract();
            }
            
            /**
             * Gets a value that indicates whether the type is an array.
             * @return bool
             */
            public function getIsArray() : bool
            {
                return $this->type->getIsArray();
            }

            /**
             * @ignore
             * @return bool
             */
            public function getIsClass() : bool
            {
                return $this->type->getIsClass();
            }

            /**
             * @ignore
             * @return bool
             */
            public function getIsEnum() : bool
            {
                return $this->type->getIsEnum();
            }

            /**
             * @ignore
             * @return bool
             */
            public function getIsInterface() : bool
            {
                return $this->type->getIsInterface();
            }

            /**
             * @ignore
             * @return bool
             */
            public function getIsSealed() : bool
            {
                return $this->type->getIsSealed();
            }

            /**
             * @ignore
             * @return bool
             */
            public function getIsValueType() : bool
            {
                return $this->type->getIsValueType();
            }

            /**
             * @ignore
             * @return string
             */
            public function getName() : string
            {
                return $this->type->getName();
            }

            /**
             * @ignore
             * @return string
             */
            public function getNamespace() : ?string
            {
                return $this->type->getNamespace();
            }

            /**
             * Gets the `Type` according to the specified `_Type` object.
             *
             * @param _Type $type
             * the `_Type` that is to be wrapped.
             * 
             * @return self
             * The `Type` object.
             */
            private static function FromType(?_Type $type) : ?self
            {
                if ($type !== null)
                {
                    $result = new self();
                    $result->type = $type;
                }
                else
                {
                    $result = null;
                }

                return $result;
            }
            
            /**
             * Gets the `Type` with the specified name, performing a case-sensitive search.
             *
             * @param string $typeName
             * The fully qualified name of the type to get.
             * 
             * @return Type
             * The type with the specified name, if found; otherwise, **null**.
             */
            public static function GetByName(string $typeName) : ?self
            {
                return self::FromType(_Type::GetByName($typeName));
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
                return $this->type->GetConstructor(
                    array_map(
                        function (self $type)
                        {
                            return $type->type;
                        },
                        $types));
            }

            /**
             * Returns all the constructors defined for the current `Type`.
             *
             * @return \ReflectionMethod[]
             * An array of ConstructorInfo objects representing all the instance constructors defined for the current `Type`.
             */
            public function GetConstructors() : array
            {
                return $this->type->GetConstructors();
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
             * An object representing the interface with the specified name, implemented or inherited by the current `Type`, if found; otherwise, **null**.
             */
            public function GetInterface(string $name, bool $ignoreCase = false)
            {
                return self::FromType($this->type->GetInterface($name, $ignoreCase));
            }
            
            /**
             * Gets all the interfaces implemented or inherited by the current `_Type`.
             *
             * @return self[]
             * An array of Type objects representing all the interfaces implemented or inherited by the current `_Type`.
             */
            public function GetInterfaces() : array
            {
                return array_map(array(__CLASS__, 'FromType'), $this->type->GetInterfaces());
            }

            /**
             * Returns all the public methods of the current Type.
             *
             * @return \ReflectionMethod[]
             * An array of \ReflectionMethod objects representing all the public methods defined for the current `Type`.
             */
            public function GetMethods() : array
            {
                return $this->type->GetMethods();
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
                return $this->type->GetMethod(
                    $name,
                    array_map(
                        function (self $type)
                        {
                            return $type->type;
                        },
                        $types));
            }
            
            /**
             * Returns all the properties of the current `Type`.
             *
             * @return \ReflectionProperty[]
             * An array of `\ReflectionProperty` objects representing all public properties of the current `Type`.
             */
            public function GetProperties() : array
            {
                return $this->type->GetProperties();
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
            public function GetProperty(string $name) : \ReflectionProperty
            {
                return $this->type->GetProperty($name);
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
                return $this->type->IsAssignableFrom($c->type);
            }

            /**
             * Determines whether the current `Type` derives from the specified `Type`.
             *
             * @param Type $c
             * The type to compare with the current type.
             * 
             * @return bool
             * **true** if the current **Type** derives from _c_; otherwise, **false**. This method also returns **false** if _c_ and the current **Type** are equal.
             */
            public function IsSubclassOf(Type $c) : bool
            {
                return $this->type->IsSubclassOf($c->type);
            }
            
            /**
             * Returns a string which represents the object.
             *
             * @return string
             * A string that represents the current object.
             */
            public function ToString() : string
            {
                return $this->type->ToString();
            }
        }
    }
?>
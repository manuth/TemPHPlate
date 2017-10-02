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
             * @var _Type
             */
            private $type;

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
            public function getBaseType() : ?self
            {
                return $this->type->getBaseType();
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
            public function getNamespace() : string
            {
                return $this->type->getNamespace();
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
                return $this->type->GetConstructor($types);
            }

            /**
             * Returns all the constructors defined for the current Type.
             *
             * @return \ReflectionMethod[]
             * An array of ConstructorInfo objects representing all the instance constructors defined for the current Type.
             */
            public function GetConstructors() : array
            {
                return $this->type->GetConstructors();
            }

            /**
             * Returns all the public methods of the current Type.
             *
             * @return \ReflectionMethod[]
             * An array of \ReflectionMethod objects representing all the public methods defined for the current Type.
             */
            public function GetMethods() : array
            {
                return $this->type->GetMethods();
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
                return $this->type->IsSubclassOf($c->type);
            }
        }
    }
?>
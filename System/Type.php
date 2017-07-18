<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System
    {
        /**
         * Represents type declarations: class types and interface types.
         * 
         * @property-read Type $BaseType
         * Gets the type from which the current Type directly inherits.
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
             * @var \ReflectionClass
             */
            private $phpType;

            /**
             * Undocumented function
             *
             * @return void
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
                return $this->phpType->getParentClass();
            }

            /**
             * @ignore
             * @return string
             */
            public function getFullName() : string
            {
                return $this->phpType->getName();
            }

            /**
             * @ignore
             * @return bool
             */
            public function getIsAbstract() : bool
            {
                return $this->phpType->isAbstract();
            }

            /**
             * @ignore
             * @return bool
             */
            public function getIsClass() : bool
            {
                return !$this->phpType->isInterface() && !$this->phpType->isTrait();
            }

            /**
             * @ignore
             * @return bool
             */
            public function getIsEnum() : bool
            {
                return $this->phpType->isSubclassOf('System\Enum');
            }

            /**
             * @ignore
             * @return bool
             */
            public function getIsInterface() : bool
            {
                return $this->phpType->isInterface();
            }

            /**
             * @ignore
             * @return bool
             */
            public function getIsSealed() : bool
            {
                return $this->phpType->isFinal();
            }

            /**
             * @ignore
             * @return string
             */
            public function getName() : string
            {
                return $this->phpType->getShortName();
            }

            /**
             * @ignore
             * @return string
             */
            public function getNamespace() : string
            {
                return $this->phpType->getNamespaceName();
            }

            /**
             * Undocumented function
             *
             * @return void
             */
            public function GetConstructors() : array
            {
                $result = array();

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

                return $result;
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
                        $phpType = new \ReflectionClass($typeName);
                        $type = new Type();
                        $type->phpType = $phpType;
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
        }
    }
?>
<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Reflection;
    use System\Type;
    {
        /**
         * Discovers the attributes of a method and provides access to method metadata.
         */
        abstract class MethodInfo
        {
            /**
             * Gets the class that declares this member.
             *
             * @return Type
             */
            public abstract function getDeclaringType() : Type;

            /**
             * Gets a value indicating whether the method is abstract.
             *
             * @return bool
             */
            public abstract function getIsAbstract() : bool;

            /**
             * Gets a value indicating whether the method is a constructor.
             *
             * @return bool
             */
            public abstract function getIsConstructor() : bool;

            /**
             * Gets a value indicating whether the visibility of this method or constructor is described by its Family; that is, the method or constructor is visible only within its class and derived classes.
             *
             * @return bool
             */
            public abstract function getIsFamily() : bool;

            /**
             * Gets a value indicating whether this method is **final**.
             *
             * @return bool
             */
            public abstract function getIsFinal() : bool;
            
            /**
             * Gets a value indicating whether this member is private.
             *
             * @return bool
             */
            public abstract function getIsPrivate() : bool;

            /**
             * Gets a value indicating whether this is a public method.
             *
             * @return bool
             */
            public abstract function getIsPublic() : bool;

            /**
             * Gets a value indicating whether the method is **static**.
             *
             * @return bool
             */
            public abstract function getIsStatic() : bool;

            /**
             * Gets the name of the current member.
             * 
             * @return string
             */
            public abstract function getName() : string;

            /**
             * Gets the return type of this method.
             * 
             * @return Type
             */
            public abstract function getReturnType() : ?Type;

            /**
             * Returns the MethodInfo object for the method on the direct or indirect base class in which the method represented by this instance was first declared.
             * 
             * @return MethodInfo
             * A `MethodInfo` object for the first implementation of this method.
             */
            public abstract function GetBaseDefinition() : MethodInfo;

            /**
             * Gets the source-code of the method.
             *
             * @return string
             * The source-code of the method.
             */
            public abstract function GetMethodBody() : string;

            /**
             * Gets the parameters of the specified method or constructor.
             *
             * @return \ReflectionParameter[]
             * An array of type `\ReflectionParameter` containing information that matches the signature of the method (or constructor) reflected by this `MethodInfo` instance.
             */
            public abstract function GetParameters() : array;

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
            public abstract function Invoke($obj, array $parameters);
        }
    }
?>
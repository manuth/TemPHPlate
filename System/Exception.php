<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System
    {
        /**
         * Represents errors that occur during execution.
         */
        class Exception extends \Exception implements IObject
        {
            use ObjectBase
            {

                Cast as private CastInternal;
                ToString as private ToStringInternal;
                GetHashCode as private GetHashCodeInternal;
                GetType as private GetTypeInternal;
            }

            /**
             * Gets a collection of key/value pairs that provide additional user-defined information about the exception.
             *
             * @var array
             */
            public $Data;

            /**
             * Initializes a new instance of the Exception class.
             */
            public function Exception()
            {
                $this->This('');
            }

            /**
             * Initializes a new instance of the Exception class.
             * 
             * @param string $message
             * The message of the exception.
             */
            public function Exception1(string $message)
            {
                $this->This($message, null);
            }

            /**
             * Initializes a new instance of the Exception class.
             * 
             * @param string $message
             * The message of the exception.
             * 
             * @param \Exception $innerException
             * The exception that is the cause of the current exception. If the innerException parameter is not null, the current exception is raised in a catch block that handles the inner exception.
             */
            public function Exception2(string $message, ?\Exception $innerException)
            {
                parent::__construct($message, 0, $innerException);
            }

            /**
             * Casts the object to another type.
             *
             * @param string $class
             * The type to convert the object to.
             * 
             * @return mixed 
             * The casted object.
             */
            public function Cast(string $class)
            {
                return $this->CastInternal($cast);
            }

            /**
             * Returns a string which represents the object.
             *
             * @return string
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
        }
    }
?>
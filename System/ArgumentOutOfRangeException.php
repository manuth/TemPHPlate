<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System;
    use System\ArgumentException;
    {
        /**
         * The exception that is thrown when a method attempts to construct a culture that is not avaiblable.
         */
        class ArgumentOutOfRangeException extends ArgumentException
        {
            /**
             * Gets or sets the value of the argument that causes this exception.
             *
             * @var object
             */
            public $ActualValue = null;

            /**
             * Initializes a new instance of the ArgumentOutOfRangeException class.
             *
             * @param string $name
             * The name of the argument which caused the exception.
             */
            public function ArgumentOutOfRangeException2($paramName, $actualValue)
            {
                $this->This($paramName, $actualValue, '', null);
            }

            /**
             * Initializes a new instance of the ArgumentOutOfRangeException class.
             *
             * @param string $name
             * The name of the argument which caused the exception.
             * 
             * @param object $actualValue
             * 
             * @param string $message
             * The message of the exception.
             * 
             * @param Exception $innerException
             * The exception that is the cause of the current exception. If the innerException parameter is not null, the current exception is raised in a catch block that handles the inner exception.
             */
            public function ArgumentOutOfRangeException4($paramName, $actualValue, $message, $innerException)
            {
                $this->Base($paramName, $message, $innerException);
                $this->ActualValue = $actualValue;
            }
        }
    }
?>
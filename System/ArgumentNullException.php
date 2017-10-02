<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System
    {
        /**
         * The exception that is thrown when one of the arguments provided to a method is not valid.
         */
        class ArgumentNullException extends Exception
        {
            /**
             * Initializes a new instance of the ArgumentNullException class.
             *
             * @param string $paramName
             * The name of the argument which caused the exception.
             */
            public function ArgumentNullException1(?string $paramName)
            {
                $this->Base($paramName, '', null);
            }

            /**
             * Initializes a new instance of the ArgumentException class.
             *
             * @param string $paramName
             * The name of the argument which caused the exception.
             * 
             * @param string $message
             * The message of the exception.
             * 
             * @param \Exception $innerException
             * The exception that is the cause of the current exception. If the innerException parameter is not null, the current exception is raised in a catch block that handles the inner exception.
             */
            public function ArgumentException3(?string $paramName, ?string $message, ?\Exception $innerException)
            {
                $this->Base($paramName, $message, $innerException);
            }
        }
    }
?>
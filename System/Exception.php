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
        class Exception extends \Exception
        {
            /**
             * Gets a collection of key/value pairs that provide additional user-defined information about the exception.
             *
             * @var array
             */
            public $Data;

            /**
             * Initializes a new instance of the Exception class.
             * 
             * @param string $message
             * The message of the exception.
             * 
             * @param Exception $innerException
             * The exception that is the cause of the current exception. If the innerException parameter is not null, the current exception is raised in a catch block that handles the inner exception.
             */
            public function Exception($message = '', $innerException = null)
            {
                $this->Base($message, 0, $innerException);
            }
        }
    }
?>
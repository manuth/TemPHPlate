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
        class ArgumentException extends Exception
        {
            /**
             * Gets or sets the name of the argument which caused the exception.
             * @var string
             */
            public $ParamName;

            /**
             * Initializes a new instance of the ArgumentException class.
             *
             * @param string $name
             * The name of the argument which caused the exception.
             * 
             * @param string $message
             * The message of the exception.
             * 
             * @param Exception $innerException
             * The exception that is the cause of the current exception. If the innerException parameter is not null, the current exception is raised in a catch block that handles the inner exception.
             */
            public function __construct($paramName = '', $message = '', $innerException = null)
            {
                parent::__construct($message, $innerException);
                $this->ParamName = $paramName;
            }
        }
    }
?>
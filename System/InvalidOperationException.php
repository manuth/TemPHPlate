<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System
    {
        /**
         * The exception that is thrown when a method call is invalid for the object's current state.
         */
        class InvalidOperationException extends Exception implements IObject
        {
            /**
             * Initializes a new instance of the InvalidOperationException1 class.
             */
            public function InvalidOperationException()
            {
                $this->Base();
            }

            /**
             * Initializes a new instance of the InvalidOperationException1 class.
             * 
             * @param string $message
             * The message of the exception.
             */
            public function InvalidOperationException1(?string $message)
            {
                $this->Base($message);
            }

            /**
             * Initializes a new instance of the InvalidOperationException1 class.
             * 
             * @param string $message
             * The message of the exception.
             * 
             * @param \Exception $innerException
             * The exception that is the cause of the current exception. If the innerException parameter is not null, the current exception is raised in a catch block that handles the inner exception.
             */
            public function InvalidOperationException12(?string $message, ?\Exception $innerException)
            {
                $this->Base($message, $innerException);
            }
        }
    }
?>
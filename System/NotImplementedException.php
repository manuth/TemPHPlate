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
        class NotImplementedException extends Exception implements IObject
        {
            /**
             * Initializes a new instance of the Exception class.
             */
            public function NotImplementedException()
            {
                $this->Base();
            }

            /**
             * Initializes a new instance of the NotImplementedException class.
             * 
             * @param string $message
             * The message of the exception.
             */
            public function NotImplementedException1(string $message)
            {
                $this->Base($message);
            }

            /**
             * Initializes a new instance of the NotImplementedException class.
             * 
             * @param string $message
             * The message of the exception.
             * 
             * @param \Exception $innerException
             * The exception that is the cause of the current exception. If the innerException parameter is not null, the current exception is raised in a catch block that handles the inner exception.
             */
            public function NotImplementedException2(string $message, ?\Exception $innerException)
            {
                $this->Base($message, $innerException);
            }
        }
    }
?>
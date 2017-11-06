<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Reflection;
    use System\Exception;
    {
        /**
         * The exception that is thrown when binding to a member results in more than one member matching the binding criteria.
         */
        final class AmbiguousMatchException extends Exception
        {
            /**
             * Initializes a new instance of the AmbiguousMatchException class.
             */
            public function AmbiguousMatchException()
            {
            }

            /**
             * Initializes a new instance of the AmbiguousMatchException class.
             * 
             * @param string $message
             * The message of the exception.
             */
            public function AmbiguousMatchException1(?string $message)
            {
                $this->Base($message);
            }

            /**
             * Initializes a new instance of the AmbiguousMatchException class.
             * 
             * @param string $message
             * The message of the exception.
             * 
             * @param \Exception $innerException
             * The exception that is the cause of the current exception. If the innerException parameter is not null, the current exception is raised in a catch block that handles the inner exception.
             */
            public function AmbiguousMatchException2(?string $message, ?\Exception $innerException)
            {
                $this->Base($message, $innerException);
            }
        }
    }
?>
<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\IO;
    use System\Exception;
    {
        /**
         * The exception that is thrown when an I/O error occurs.
         */
        class IOException extends Exception
        {
            /**
             * Initializes a new instance of the Exception class.
             */
            public function IOException()
            {
                $this->This('', null);
            }

            /**
             * Initializes a new instance of the Exception class.
             * 
             * @param string $message
             * The message of the exception.
             * 
             * @param Exception $innerException
             * The exception that is the cause of the current exception. If the innerException parameter is not null, the current exception is raised in a catch block that handles the inner exception.
             */
            public function IOException2($message, $innerException)
            {
                $this->Base($message, 0, $innerException);
            }
        }
    }
?>
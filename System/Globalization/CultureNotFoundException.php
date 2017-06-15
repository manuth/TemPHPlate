<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Globalization;
    use System\ArgumentException;
    {
        /**
         * The exception that is thrown when a method attempts to construct a culture that is not avaiblable.
         */
        class CultureNotFoundException extends ArgumentException
        {
            /**
             * Initializes a new instance of the ArgumentException class.
             *
             * @param string $invalidCultureName
             * The Culture Name that cannot be found.
             * 
             * @param string $message
             * The message of the exception.
             * 
             * @param Exception $innerException
             * The exception that is the cause of the current exception. If the innerException parameter is not null, the current exception is raised in a catch block that handles the inner exception.
             */
            public function __construct($invalidCultureName = '', $message = '', $innerException = null)
            {
                parent::__construct($invalidCultureName, $message, $innerException);
            }
        }
    }
?>
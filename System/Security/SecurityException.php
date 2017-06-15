<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Security;
    use System\Exception;
    {
        /**
         * The exception that is thrown when a security error is detected.
         */
        class SecurityException extends Exception
        {
            /**
             * Gets or sets the demanded security permission, permission set, or permission set collection that failed.
             *
             * @var object
             */
            public $Demanded;

            /**
             * Initializes a new instance of the SecurityException class.
             *
             * @param object $demanded
             * The demanded security permission, permission set, or permission set collection that failed.
             * 
             * @param string $message
             * The message of the exception.
             * 
             * @param Exception $innerException
             * The exception that is the cause of the current exception. If the innerException parameter is not null, the current exception is raised in a catch block that handles the inner exception.
             */
            public function __construct($demanded, $message = '', $innerException = null)
            {
                parent::__construct($message, $innerException);
                $this->Demanded = $demanded;
            }
        }
    }
?>
<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\IO;
    use System\Exception;
    {
        /**
         * The exception that is thrown when an attempt to access a file that does not exist on disk fails.
         */
        class FileNotFoundException extends IOException
        {
            /**
             * Gets the name of the file that cannot be found.
             *
             * @var string
             */
            public $FileName;

            public function FileNotFoundException1(string $fileName)
            {
                $this->This($fileName, '', null);
            }

            /**
             * Initializes a new instance of the FileNotFoundException class with a specified error message and a reference to the inner exception that is the cause of this exception.
             *
             * @param object $demanded
             * The full name of the file with the invalid image.
             * 
             * @param string $fileName
             * The message of the exception.
             * 
             * @param \Exception $innerException
             * The exception that is the cause of the current exception. If the innerException parameter is not null, the current exception is raised in a catch block that handles the inner exception.
             */
            public function FileNotFoundException3(string $fileName, string $message, ?\Exception $innerException)
            {
                $this->Base($fileName, $innerException);
                $this->FileName = $fileName;
            }
        }
    }
?>
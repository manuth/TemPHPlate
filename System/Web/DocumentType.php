<?php
    namespace System\Web;
    use System\Enum;
    {
        /**
         * Represents a type of a document.
         */
        class DocumentType extends Enum
        {
            /**
             * The PHP document-type.
             */
            static $PHP = 1;

            /**
             * The MarkDown document-type.
             */
            static $MarkDown = 2;

            /**
             * The HTML document-type.
             */
            static $HTML = 4;

            /**
             * Other documet-types.
             */
            static $Other = 8;
        }
    }
?>
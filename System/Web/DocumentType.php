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
            static $PHP;

            /**
             * The MarkDown document-type.
             */
            static $MarkDown;

            /**
             * The HTML document-type.
             */
            static $HTML;

            /**
             * Other documet-types.
             */
            static $Other;
        }
    }
?>
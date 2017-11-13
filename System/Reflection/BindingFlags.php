<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Reflection;
    use System\Enum;
    {
        /**
         * Specifies flags that control binding and the way in which the search for members and types is conducted by reflection.
         */
        class BindingFlags extends Enum
        {
            /**
             * Specifies that no binding flags are defined.
             */
            public static $Default = 0;

            /**
             * Specifies that the case of the member name should not be considered when binding.
             */
            public static $IgnoreCase = 1;

            /**
             * Specifies that instance members are to be included in the search.
             */
            public static $Instance = 2;

            /**
             * Specifies that non-public members are to be included in the search.
             */
            public static $NonPublic = 4;

            /**
             * Specifies that public members are to be included in the search.
             */
            public static $Public = 8;

            /**
             * Specifies that static members are to be included in the search.
             */
            public static $Static = 16;
        }
    }
?>
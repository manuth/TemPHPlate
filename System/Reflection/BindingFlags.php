<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Reflection;
    use System\Enum;
    use System\Reflection\_BindingFlags;
    {
        /**
         * Specifies flags that control binding and the way in which the search for members and types is conducted by reflection.
         */
        class BindingFlags extends Enum
        {
            /**
             * Specifies that no binding flags are defined.
             * 
             * @var self
             */
            public static $Default = _BindingFlags::Default;

            /**
             * Specifies that the case of the member name should not be considered when binding.
             * 
             * @var self
             */
            public static $IgnoreCase = _BindingFlags::IgnoreCase;

            /**
             * Specifies that instance members are to be included in the search.
             * 
             * @var self
             */
            public static $Instance = _BindingFlags::Instance;

            /**
             * Specifies that non-public members are to be included in the search.
             * 
             * @var self
             */
            public static $NonPublic = _BindingFlags::NonPublic;

            /**
             * Specifies that public members are to be included in the search.
             * 
             * @var self
             */
            public static $Public = _BindingFlags::Public;

            /**
             * Specifies that static members are to be included in the search.
             * 
             * @var self
             */
            public static $Static = _BindingFlags::Static;
        }
    }
?>
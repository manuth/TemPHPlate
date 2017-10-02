<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System;
    {
        /**
         * Represents the base class for classes that contain event data, and provides a value to use for events that do not include event data.
         */
        class EventArgs extends Base
        {
            /**
             * Returns an empty instance of the EventArgs class.
             *
             * @var EventArgs
             */
            public static $Empty;
            
            /**
             * @ignore
             */
            public static function __InitializeStatic()
            {
                self::$Empty = new EventArgs();
            }
        }
    }
?>
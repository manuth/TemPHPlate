<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System;
    {
        /**
         * Represents the base class for classes that contain event data, and provides a value to use for events that do not include event data.
         *
         * @package manuth.TemPHPlate
         * @subpackage Core
         *
         * @property-read EventArgs $Empty
         * Returns an empty instance of the EventArgs class
         */
        class EventArgs extends Base
        {
            /**
             * @ignore
             */
            public function getEmpty()
            {
                return new EventArgs();
            }
        }
    }
?>
<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System;
    {
        /**
         * Represents an event
         *
         * @package manuth.TemPHPlate
         * @subpackage Core
         */
        class Event extends \ArrayObject
        {
            /**
             * Executes the callbacks objects of the event
             *
             * @param object $sender
             * The source of the event
             * @param object $e
             * An object that contains no event data
             */
            public function Invoke($sender, EventArgs $e)
            {
                foreach ($this as $callback)
                {
                    $callback->Invoke($sender, $e);
                }
            }
        }
    }
?>
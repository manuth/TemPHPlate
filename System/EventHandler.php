<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System;
    use System\Collections\ArrayList;
    {
        /**
         * Represents the method that will handle an event that has no event data.
         */
        class EventHandler extends ArrayList
        {
            /**
             * Executes the callbacks objects of the event.
             *
             * @param object $sender
             * The source of the event.
             * @param object $e
             * An object that contains no event data.
             */
            public function __invoke($sender, $e)
            {
                foreach ($this as $callback)
                {
                    $callback($sender, $e);
                }
            }
        }
    }
?>
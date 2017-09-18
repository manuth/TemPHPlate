<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web\Forms\Rendering;
    use System\EventHandler;
    {
        /**
         * Represents the method that will handle the `Paint`-event of an `IRenderer`.
         */
        class PaintEventHandler extends EventHandler
        {
            /**
             * Executes the callbacks objects of the event
             *
             * @param object $sender
             * The source of the event
             * @param object $e
             * A PaintEventArgs that contains the event data.
             */
            public function Invoke($sender, PaintEventArgs $e)
            {
                foreach ($this as $callback)
                {
                    $callback->Invoke($sender, $e);
                }
            }
        }
    }
?>
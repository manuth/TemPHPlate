<?php
    namespace System;
    {
        /**
         * Provides data for a cancelable event.
         */
        class CancelEventArgs extends EventArgs
        {
            /**
             * Gets or sets a value indicating whether the event should be canceled.
             *
             * @var boolean
             */
            public $Cancel = false;
        }
    }
?>
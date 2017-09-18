<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web\Forms\Rendering;
    use System\CancelEventArgs;
    {
        /**
         * Provides data for the `Paint` event.
         */
        class PaintEventArgs extends CancelEventArgs
        {
            /**
             * The item that will be drawn.
             *
             * @var IRenderable
             */
            private $item;

            /**
             * Initializes a new instance of the `PaintEventArgs` class with an item.
             *
             * @param IRenderable $item
             * The item that will be drawn.
             */
            public function PaintEventArgs(IRenderable $item)
            {
                $this->item = $item;
            }

            /**
             * @ignore
             */
            public function getItem() : IRenderable
            {
                return $this->item;
            }
        }
    }
?>
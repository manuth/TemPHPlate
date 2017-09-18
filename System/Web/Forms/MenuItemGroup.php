<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web\Forms;
    use System\Collections\{
        ArrayList
    };
    {
        /**
         * Represents a menu-item that contains a set of menu-items.
         * 
         * @property-read ArrayList $Items
         * Gets the items of the menu-item-group.
         */
        class MenuItemGroup extends MenuItem
        {
            /**
             * The items of the menu-item-group.
             *
             * @var ArrayList
             */
            private $items;

            /**
             * Initializes a new instance of the `MenuItemGroup` class.
             */
            public function MenuItemGroup()
            {
                $this->items = new ArrayList();
            }
            
            /**
             * @ignore
             */
            public function getItems() : ArrayList
            {
                return $this->items;
            }
        }
    }
?>
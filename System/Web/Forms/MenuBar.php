<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web\Forms;
    use System\Collections\ArrayList;
    {
        /**
         * Represents a menu-bar.
         */
        class MenuBar extends MenuItemGroup
        {
            /**
             * Initializes a new instance of the MenuBar-class.
             */
            public function MenuBar()
            {
            }
            
            /**
             * Gets or sets the style of the menu-bar.
             *
             * @var string
             */
            public $Style = 'default';

            /**
             * Loads the menu-bar from a json-object.
             *
             * @param \stdClass $jsonObject
             * The object to load the properties of the menu-bar from.$_COOKIE
             * 
             * @return MenuBar
             * The menu-bar.
             */
            public static function FromJSON(\stdClass $jsonObject) : self
            {
                $menuBar = new self();

                $loadItems = function ($items) use (&$loadItem) : ArrayList
                {
                    $result = new ArrayList();

                    foreach ($items as $item)
                    {
                        $result->Add($loadItem($item));
                    }

                    return $result;
                };
                
                $loadItem = function ($item) use ($loadItems) : MenuItem
                {
                    $menuItem;

                    switch ($item->type)
                    {
                        case 'menuItemGroup':
                            $menuItem = new MenuItemGroup();
                            $menuItem->Items->AddRange($loadItems($item->items));
                            break;
                        case 'menuItem':
                            $menuItem = new LinkedMenuItem();
                            $menuItem->URL = $item->url;
                            
                            if (property_exists($item, 'newTab'))
                            {
                                $menuItem->NewTab = $item->newTab;
                            }
                            break;
                        case 'menuItemSeparator':
                            $menuItem = new MenuItemSeparator();
                            $item->name = '';
                            break;
                        case 'menuItemText':
                            $menuItem = new MenuItem();
                            break;
                    }

                    $menuItem->Name = $item->id;
                    $menuItem->Text = $item->name;

                    return $menuItem;
                };

                $menuBar->Text = $jsonObject->text;
                $menuBar->Items->AddRange($loadItems($jsonObject->items));
                $menuBar->Style = $jsonObject->style;

                
                return $menuBar;
            }
        }
    }
?>
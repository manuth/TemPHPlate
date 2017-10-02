<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web\Forms;
    use System\Collections\ArrayList;
    use System\Environment;
    use System\IO\Path;
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
             * Gets or sets the URL of the menu-bar.
             *
             * @var string
             */
            public $URL;
            
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

                    switch ($item->Type)
                    {
                        case 'MenuItem':
                            $menuItem = new MenuItem();
                            break;
                        case 'LinkedMenuItem':
                            $menuItem = new LinkedMenuItem();

                            if (strpos($item->URL, '://') === false)
                            {
                                $menuItem->URL = Path::MakeRelativeWebPath($item->URL);
                            }
                            else
                            {
                                $menuItem->URL = $item->URL;
                            }
                            if (property_exists($item, 'NewTab'))
                            {
                                $menuItem->NewTab = $item->NewTab;
                            }
                            break;
                        case 'MenuItemGroup':
                            $menuItem = new MenuItemGroup();
                            $menuItem->Items->AddRange($loadItems($item->Items));
                            break;
                        case 'MenuItemSeparator':
                            $menuItem = new MenuItemSeparator();
                            $item->Text = '';
                            break;
                    }

                    $menuItem->Name = $item->Name;
                    $menuItem->Text = $item->Text;

                    if (property_exists($item, 'Enabled'))
                    {
                        $menuItem->Enabled = $item->Enabled;
                    }
                    
                    if (property_exists($item, 'Visible'))
                    {
                        $menuItem->Visible = $item->Visible;
                    }

                    return $menuItem;
                };

                $menuBar->Name = $jsonObject->Name;
                $menuBar->Text = $jsonObject->Text;

                if (property_exists($jsonObject, 'URL'))
                {
                    $menuBar->URL = $jsonObject->URL;
                }

                $menuBar->Style = $jsonObject->Style;
                $menuBar->Items->AddRange($loadItems($jsonObject->Items));

                return $menuBar;
            }
            
            /**
             * @ignore
             */
            public function __Initialize()
            {
                $this->URL = Path::MakeRelativeWebPath(Environment::$RequestDirectory, Environment::$DocumentRoot);
            }
        }
    }
?>
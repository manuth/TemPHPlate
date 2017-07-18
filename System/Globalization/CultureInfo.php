<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Globalization;
    use System\Object;
    {
        /**
         * Represents a culture.
         */
        class CultureInfo extends Object
        {
            /**
             * Gets or sets the name of the culture.
             * @var string
             */
            public $Name;

            /**
             * Initializes a new instance of the CultureInfo class with a name.
             * 
             * @param string $name
             * The name of the culture.
             */
            public function CultureInfo1(string $name)
            {
                $this->Name = $name;
            }

            /**
             * Sets the locale for the specified type.
             *
             * @param int $category
             * The category to assign the culture to.
             */
            public function SetLocale(int $category = LC_ALL)
            {
                if (!setlocale($category, $this->Name))
                {
                    throw new CultureNotFoundException($this->Name);
                }
            }

            /**
             * Returns a string which represents the object.
             *
             * @return string
             */
            public function ToString() : string
            {
                return $this->Name;
            }
        }
    }
?>
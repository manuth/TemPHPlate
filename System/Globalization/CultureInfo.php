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
            public function CultureInfo1(?string $name)
            {
                $this->Name = $name;
            }

            /**
             * The current culture of the php-website.
             * @var CultureInfo
             */
            public static function GetCurrentCulture() : self
            {
                return new self(locale_get_default());
            }

            /**
             * Sets the current culture.
             *
             * @param CultureInfo $cultureInfo
             * The category to assign the culture to.
             */
            public static function SetCurrentCulture(self $cultureInfo)
            {
                if (!setlocale(LC_ALL, $cultureInfo->Name))
                {
                    if (!setlocale(LC_ALL, preg_replace('/(\w*)-(\w*)/', '$1_$2.UTF8', $cultureInfo->Name)))
                    {
                        throw new CultureNotFoundException($cultureInfo->Name);
                    }
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
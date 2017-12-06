<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web\Forms;
    use System\Object;
    use System\Web\Forms\Rendering\IRenderable;
    {
        /**
         * Defines the base class for controls, which are components with visual representation.
         */
        abstract class Control extends Object implements IRenderable
        {
            /**
             * Initializes a new instance of the control-class.
             */
            public function Control()
            {
            }
            
            /**
             * Gets or sets the identifier of the control.
             *
             * @var string
             */
            public $Name;
            
            /**
             * Gets or sets the Text of the control.
             *
             * @var string
             */
            public $Text;

            /**
             * Gets or sets a value indicating whether the control can respond to user interaction.
             *
             * @var boolean
             */
            public $Enabled = true;

            /**
             * Gets or sets a value indicating whether the control and all its child controls are displayed.
             *
             * @var boolean
             */
            public $Visible = true;
        }
    }
?>
<?php

    namespace App\Traits;

    /**
     * Trait to manage the display of a menu's content.
     */
    trait HasMenu
    {
        /**
         * @var bool Controls whether the menu content is visible.
         */
        public $showMenuContent = false;

        /**
         * Open the menu and display its contents.
         *
         * @return void
         */
        public function openMenuContent(): void
        {
            $this->showMenuContent = true;
        }
    }

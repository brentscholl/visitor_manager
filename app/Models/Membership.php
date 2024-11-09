<?php

    namespace App\Models;

    use Laravel\Jetstream\Membership as JetstreamMembership;

    /**
     * Model representing a membership within a team, extending Jetstream's base Membership model.
     */
    class Membership extends JetstreamMembership
    {
        /**
         * Indicates if the IDs are auto-incrementing.
         *
         * @var bool
         */
        public $incrementing = true;
    }

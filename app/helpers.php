<?php

    if (!function_exists('flash')) {

        /**
         * Create or retrieve a flash message notifier instance.
         *
         * This function allows you to create a new flash message with a specified level
         * or retrieve the existing flash notifier instance.
         *
         * @param string|null $message The message content to be flashed, or null to return the notifier instance.
         * @param string $level The level of the flash message (default is 'info'). Possible values include:
         *                      'info', 'success', 'warning', 'error'.
         * @return \App\Notifications\FlashMessages\LivewireFlashNotifier The flash notifier instance,
         *         or the result of the message creation if a message is provided.
         */
        function flash($message = null, $level = 'info')
        {
            // Retrieve the flash notifier instance from the application container
            $notifier = app('lwflash');

            // If a message is provided, create a new flash message with the specified level
            if (!is_null($message)) {
                return $notifier->message($message, $level);
            }

            // Return the notifier instance when no message is provided
            return $notifier;
        }
    }

    if (!function_exists('generateLocationCode')) {

        /**
         * Generate a unique location code.
         *
         * This function creates a location code consisting of two random uppercase letters
         * followed by a dash and a three-digit random number.
         *
         * @return string The generated location code in the format 'XXX-999', where
         *         'XXX' are random letters and '999' is a random number between 100 and 999.
         */
        function generateLocationCode()
        {
            // Generate a random three-digit number between 100 and 999
            $codeNumbers = rand(100, 999);

            // Shuffle the uppercase letters and take the first three
            $codeLetters = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 3);

            // Return the formatted location code
            return $codeLetters . '-' . $codeNumbers;
        }
    }

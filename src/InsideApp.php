<?php

namespace AninuApps\InsideApp;

/**
 * Simple InsideApp SDK
 */
class InsideApp
{
    /**
     * Dummy print function that echoes "test"
     *
     * @return void
     */
    public function dummyPrint(): void
    {
        echo "test";
    }

    /**
     * Get SDK version
     *
     * @return string
     */
    public function getVersion(): string
    {
        return "1.0.0";
    }

    /**
     * Print a custom message
     *
     * @param string $message
     * @return void
     */
    public function printMessage(string $message): void
    {
        echo $message;
    }
}
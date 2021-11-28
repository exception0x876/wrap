<?php

/*
 * The task is to write a function called 'wrap' that takes two arguments, $string and $length.
 * The function should return the string, but with new lines ("\n") added to ensure that no line is longer than $length
 * characters.
 * Always wrap at word boundaries if possible, only break a word if it is longer than $length characters.
 * When breaking at word boundaries, replace all the whitespace between the two words with a single newline character.
 * Any unbroken whitespace should be left unchanged.
 */

namespace Wrap;

use Exception;

if (!function_exists('wrap')) {
    /**
     * @param string $string The string to wrap.
     * @param int $length Maximum line length.
     * @return string
     * @throws Exception
     */
    function wrap(string $string, int $length = 120): string
    {
        // We could put $encoding into the parameters but the task requirements are two parameters only
        $encoding = 'UTF-8';
        if ($length < 1) {
            throw new Exception('Length must be greater than 0');
        }
        // We should keep existing linebreaks so lets split the string by Windows linebreaks first
        $originalLines = \explode("\r\n", $string);
        // Split these lines by Unix linebreaks
        $finalOriginalLines = [];
        foreach ($originalLines as $originalLine) {
            $finalOriginalLines = \array_merge($finalOriginalLines, \explode("\n", $originalLine));
        }
        $lines = [];
        foreach ($finalOriginalLines as $key => $originalLine) {
            // Assuming we do not want any whitespace in the end of the line unless it is the last line
            if ($key !== array_key_last($finalOriginalLines)) {
                $originalLine = rtrim($originalLine);
            }
            while (\mb_strlen($originalLine, $encoding) > $length) {
                // Find the last space in the line
                $lastSpace = \mb_strrpos($originalLine, ' ', $length - \mb_strlen($originalLine, $encoding), $encoding);
                $lastSpace = ($lastSpace === false) ? $length : $lastSpace;
                $newLine = \mb_substr($originalLine, 0, $lastSpace, $encoding);
                $lines[] = rtrim($newLine);
                // Remove the matched line from the original line
                $originalLine = \mb_substr($originalLine, $lastSpace, mb_strlen($originalLine), $encoding);
                // Remove extra whitespace
                $originalLine = \ltrim($originalLine);
            }
            $lines[] = $originalLine;
        }
        return \implode("\n", $lines);
    }
}

<?php

/*
   ------------------------------------------------------------------------
   Barcode
   Copyright (C) 2009-2016 by the Barcode plugin Development Team.

   https://forge.indepnet.net/projects/barscode
   ------------------------------------------------------------------------

   LICENSE

   This file is part of barcode plugin project.

   Plugin Barcode is free software: you can redistribute it and/or modify
   it under the terms of the GNU Affero General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   Plugin Barcode is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
   GNU Affero General Public License for more details.

   You should have received a copy of the GNU Affero General Public License
   along with Plugin Barcode. If not, see <http://www.gnu.org/licenses/>.

   ------------------------------------------------------------------------

   @package   Plugin Barcode
   @author    David Durieux
   @co-author
   @copyright Copyright (c) 2009-2016 Barcode plugin Development team
   @license   AGPL License 3.0 or (at your option) any later version
              http://www.gnu.org/licenses/agpl-3.0-standalone.html
   @link      https://forge.indepnet.net/projects/barscode
   @since     2009

   ------------------------------------------------------------------------
 */

if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access directly to this file");
}

/**
 * Helper class for PDF font management with Chinese character support
 **/
class PluginBarcodePdfHelper {

   /**
    * Check if text contains Chinese characters
    * 
    * @param string $text Text to check
    * @return bool True if contains Chinese characters
    */
   public static function containsChinese($text) {
      if (empty($text) || !is_string($text)) {
         return false;
      }
      return preg_match('/[\x{4e00}-\x{9fa5}]/u', $text) === 1;
   }

   /**
    * Ensure text is properly UTF-8 encoded
    * 
    * @param string $text Text to encode
    * @return string UTF-8 encoded text
    */
   public static function ensureUtf8($text) {
      if (empty($text)) {
         return '';
      }
      
      // Convert to string if not already
      $text = (string)$text;
      
      // Check if already valid UTF-8
      if (mb_check_encoding($text, 'UTF-8')) {
         return $text;
      }
      
      // Try to convert from common encodings
      $encodings = ['GBK', 'GB2312', 'ISO-8859-1', 'Windows-1252'];
      foreach ($encodings as $encoding) {
         $converted = @mb_convert_encoding($text, 'UTF-8', $encoding);
         if ($converted !== false && mb_check_encoding($converted, 'UTF-8')) {
            return $converted;
         }
      }
      
      // Last resort: use iconv with error suppression
      $detected = mb_detect_encoding($text, mb_detect_order(), true);
      if ($detected !== false) {
         $converted = @iconv($detected, 'UTF-8//IGNORE', $text);
         if ($converted !== false) {
            return $converted;
         }
      }
      
      // Final fallback: remove non-UTF-8 characters
      return mb_convert_encoding($text, 'UTF-8', 'UTF-8');
   }

   /**
    * Convert text to format suitable for PDF rendering
    * For Chinese text, this may need special handling
    * 
    * @param string $text Text to prepare
    * @return string Prepared text
    */
   public static function preparePdfText($text) {
      // Ensure we have a string
      if ($text === null || $text === false) {
         return '';
      }
      
      $text = self::ensureUtf8($text);
      
      // For PDF libraries that don't support Unicode well,
      // we might need to use HTML entities or other workarounds
      // But modern rospdf/pdf-php should handle UTF-8
      
      return $text;
   }

   /**
    * Get recommended font size for text based on content
    * 
    * @param string $text Text to analyze
    * @param int $defaultSize Default font size
    * @return int Recommended font size
    */
   public static function getRecommendedFontSize($text, $defaultSize = 8) {
      // Chinese characters may need slightly different sizing
      if (self::containsChinese($text)) {
         // Keep same size but ensure it's readable
         return max($defaultSize, 8);
      }
      return $defaultSize;
   }

   /**
    * Add UTF-8 support notice to PDF configuration
    * 
    * @return string Information message
    */
   public static function getUtf8SupportInfo() {
      return __('The plugin supports UTF-8 encoding including Chinese characters. ' .
                'For best results with Chinese text, ensure your system has appropriate fonts installed.', 
                'barcode');
   }

   /**
    * Validate if PDF library supports Unicode
    * 
    * @return array Status information
    */
   public static function checkUnicodeSupport() {
      $info = [
         'mbstring' => extension_loaded('mbstring'),
         'iconv' => extension_loaded('iconv'),
         'utf8' => true,
         'message' => ''
      ];

      if (!$info['mbstring']) {
         $info['message'] .= 'Warning: mbstring extension not loaded. Chinese character support may be limited. ';
      }
      if (!$info['iconv']) {
         $info['message'] .= 'Warning: iconv extension not loaded. Character encoding conversion may fail. ';
      }

      $info['supported'] = $info['mbstring'] && $info['iconv'];
      
      if ($info['supported']) {
         $info['message'] = 'Unicode and Chinese character support is available.';
      }

      return $info;
   }
}

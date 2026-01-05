<?php
/**
 * UTF-8 and Chinese Character Support Test Script
 * 
 * This script tests the Chinese character support in the Barcode plugin
 * Run from GLPI root directory: php plugins/barcode/test_chinese_support.php
 */

// Simulate GLPI environment
define('GLPI_ROOT', dirname(dirname(dirname(__FILE__))));

echo "=== Barcode Plugin - Chinese Character Support Test ===\n\n";

// Test 1: Check PHP extensions
echo "Test 1: PHP Extensions\n";
echo "----------------------\n";
$mbstring = extension_loaded('mbstring');
$iconv = extension_loaded('iconv');
echo "mbstring: " . ($mbstring ? "✓ Loaded" : "✗ Not loaded") . "\n";
echo "iconv: " . ($iconv ? "✓ Loaded" : "✗ Not loaded") . "\n";
echo "\n";

// Test 2: UTF-8 encoding tests
echo "Test 2: UTF-8 Encoding\n";
echo "----------------------\n";
$test_strings = [
    '测试中文' => 'Chinese characters',
    'Test123' => 'English and numbers',
    '设备编号：001' => 'Mixed Chinese and numbers',
    'αβγδ' => 'Greek characters',
    '日本語テスト' => 'Japanese characters',
];

foreach ($test_strings as $text => $description) {
    $is_utf8 = mb_check_encoding($text, 'UTF-8');
    $length = mb_strlen($text, 'UTF-8');
    echo "$description: ";
    echo ($is_utf8 ? "✓" : "✗") . " UTF-8 valid, ";
    echo "Length: $length chars\n";
}
echo "\n";

// Test 3: Character detection
echo "Test 3: Character Detection\n";
echo "---------------------------\n";
$chinese_patterns = [
    '测试' => true,
    'Test' => false,
    '中English文' => true,
    '123456' => false,
];

foreach ($chinese_patterns as $text => $expected) {
    $has_chinese = preg_match('/[\x{4e00}-\x{9fa5}]/u', $text) === 1;
    $result = ($has_chinese === $expected) ? "✓" : "✗";
    echo "$result Text '$text': " . ($has_chinese ? "Contains" : "No") . " Chinese\n";
}
echo "\n";

// Test 4: Encoding conversion
echo "Test 4: Encoding Conversion\n";
echo "----------------------------\n";
$test_text = '测试文本';
$encodings_to_test = ['UTF-8', 'GBK', 'GB2312'];

foreach ($encodings_to_test as $encoding) {
    if ($encoding === 'UTF-8') {
        $converted = $test_text;
    } else {
        $converted = @mb_convert_encoding($test_text, $encoding, 'UTF-8');
        if ($converted) {
            $back = @mb_convert_encoding($converted, 'UTF-8', $encoding);
            echo "$encoding: ";
            echo ($back === $test_text ? "✓ Round-trip OK" : "✗ Round-trip failed") . "\n";
        } else {
            echo "$encoding: ✗ Conversion failed\n";
        }
    }
}
echo "\n";

// Test 5: Summary
echo "Test 5: Plugin Readiness\n";
echo "------------------------\n";
$ready = $mbstring && $iconv;
echo "Status: " . ($ready ? "✓ READY" : "✗ NOT READY") . "\n";
if (!$ready) {
    echo "\nTo enable Chinese support:\n";
    if (!$mbstring) echo "- Install PHP mbstring extension\n";
    if (!$iconv) echo "- Install PHP iconv extension\n";
} else {
    echo "\nRecommendations:\n";
    echo "- Use QR codes for best Chinese character support\n";
    echo "- Ensure GLPI database is configured as UTF-8\n";
    echo "- For barcode labels, consider using romanized text\n";
}
echo "\n";

// Test 6: File system encoding
echo "Test 6: File System\n";
echo "-------------------\n";
$test_filename = '测试文件.txt';
$temp_file = sys_get_temp_dir() . '/' . $test_filename;
$write_ok = @file_put_contents($temp_file, '测试内容');
$read_ok = false;
if ($write_ok) {
    $content = @file_get_contents($temp_file);
    $read_ok = ($content === '测试内容');
    @unlink($temp_file);
}
echo "Chinese filename support: " . (($write_ok && $read_ok) ? "✓ OK" : "✗ Limited") . "\n";
echo "\n";

echo "=== Test Complete ===\n";
echo "\nFor more information, see: plugins/barcode/CHINESE_SUPPORT.md\n";

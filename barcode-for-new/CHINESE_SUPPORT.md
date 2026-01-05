# Chinese Character Support in PDF Generation

## 中文PDF支持指南

### 问题说明

默认的PDF库使用Helvetica字体，不支持中文字符显示。本插件已添加UTF-8编码处理来改善中文支持。

### 解决方案

#### 1. 自动UTF-8编码处理（已实现）

插件现在会自动：
- 检测文本编码并转换为UTF-8
- 识别中文字符
- 确保正确的字符编码传递给PDF生成器

#### 2. 使用支持Unicode的PDF库（推荐）

**当前使用的库：** `rospdf/pdf-php` (Cezpdf)

**替代方案：**
如果遇到严重的中文显示问题，可以考虑升级到支持Unicode的PDF库：

##### 选项A: 使用TCPDF（推荐）
```bash
composer require tecnickcom/tcpdf
```

优点：
- 完整的UTF-8和Unicode支持
- 内置多种字体包括中文字体
- 广泛使用且维护良好

##### 选项B: 使用mPDF
```bash
composer require mpdf/mpdf
```

优点：
- 优秀的中文支持
- 支持复杂的UTF-8文本
- 较好的性能

#### 3. 系统字体配置

确保系统安装了中文字体：

**Linux:**
```bash
sudo apt-get install fonts-wqy-zenhei fonts-wqy-microhei
# 或
sudo yum install wqy-zenhei-fonts wqy-microhei-fonts
```

**macOS:**
- 系统自带中文字体支持

**Windows:**
- 系统自带中文字体支持

### 当前实现的功能

1. **自动编码检测和转换**
   - 支持GBK、GB2312、ISO-8859-1等编码
   - 自动转换为UTF-8

2. **中文字符识别**
   - 检测文本中是否包含中文字符
   - 根据内容调整字体大小

3. **编码验证**
   - 确保所有文本都是有效的UTF-8编码
   - 提供回退机制

### 使用建议

#### 对于简单的中文标签：
- 当前实现应该可以正常工作
- 确保输入的文本是UTF-8编码

#### 对于复杂的中文内容：
- 考虑升级到TCPDF或mPDF
- 使用二维码（QRcode）而非条形码承载中文信息

### 测试中文支持

1. 在GLPI中创建资产时使用中文名称
2. 在库存编号字段输入中文
3. 生成条形码或二维码
4. 检查PDF中的中文显示

### 已知限制

1. **Cezpdf库限制：**
   - 原生不支持Unicode字体
   - 中文字符可能显示为方框或乱码
   - 仅支持标准拉丁字符集

2. **解决方法：**
   - 使用QRcode代替barcode（QR码本身是图片，不受字体限制）
   - 升级到支持Unicode的PDF库
   - 使用英文或数字作为显示标签

### 配置检查

运行以下PHP代码检查系统支持：
```php
<?php
// 检查mbstring扩展
var_dump(extension_loaded('mbstring'));

// 检查iconv扩展
var_dump(extension_loaded('iconv'));

// 检查UTF-8编码
$test = "测试中文";
var_dump(mb_check_encoding($test, 'UTF-8'));
?>
```

### 升级到TCPDF示例

如果需要完整的中文支持，可以参考以下代码修改 `barcode.class.php`：

```php
// 替换 Cezpdf 为 TCPDF
use TCPDF;

// 在 printPDF 方法中：
$pdf = new TCPDF($orientation, 'mm', $size, true, 'UTF-8', false);
$pdf->SetFont('dejavusans', '', 10); // DejaVu Sans 支持中文
$pdf->AddPage();

// 添加文本（完整中文支持）
$pdf->Cell(0, 10, '中文测试', 0, 1, 'C');
```

### 技术支持

如遇中文显示问题：
1. 检查PHP mbstring和iconv扩展是否安装
2. 验证数据库字段编码为UTF-8
3. 确认GLPI系统配置为UTF-8
4. 考虑使用QRcode替代标准barcode
5. 如需完整支持，升级到TCPDF

### 相关文件

- `inc/pdfhelper.class.php` - PDF辅助类，处理UTF-8编码
- `inc/barcode.class.php` - 条形码生成，已添加UTF-8支持
- `inc/qrcode.class.php` - 二维码生成（推荐用于中文）

### 更新日志

**2.8.0 (2026-01-05):**
- 添加UTF-8编码自动检测和转换
- 创建PdfHelper辅助类
- 改进中文字符处理
- 添加编码验证机制

---

## English Version

### Issue
The default PDF library uses Helvetica font which doesn't support Chinese characters.

### Solutions

1. **Automatic UTF-8 Encoding** (Implemented)
   - Auto-detect and convert character encoding
   - Validate UTF-8 encoding
   - Handle Chinese characters properly

2. **Use QR Codes** (Recommended for Chinese)
   - QR codes are images, not affected by font limitations
   - Can contain any UTF-8 text including Chinese

3. **Upgrade to TCPDF** (For full Unicode support)
   - Install: `composer require tecnickcom/tcpdf`
   - Complete Unicode and Chinese font support

### Testing
Create assets with Chinese names and generate barcodes/QR codes to verify display.

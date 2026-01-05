# Quick Reference - Barcode Plugin 2.8.0 for GLPI 11

## Installation

```bash
# 1. Extract plugin to GLPI plugins directory
cd /path/to/glpi/plugins/barcode

# 2. Install dependencies
composer install --no-dev

# 3. Enable in GLPI
# Go to: Setup > Plugins > Barcode > Install > Activate
```

## System Requirements

| Component | Version |
|-----------|---------|
| GLPI | 10.0.x - 11.0.x |
| PHP | ≥ 8.1 |
| MySQL/MariaDB | As per GLPI requirements |

## Key Changes from 2.7.1

✅ **GLPI 11 Support** - Full compatibility with GLPI 11.0.x  
✅ **PHP 8.1+** - Updated for modern PHP requirements  
✅ **Database Updates** - Modern GLPI database API  
✅ **Error Handling** - Improved error management  
✅ **Backward Compatible** - Still works with GLPI 10.0.x  

## Features

- **Barcode Generation**: Generate barcodes (Code39, Code128, EAN13, etc.)
- **QRCode Generation**: Create QR codes with customizable data
- **Massive Actions**: Process multiple items at once
- **PDF Export**: Generate printable PDF documents
- **Customizable**: Configure size, orientation, margins
- **Multi-type Support**: Works with Computers, Monitors, and other assets

## Usage

1. **Navigate to Asset List** (e.g., Assets > Computers)
2. **Select Items** using checkboxes
3. **Choose Massive Action**:
   - "Barcode - Print barcodes" for standard barcodes
   - "Barcode - Print QRcodes" for QR codes
4. **Configure Options**:
   - Page size (A4, Letter, etc.)
   - Orientation (Portrait/Landscape)
   - Display options
5. **Generate & Download** PDF

## Configuration

Access via: **Setup > Plugins > Barcode > Configuration**

### Global Settings
- Default barcode type
- Cache management
- Company logo upload

### Type-Specific Settings
Configure for each barcode type:
- Page layout
- Margins
- Maximum dimensions
- Text display options

## File Structure

```
barcode/
├── setup.php              # Plugin initialization
├── hook.php               # Installation/hooks
├── barcode.xml            # Plugin metadata
├── composer.json          # Dependencies
├── inc/                   # Core classes
│   ├── barcode.class.php
│   ├── qrcode.class.php
│   ├── config.class.php
│   └── profile.class.php
├── front/                 # User interface
└── locales/               # Translations
```

## Troubleshooting

### Plugin won't activate
- Check PHP version: `php -v` (must be ≥ 8.1)
- Run: `composer install --no-dev`
- Check GLPI logs: `files/_log/`

### Barcodes not generating
- Verify permissions on `files/_plugins/barcode/`
- Check that inventory numbers exist for items
- Review configuration settings

### PDF download fails
- Check web server permissions
- Verify `GLPI_PLUGIN_DOC_DIR` is writable
- Check PHP memory_limit

## Database Tables

Created by plugin:
- `glpi_plugin_barcode_configs` - Global configuration
- `glpi_plugin_barcode_configs_types` - Type-specific settings

## Permissions

Required rights:
- `plugin_barcode_config` - Manage configuration
- `plugin_barcode_barcode` - Generate barcodes

Configure via: **Administration > Profiles**

## Support

- **GitHub**: https://github.com/pluginsGLPI/barcode
- **Documentation**: See README.md and UPGRADE.md
- **Issues**: GitHub Issues section

## Quick Commands

```bash
# Check PHP version
php -v

# Install dependencies
composer install --no-dev

# Update dependencies
composer update --no-dev

# Check GLPI version
grep GLPI_VERSION /path/to/glpi/version/version.php

# Check plugin version
grep PLUGIN_BARCODE_VERSION plugins/barcode/setup.php
```

## Version History

- **2.8.0** (2026-01-05): GLPI 11 support, PHP 8.1+
- **2.7.1**: GLPI 10 support
- **2.6.x**: GLPI 9.5 support

---

For detailed information, see:
- [CHANGELOG.md](CHANGELOG.md) - Version history
- [UPGRADE.md](UPGRADE.md) - Upgrade instructions
- [GLPI11_COMPATIBILITY.md](GLPI11_COMPATIBILITY.md) - Technical details

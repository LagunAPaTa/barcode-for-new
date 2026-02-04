# Upgrade Guide - Barcode Plugin 2.8.0

## Upgrading to GLPI 11

This version (2.8.0) adds support for GLPI 11 while maintaining compatibility with GLPI 10.

### Requirements

- **GLPI**: 10.0.0 to 11.0.99
- **PHP**: 8.1 or higher (required for GLPI 11)
- **Composer**: For dependency management

### Installation Steps

#### For New Installation

1. Download the plugin archive or clone the repository
2. Extract to `glpi/plugins/barcode/`
3. Install dependencies:
   ```bash
   cd glpi/plugins/barcode
   composer install --no-dev
   ```
4. In GLPI interface, go to Setup > Plugins
5. Install and activate the Barcode plugin

#### For Upgrade from 2.7.x

1. Backup your GLPI database
2. Disable the old Barcode plugin in GLPI
3. Replace the plugin files in `glpi/plugins/barcode/`
4. Run composer to update dependencies:
   ```bash
   cd glpi/plugins/barcode
   composer install --no-dev
   ```
5. Enable the plugin in GLPI interface

### What's Changed

#### Database Improvements
- Updated database operations to use GLPI 11 compatible methods
- Fixed primary key field naming consistency (ID → id)
- Improved error handling with `queryOrDie()` method

#### PHP Version
- Minimum PHP version updated to 8.1
- Full compatibility with PHP 8.1+ features

#### API Updates
- All database queries updated to use modern GLPI methods
- Maintained backward compatibility with GLPI 10.0.x

### Troubleshooting

#### Plugin won't install
- Verify PHP version is 8.1 or higher
- Check that composer dependencies are installed
- Review GLPI error logs for specific issues

#### Database errors
- If upgrading, ensure you disabled the old version before replacing files
- Check database credentials and permissions
- Run GLPI database update if needed

#### Generated files not accessible
- Verify `files/_plugins/barcode/` directory exists and is writable
- Check web server permissions on the directory

### Support

For issues, please report on:
- GitHub: https://github.com/pluginsGLPI/barcode/issues

### Compatibility Matrix

| Plugin Version | GLPI Version | PHP Version |
|---------------|--------------|-------------|
| 2.8.0         | 10.0.x - 11.0.x | >= 8.1    |
| 2.7.1         | 10.0.x       | >= 7.4      |

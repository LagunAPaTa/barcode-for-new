# Changelog

## [2.8.0] - 2026-01-05

### Added
- Support for GLPI 11.0.x
- Compatibility with PHP 8.1+
- **UTF-8 and Chinese character support in PDF generation**
- New `PluginBarcodePdfHelper` class for encoding handling
- Unicode support status check in configuration page
- Automatic character encoding detection and conversion

### Changed
- Updated minimum PHP version requirement from 7.4 to 8.1
- Updated maximum GLPI version support from 10.0.99 to 11.0.99
- Replaced deprecated `$DB->query()` with `$DB->queryOrDie()` for better error handling
- Fixed database table primary key field name from `ID` to `id` for consistency
- **Improved PDF text rendering with UTF-8 encoding validation**

### Fixed
- Database operation compatibility issues with GLPI 11
- Removed deprecated error handling methods that were incompatible with GLPI 11
- **Chinese character encoding issues in PDF generation**
- Text encoding problems with special characters

### Documentation
- Added `CHINESE_SUPPORT.md` with detailed guide for Chinese character support
- Added Chinese translations for new features
- Updated README with compatibility information

## [2.7.1] - Previous Release
- Support for GLPI 10.0.x
- Various bug fixes and improvements

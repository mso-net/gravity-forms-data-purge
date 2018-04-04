gravity-forms-data-purge

A WordPress plugin to purge Gravity Forms Entries that are old that a set number of day to help with GDPR compliance.

The plugin is very simple. It adds a setting to the Gravity Forms menu in the WP Admin called “Purge Data” and under this option you set the number of days you would like to retain Gravity Forms entries for, for all forms on your site. 

The default is to keep all entries forever, empty field, and a valid value is any number of days from 0 (zero) to X. Once an entry is that number of days old, it is removed. 

The cron task to delete the entries runs once per hour, so when set to 0, the maximum time an entry will be stored for is one hour. 

PLEASE NOTE: Entries are permanently deleted, so use with care.
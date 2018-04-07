=== Gravity Forms Data Purge ===
Contributors: aandrewdixon
Tags: gravity forms, gdpr, data protection,
Tested up to: 4.9.5
Stable tag: trunk

Simple plugin to purge data from Gravity Forms Entries that are older that a certain number of days.

== Description ==
The plugin is very simple. It adds a setting to the Gravity Forms menu in the WP Admin called “Purge Data” and under this option you set the number of days you would like to retain Gravity Forms entries for, for all forms on your site.

The default is to keep all entries forever, empty field, and a valid value is any number of days from 0 (zero) to X. Once an entry is that number of days old, it is removed.

The cron task to delete the entries runs once per hour, so when set to 0, the maximum time an entry will be stored for is one hour.

PLEASE NOTE: Entries are permanently deleted, so use with care.
=== Disable Comments By Referer ===
Contributors: codebykat
Tags: comments, spam
Requires at least: 3.7
Tested up to: 3.8
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Ban visitors from certain sites from viewing or adding comments.

== Description ==

This plugin allows you to selectively disable comments for visitors from certain sites (e.g. reddit).  If a visitors HTTP referer matches one of the hosts you've blacklisted, your post will look as if comments have been disabled (neither existing comments nor the new comment form will be shown).

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Edit the list of hostnames you wish to block under Settings->Discussion.

== Frequently Asked Questions ==

= What happens if a site visitor clicks through to a second page? =

They will then be able to see and leave comments.  This plugin makes no attempt to track visitors or remember referer information.

= Do you know you misspelled "referer"? =

Yes.  Blame the HTTP specification.

== Changelog ==

= 0.1 =
* Initial version.
=== Brozzme DB Prefix & Tools Addons ===
Contributors: Benoti, benoitgeek
Tags: database, prefix, security, config, tools, dump, export, protection, db-prefix, _wp
Donate link: https://brozzme.com/
Requires at least: 4.7
Tested up to: 5.9
Stable tag: 1.3.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily change your WordPress DB prefix, save time, increase security.

== Description ==
Brozzme DB Prefix is a one click tool to modify your database prefix everywhere (database and wp-config.php).

To apply a new prefix, you just need to verify that the wp-config.php is writable and that the Alter rights of the database are enable.

A single entry is need : the new database prefix. The plugin will generate a new one for you. You only have to press the button if you are ok with the generated prefix. Of course, the prefix can be modify to fit your needs.

This plugin doesn't have any options settings.

Since 1.3 : New tools will be add !

- mysql dump : export whole database in a single click or more click if you need options ;)

Have a look to the other Brozzme plugins [search : Brozzme](https://wordpress.org/plugins/search/brozzme/)

Link to [Brozzme](https://brozzme.com/ "Brozzme") and [WPServeur](https://www.wpserveur.net/?refwps=221 "WPServeur WordPress Hosting").


== Installation ==
1. Upload "Brozzme DB Prefix" to the "/wp-content/plugins/" directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Go to Tools menu and choose DB Prefix

== Frequently Asked Questions ==
= A question that someone might have =
An answer to that question.
= Why do I need to change the WordPress database prefix ? =
WordPress Database is like the heart for your WordPress site, as the database runs for every single information store, you need to protect it against hackers and spammers that could run automated code for SQL injections.
Many people forget to change the database prefix in the install wizard.
This makes it easier for hackers to plan a mass attack by targeting the default prefix wp_.
To avoid them, you can protect your database by changing the database prefix which is really easy with Brozzme DB Prefix.
It takes a few seconds to change the prefix.

= What do I need to verify before changes ? =
**MAKE SURE YOU HAVE A DATABASE BACKUP BEFORE USING THIS TOOL.**

You just need to verify:

        - wp-config.php is writable on your server.
        - that mySQL ALTER rights are enable.

= What can I do if the process fails ? =

Depending on where the fail occurs:

        Compare prefix in the wp-config.php and in phpmyAdmin, depending on the the situation,
        - change manually $table_prefix value in wp-config.php.
        - suppress all tables and import the backup in phpmyAdmin.
        Verify all the pre-requisite point in the previous question before processing once again.

= Why can I not do it manually? =
    Of course you can, but there's many occurences to modify to make it works. Not only the tables name need to be modify.

        Here is the exhaustive list of what to change,
        - Tables names,
        - table options: {old_prefix}user_roles option name,
        table usermeta, for each registered user, {old_prefix}capabilities and {old_prefix}user_level, option names
        if exists you'll need to also modify {old_prefix}dashboard_quick_press_last_post_id option name

= I can't delete, edit anymore using phpmyAdmin with MAMP... =
Only use lower-case characters to solve this.


== Screenshots ==
1. english tool control screenshot-1.png.
2. french tool control screenshot-2.png.

== Changelog ==
= 1.3.2 =
bugfixes
= 1.3.1 =
bugfixes for notices
= 1.3 =
* Add mysql dump tab
= 1.2.2 =
* PHP8.0 compatibility
= 1.2 =
* get right path to wp-config -thx @victorfreitas
= 1.1 =
* bugfixes with languages txt domain
= 1.0 =
* Initial release.
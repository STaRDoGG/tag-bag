# Tag Bag #

**Tags:** tag, posts, tags, admin, administration, tagging, navigation, terms, taxonomy
**Requires at least:** 3.0
**Tested up to:** 4.0
**Stable tag:** 2.3.3

**Add some tools for taxonomies:** Terms suggestion, Mass Edit Terms, Auto link Terms, Ajax Autocompletion, Click Terms, Auto terms, Advanced manage terms, Advanced Post Terms, Related Posts by Terms, etc.

## BEFORE UNINSTALLING SIMPLE TAGS MAKE A BACKUP OF YOUR DATABASE! ##
I'm not responsible for any losses, it's all on you.

Tag Bag is a fork of the Simple Tags Plugin by Amaury Balmer (http://wordpress.org/plugins/simple-tags).

It is mostly intended to build upon the original plugin for my personal websites' own needs, and will be updated/fixed as necessary. Considering it is free software, and I have a very small amount of time to focus on this plugin alone (in fact it's NOT a focus of mine =) ), updates will probably be sporadic, and anyone with the ability, and knowledge of any fixes and/or enhancements is highly encouraged to either tell me exactly what to add/fix, or do it yourself and I'll merge it into this. Demanding people will be ignored, lol.

Also note: none to the documentation has been updated yet, as well as not listing any of the newe changes or updates, and may take time to get to. Feel free to update it yourself.

Changing from Simple Tags to Tag Bag:

I have done my best to make sure that you can simply disable Simple Tags, and install/activate Tag Bag and all of your original stuff will still be the same as before. Except(!) places where you may have used the shortcode to include the tag cloud will need to be changed from "st_" to "tb_".

I also haven't fixed any of the reported bugs since Amaury's last release. I've only made changes to the things pertinent to my own site(s). If you know the fix to any of the reported bugs/issues, you're encouraged to fill me in so I can add it.

However, if you've had a problem with a conflict between the ShareThis plugin and Simple Tags plugin, there's a strong chance Tag Bag fixed it.

## Original (un-updated) Description ##

**This is THE perfect tool to manage perfectly your WP terms for any taxonomy**

**It was written with this philosophy :** best performances, more secured and brings a lot of new functions

This plugin is developped on WordPress 3.3, with the constant WP_DEBUG to TRUE.

* Administration
	* Tags suggestion from Yahoo! Term Extraction API, OpenCalais, Alchemy, Zemanta, Tag The Net, Local DB with AJAX request
		* Compatible with TinyMCE, FCKeditor, WYMeditor and QuickTags
	* tags management (rename, delete, merge, search and add tags, edit tags ID)
	* **Edit mass tags (more than 50 posts once)**
	* Auto link tags in post content
	* Auto tags !
	* Type-ahead input tags / Autocompletion Ajax
	* Click tags
	* Possibility to tag pages (not only posts) and include them inside the tags results
	* **Easy configuration ! (in WP admin)**

* Public
	* Technorati, Flickr and Delicious tags
	* Dynamic Tag Clouds with colors with Widgets (random order, etc)

And more...

## Installation ##

**Required PHP5**

The Simple Tags can be installed in 3 easy steps:

Best bet if you're already using Simple Tags is to:

* Deactivate (but not uninstall) the Simple Tags plugin.
* Install the Tag Bag Plugin & activate it.
	* Keep it that way until you're sure there are no issues, etc., and if you're happy after awhile just manually delete the Simple Tags folder from your server, this way you won't accidentally uninstall any database stuff that Tag Bag is still using.

* If you're a first time user, just install as you would any WordPress plugin ...

1. Unzip "Simple tags" archive and put all files into a folder like "/wp-content/plugins/simple-tags/"
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Inside the Wordpress admin, go to Options > Simple Tags, adjust the parameters according to your needs, and save them.

## Frequently Asked Questions ##

### Simple Tags is compatible with which WordPress versions ? ###

* 2.3 and upper are compatible only with WordPress 3.5 !
* 2.0 and upper are compatible only with WordPress 3.0 & 3.1 & 3.2 & 3.3 !
* 1.7 and upper are compatible only with WordPress 2.8, 2.9 !
* 1.6.7 and before are compatible with WordPress 2.3, 2.5, 2.6, 2.7
* Before WP 2.3, you must use the plugin Simple Tagging.

## Screenshots ##

###1. A example tag cloud (with dynamic color and size)###
![A example tag cloud (with dynamic color and size)](http://s.wordpress.org/extend/plugins/simple-tags/screenshot-1.png)

**2. Do you have a not yet tagged blog? Edit mass tags options is perfect for you :** tag 20, 30 or 50 articles with autocompletion in one step!
###2. Autotagging your content !###
![Autotagging your content !](http://s.wordpress.org/extend/plugins/simple-tags/screenshot-2.png)

###3. Add tags easily with click tags !###
![Add tags easily with click tags !](http://s.wordpress.org/extend/plugins/simple-tags/screenshot-3.png)

**3. To help you to add easily tags, Simple Tags has an autocompletion script. When you begin to tape a letter or more, a list a tags appears :** you have only to choose ! You can choose the down direction to see all the tags.
###4. You also can suggest tags from lot's of service (Yahoo! Term Extraction API, OpenCalais, Alchemy, Zemanta, Tag The Net, Local DB)###
![You also can suggest tags from lot's of service (Yahoo! Term Extraction API, OpenCalais, Alchemy, Zemanta, Tag The Net, Local DB)](http://s.wordpress.org/extend/plugins/simple-tags/screenshot-4.png)


## Change Log ##

* Version 2.4
	* Added all of Amaury's additions and fixes in his latest release 2.4.
* Version 2.3.3 (Initial release of "Tag Bag". 09/04/2014)
	* Forked from Simple Terms v2.3.2
	* This version includes the additions by SpazioDati (https://github.com/SpazioDati/simple-tags) as of Feb 07, 2014, to include dataTXT suggestions.
	* Restores the default WordPress Tags Meta box, since I didn't notice any real difference between it and the one added by Simple Tags, and I preferred the WordPress version. (Thus far not fully tested for any conflicts).
	* Tool-tips on tags when adding to a post show the count that tag currently has. Also shows the tag's description if one has been added.
	* Renamed all of the "st-", "st_" ID's and Classes to "tb_", "tb_" so that Simple Tags and Tag Bag can be installed at the same time (untested). One bonus to this is it should automatically resolve the conflict with the ShareThis plugin.
	* Removed the tabs in admin that just said certain features were removed.
	* Many other things that I can't recall off the top of my head. I'll add them as I recall them, IF I recall them; I ain't gettin' any younger.
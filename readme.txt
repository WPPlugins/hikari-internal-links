=== Hikari Internal Links ===
Contributors: shidouhikari 
Donate link: http://Hikari.ws/wordpress/#donate
Tags: link, Post, category, tag, custom type, taxonomy, p2p, Post to Post, shortcode, permalink, page, categories, posts, wpdberror, ID, slug, feed, RSS
Requires at least: 2.8.0
Tested up to: 3.0
Stable tag: 0.06.03

**Hikari Internal Links** provides a shortcode that dynamically generates to most Wordpress pages, like posts, comments, categories, feeds.

== Description ==

Don't worry anymore of linking a post or a category, to later change its title or slug, or changing your posts permalinks, and creating invalid links to your own site pages.

**Hikari Internal Links** provides a shortcode that dynamically generates links to most Wordpress resources. You can query these resources based on their ID or slug, and these links are generated dynamically. Therefore if you change a resource's title or permalink, its links will be updated automatically.


= Features =

* A shortcode generates links to internal pages dynamically
* If the permalink changes, links are updated automatically
* You can get links based on resources ID or slug
* If resource isn't found, you get a warning text surrounded by class <code>wpdberror</code>, which is hidden from your visitors and shown to you with a yellow background so that it's easy to notice and fix

= Available Resources =

* posts, pages and custom types, based on ID or slug
* comments, based on ID
* categories, tags and custom taxonomies, based on ID or slug
* feeds for categories, tags, comments of a post, based on their ID or slug
* if current resource was already set to global variable, you can use ID 0 to link to current resource


This plugin is a fork from <a href="http://www.toppa.com">Michael Toppa</a>'s <a href="http://www.toppa.com/post-to-post-links-wordpress-plugin">Post-to-Post Links II</a>.


== Installation ==

**Hikari Internal Links** requires at least *Wordpress 2.8* and *PHP5* to work.

You can use the built in installer and upgrader, or you can install the plugin manually.

1. Download the zip file, upload it to your server and extract all its content to your <code>/wp-content/plugins</code> folder. Make sure the plugin has its own folder (for exemple  <code>/wp-content/plugins/hikari-internal-links/</code>).
2. Activate the plugin through the 'Plugins' menu in WordPress admin page.
3. Now you can start using the shortcode to build internal links to your site


= Upgrading =

If you have to upgrade manually, simply delete <code>hikari-internal-links</code> folder and follow installation steps again.

= Uninstalling =

**Hikari Internal Links** doesn't store configs in database. You can freely deactivate it or simply delete its files and it will be fully uninstalled.


== Frequently Asked Questions ==

= Where can I see a list of all shortcode parameters and exemples of it being used? =

For a full description of its shortcode parameters, please refere to <a href="http://Hikari.ws/dev/wordpress/786/internal-links-exemples/">Hikari Internal Links – Exemples</a>.

= What happens if I build a link based on slug and later change that resource's slug?  =

Most resources can be queried by ID or slug, this feature is provided to offer flexibility on its use. When a resource is queried, the value used to query must refere to a existing resource. If you query using ID and change the resource ID, then there's no way to find what it used to refere to... same thing goes for using slug and later changing the slug.

I suggest using ID always when possible and never change resources IDs, that's not needed at all and could only be done editing directly the database.

= Where's the options page? =

There's none, currently I see no need to set options. Just use the shortcode anywhere you want :)


== Screenshots ==

**Hikari Internal Links** shortcode is <code>[hkLink]</code>, for a full list of available parameters and use exemples please refere to <a href="http://Hikari.ws/dev/wordpress/786/internal-links-exemples/">Hikari Internal Links – Exemples</a>.

== Changelog ==

= 0.06 =
* First public release.

== Upgrade Notice ==

= 0.06 and above =
If you have to upgrade manually, simply delete <code>hikari-internal-links</code> folder and follow installation steps again.

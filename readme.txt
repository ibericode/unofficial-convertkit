=== Unofficial ConvertKit ===
Contributors: ibericode, DvanKooten, hchouhan, lapzor, kool171
Donate link: https://www.ibericode.com/
Tags: convertkit, form, newsletter, email opt-in, subscribe
Requires at least: 5.0
Tested up to: 5.5
Stable tag: 1.0.3
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Requires PHP: 7.0

The best ConvertKit plugin for WordPress.

== Description ==

#### Unofficial ConvertKit plugin for WordPress

*Allowing your visitors to subscribe to your ConvertKit newsletters should be easy. With this plugin, it finally is.*

This plugin allows you to add various sign-up methods for your ConvertKit list to your WordPress site.
You can use it to show sign-up froms in your posts or pages or to add subscribers through other forms on your website.

#### Features

- Connect with your ConvertKit account in seconds.
- Easily embed your ConvertKit forms in posts or pages using the WordPress post editor.
- Add subscribers to ConvertKit through other forms on your website, like your comment or checkout form.
- Built-in integration with the following forms or plugins:
	- WordPress comment form
	- WordPress registration form
	- Contact Form 7
	- WooCommerce checkout form (Premium feature)
	- Gravity Forms (coming soon)

#### What is ConvertKit?

ConvertKit is an email service provider that is specifically marketed towards bloggers, podcasters, and other businesses who are building audiences.
This plugin allows you to tightly integrate your WordPress website with your ConvertKit account.

The Unofficial ConvertKit plugin is developed on GitHub here: [ibericode/unofficial-convertkit](https://github.com/ibericode/unofficial-convertkit/)

== Installation ==

1. In your WordPress admin panel, go to *Plugins > New Plugin*, search for **Unofficial ConvertKit** and click "*Install now*"
1. Alternatively, download the plugin and upload the contents of `unofficial-convertkit.zip` to your plugins directory, which usually is `/wp-content/plugins/`.
1. Activate the plugin
1. Set your ConvertKit API credentials in Settings > Unofficial ConvertKit.

== Frequently Asked Questions ==

== Screenshots ==

1. The settings page for connecting with your ConvertKit account.
2. Unofficial ConvertKit comes with several integrations.
3. Add a "sign-up checkbox" to any other form on your site.
4. Easily embed your ConvertKit form in a WordPress post or page.

== Changelog ==


#### 1.0.3 - Nov 18, 2020

- Fix PHP notice from register_block_type.
- Minor improvements to code readability.


#### 1.0.2 - Aug 31, 2020

- Improve performance of form rendering by saving script URL in block attributes.
- Add debug log for easier debugging.
- Determine connection status using AJAX to speed-up page load of settings pages.


#### 1.0.1 - Aug 4, 2020

Fixes an issue where the plugin would silently fail on PHP version 7.2 or lower.

#### 1.0.0 - Aug 3, 2020

Initial plugin release.


# Essential Contact Form
The essential contact form plugin for WordPress. Deliberately designed to be as "cut-back" as possible and lightweight in order to be versatile.


## Features

- Collects the user's name, email address *or* phone number, and their message
- reCAPTCHA v3 for spam/bot protection
- Submits asynchronously
- Email send to admin/root user's email address
- Inline validation and server-side validation both
- **No default CSS** - bring your own styling (none is even provided)


## Usage

1. Get a reCAPTCHA v3 Site Key and Secret Key from Google. There's an WP-Admin view to help you with that.
2. Put `[essential_contact_form]` shortcode on any page. 

I always use Classic Editor so I don't know how it works if you use Block Editor/Gutenberg - I believe there's a block for shortcodes, so use that.

I always intended but never got around to "de-coupling" the template file from the theme code itself. It was my hope that a developer could put a file called `wicked-contact-form.php` inside of their theme directory and it'd override the default template (this is how WooCommerce is so customisable and it's awesome). The incentive was never really there because I just made the default template be what I needed it to be anyway.

## (Potential) roadmap

- [x] Set any email address for form submissions to be sent to - implemented and works, form fields on Admin view are in the wrong order and I don't know why. Also should default to root user (id 1)'s email, not sure if it does
- [ ] Allow overriding of template (shortcode output) with one in the current theme's directory, a la WooCommerce
- [ ] Break out the JS into its own file

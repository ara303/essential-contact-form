# wickedcontactform
A contact form for WordPress with AJAX submitting and support for reCAPTCHA v3. No nonsense. Wicked. 😎

## Statement on maintenance
First and foremost: it works! You will of course need to sign up to reCAPTCHA v3 but there's an WP Admin view made for that. It also doesn't work if you haven't done it.

I finished this so far as I needed to for the websites I use it on! I always intended but never quite got around to "de-coupling" the template file from the theme code itself, it was my hope that a developer could put a file called `wicked-contact-form.php` inside of their theme directory and it'd override my template (in case they wanted it to look differently or needed markup customisation). I never quite got around to it and, embarrassingly, the incentive was never really there given that I'm content with the default markup generation. Anyway...

## Roadmap 

- Allow overriding of template file with one in the current theme's directory, a la WooCommerce

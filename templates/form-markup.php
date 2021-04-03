<?php
$recaptchaSite = get_option( 'wickedcf_settings' )['recaptcha_site'];
$recaptchaSecret = get_option( 'wickedcf_settings' )['recaptcha_secret'];
if( empty( $recaptchaSite ) || empty( $recaptchaSecret ) ){
  die( 'Error: reCAPTCHA site and/or secret keys were blank. No contact forms for you.' );
}
?>
<form class="contact-form" action="<?php echo plugin_dir_url( __DIR__ ); ?>submit.php" method="post" name="wickedcf_form">
  <div class="contact-form__section">
    <label class="contact-form__label" for="wickedcf_name">Your name:</label>
    <input class="contact-form__input" type="text" name="wickedcf_name" id="wickedcf_name">
  </div>
  <div class="contact-form-section">
    <label class="contact-form__label" for="wickedcf_email">Email address:</label>
    <input class="contact-form__input" type="email" name="wickedcf_email" id="wickedcf_email">
  </div>
  <div class="contact-form-section">
    <label class="contact-form__label" for="wickedcf_phone">Phone number:</label>
    <input class="contact-form__input" type="phone" name="wickedcf_phone" id="wickedcf_phone">
  </div>
  <div class="contact-form-section">
    <label class="contact-form__label" for="wickedcf_phone">Your message:</label>
    <textarea class="contact-form__input contact-form--textarea" name="wickedcf_message" id="wickedcf_message"></textarea>
  </div>
  <div class="contact-form-section contact-form-section--submit">
    <button class="contact-form__button">Send message</button>
  </div>
  <div class="contact-form__success" style="display: none;"><strong>Thanks!</strong> That's sent. We'll reply as soon as we can.</div>
  <div class="contact-form__failed" style="display: none;">Please make sure you provided a name, email address <em>or</em> phone number, and a message. Alternatively, why not call us? 📞</div>
</form>

<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $recaptchaSite; ?>"></script>
<script>
  const contactForm = document.querySelector( '.contact-form' );

  document.querySelector( '.contact-form' ).addEventListener( 'submit', function( event ){
    event.preventDefault();

    grecaptcha.ready(function() {
      grecaptcha.execute( $recaptchaSite, {action: 'submit'}).then(function(token) {
        let tokenEl = document.createElement( 'input' );
        tokenEl.setAttribute( 'type', 'hidden' );
        tokenEl.setAttribute( 'name', 'recaptchaToken' );
        tokenEl.setAttribute( 'value', token );
        contactForm.appendChild( tokenEl );

        let request = new XMLHttpRequest();
        request.open( 'POST', contactForm.action, true );
        request.send( new FormData( contactForm ) );

        request.onload = function() {
          if( this.status >= 200 && this.status < 400 ){
            let data = JSON.parse( this.response );
            if( data.success ) {
              document.querySelector( '.contact-form__success' ).style.display = 'block';
              document.querySelector( '.contact-form__failed' ).style.display = 'none';
              document.querySelector( '.contact-form__button' ).disabled = 'disabled';
            } else {
              document.querySelector( '.contact-form__failed' ).style.display = 'block';
            }
          } else {
            alert( "We're sorry, but there was an error. Please give us a call instead?" );
          }
        };
      });
    });
  });
</script>
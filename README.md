This module is meant to be a plugin that works with the PHPMailer SMTP module, providing
authentication to Google Workspace Gmail via OAuth2.  It is inspired by phpmailer_oauth2,
written by Ian McLean (imclean).  Had I not found Ian's module, it is unlikely I would
have attempted to work on one for Google Gmail.

IMPORTANT:  This module requires the Google league/oauth2-google module, available at 
https://oauth2-client.thephpleague.com/providers/league/.  It should be installed in
your vendor directory.

Before using this module, it is necessary to set up a Client ID and Client Secret
on Google.  Here is how to do that as of April, 2024, and configure this module:

1.  Sign in to your Google Workspace account.

2.  Go to https://console.cloud.google.com/.

3.  At the top left of the page next to "Google Cloud", there should be a projects dropdown. 
    Click on it.

4.  If you have no projects listed in the 'Select a resource' dialog box, create one,
    then select it as your current project.

5.  Click on 'APIs & Services', a large button somewhere in the center of the page.

6.  Click on Credentials in the menu that appears on the left-hand side of the page.

7.  Click on CREATE CREDENTIALS, then select 'OAuth client ID'.

8.  Select 'Web application' for Application Type.

9.  Name your credentials, and note your Client ID and Client Secret.  You will need to 
    enter these values in (11) below.

10. Once you have installed this module, you can find the 'Authorized redirect URI' for your site
    by going to Configuration->System->PHPMailer Gmail OAuth2 (/admin/config/system/phpmailer-gmail-oauth2).
    Bring up that page in a separate browswer window, and you will find the redirect URI required by 
    Google near the top of the page.  Copy the URI and enter it in an 'Authorized redirect URIs' box 
    on the Google page.  Press Save.  

11. Back on the Drupal page, enter your Google email address, Client ID, and Client Secret, then press
    the 'Save configuration' button.

12. After you've saved your Google credentials, a 'Get Refresh Token' button will appear.  Press 
    that button to redirect from your site to Google, then follow the instructions on Google.  
    When you're done, Google should issue a Refresh Token and redirect back to the Drupal page you 
    just left.  If everything worked, you will have your Refresh Token and are ready to send email.

13. If you encounter problems redirecting to Google when you press the 'Get Refresh Token' button,
    you may need to add the following to your settings.php file:

    $settings['trusted_host_patterns'] = ['^accounts\.google\.com$'];

    If you have other trusted_host_patterns, add '^accounts\.google\.com$' to the array.

A few other setup items:

1.  Don't forget to go to the Mail module to select 'PHPMailer SMTP' as your mail Formatter and Sender
    (/admin/config/system/mailsystem).

2.  If you have other modules such as Commerce 2 that send mail, you may need to add them at the 
    bottom of the same page in (1) above.

3.  On the PHPMailer SMTP transport settings page, select 'Gmail OAuth2' as your SMTP authentication method
    (/admin/config/system/phpmailer-smtp).  Set the SMTP port to 587, and select TLS as the secure protocol.

You can use the 'Test configuration' service on the PHPMailer SMTP transport settings page to verify that
the new configuration is working by sending a test email.

<<<<<<< HEAD
# phpmailer_gmail_oauth2
Drupal 10 module designed as GMail Oauth2 plugin for PHPMailer SMTP module
=======
This module is meant to be a plugin that works with the PHPMailer SMTP module,
authentication to Google Workspace Gmail via OAuth2.  

This module requires the Google league/oauth2-google module, available at 
https://oauth2-client.thephpleague.com/providers/league/.

Before using this module, it is necessary to set up a Client ID and Client Secret
on Google.  Here is how to do that as of April, 2024:

1.  Sign in to your Google Workspace account
2.  Go to https://console.cloud.google.com/
3.  At the top left of the page, there will be a dropdown.  Click on it
4.  If you have no projects listed in the 'Select a resource' dialog box, create one,
    then select it as your current project
5.  Click on 'APIs & Services', a large button somewhere in the center of the page
6.  Click on Credentials in the menu that appears on the left-hand side of the page
7.  Click on CREATE CREDENTIALS, then select 'OAuth client ID'
8.  Select 'Web application' for Application Type
9.  Name your credentials, and note your Client ID and Client Secret
10. Assuming you have installed this module, you can find the 'Authorized redirect URI' for your site
    by going to Configuration->System->PHPMailer Gmail OAuth2 (/admin/config/system/phpmailer-gmail-oauth2).
    The redirect URI required by Google will shown be near the top of the page

Once you've set up your API credentials, go the page specified in (10) above. Input your Email address,
Client ID, and Client secret in the boxes provided, then press 'Save configuration'. After you've saved,
a 'Get Refresh Token' button will appear.  Press that button to redirect from your site to Google, then
follow the instructions on Google.  When you're done, Google should issue a Refresh Token and redirect 
back to the Drupal page you just left.  If everything worked, you will have your Refresh Token and are 
ready to send email.

A few other setup items:

1.  Don't forget to go to the Mail module to select 'PHPMailer SMTP' as your mail Formatter and Sender
    (/admin/config/system/mailsystem)
2.  If you have other modules such as Commerce 2 that send mail, you may need to add them at the 
    bottom of the same page
3.  On the PHPMailer SMTP transport settings page, select 'Gmail OAuth2' as your SMTP authentication method
    (/admin/config/system/phpmailer-smtp)

You can use the 'Test configuration' service on the PHPMailer SMTP transport settings page to verify that
the new configuration is working.
>>>>>>> 1681d84 (Initial Commit)

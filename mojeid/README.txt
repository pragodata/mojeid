mojeID authentication plugin for Moodle
=======================================

This extension adds to the Moodle login page the block with option to sign in using the authority mojeID.

If the user is signing into Moodle through this extension first time, then its account is automatically created.

But if there is an user account in the system with the same user email, then the login fails.
This situation can be solved by asking the system administrator to change the authorization plugin to the method "mojeID" for that user account.

Warning. The extension changes the value of the configuration variable "additionalhtmlhead". Without this change, the extension will not be working.

Installation of extensions:
---------------------------
From Moodle version 2.5 or higher it is possible to install extensions automatically from Moodle.org.
For manual installation, or a different version, follow these steps:

1. save the extension content to the directory /auth/mojeid/

2. at Moodle settings enable this extension (site administration > Plugins > Authentication)

3. follow the instructions in the extension settings

A procedure for resolving conflicts with an existing account (username, email):
-------------------------------------------------------------------------------

1. In the administration go to the page with list of users (/admin/users.php).

2. Find a conflicting user account here.

3. Go to the page with the details of that account.

4. Choose "Edit Profile".

5. Set the authentication method to "MojeID".

6. Confirm with the save option at the bottom of the page.


Author
-------
[PragoData Consulting, s.r.o.](http://www.pragodata.cz)
phone: +420 545 211 580

[Moodle Partner - PragoData Consulting, s.r.o.](http://www.moodlepartner.cz)

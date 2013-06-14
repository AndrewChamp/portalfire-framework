PortalFire Framework [logo]: https://github.com/AndrewChamp/portalfire-framework/blob/master/_ignore/portalfire-logo.png
====================

A single, core framework for developing multiple sites.  No need to rewrite the same code for every site.  Fast and easy way to setup and run a site.

Let me start by saying, that this framework is a DEVELOPER'S framework.  There is no GUI.  You can easily create one using the Classes in the framework if you like.
I just don't like the bloat, and just wanted a framework that would handle as many domains that I added without rewriting the same code.

##Benefits

- No redundant coding
- Reuse the same open connection to the database
- Optimized for page loading
- Deploy sites quicker
- Easy to customize
- Developer mode for debugging
- Custom Error Handlers


##Setup

###Database
- Import the portalfire.sql file provided
	* This will create the tables 'configuration', 'content', & 'error'
		* 'configuration' -> Some framework options
		* 'content' -> Pages that will make up the site/app
		* 'error' -> Contains status codes for document / server errors

###Files
- Upload the 'portalfire' directory above public_html.
	* Example:  _'/home/user/portalfire/'_

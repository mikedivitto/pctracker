OpenLabs
========

###SOFTWARE USED
- MySQL Server Version 5.1.71  
- PHP Version 5.3.3  
- Apache Version 2.2.15

###INSTALLATION
- Extract the contents of the WWW folder to a specified directory on the web host.  
- Edit /func/config.php and enter the Database information (DB Name, Credentials, etc.).  
- Point web browser to the site (check to make sure the index file loads).  
- If the main page loads, then open /restr/setup.php (from the browser) and enter the default login.  
  - This will setup the database for use.  
- Begin adding computers by pointing to /admin and loggin in from there.  
  - Go to Computers -> Register and fill out the web registration form (for each computer).  
  - Each computer must also have the client installed, and run at USER LOGIN (this must be configured).  

###REMOVAL
- Remove the client files from each computer and deregister it as a login item.  
- The database can be dropped (manually), and the contents from the WWW directory can just be deleted.  

###NOTES
- I use phpMyAdmin for administration beyond what the web interface provides, however I DO NOT package this.  
  - This is a separate download, even though there is a link to it in the Admin Console.  

**This article still needs to be expanded.**

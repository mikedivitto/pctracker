# PC Tracker

## DEPENDENCIES

- CentOS  
- MySQL Server Version 5.1.71  
- PHP Version 5.3.3  
- Apache Version 2.2.15  
- Memcached  
- php-pecl-memcache (not php-pecl-memcached)  

## INSTALLATION

- Extract the contents of the WWW folder to a specified directory on the web host.  
- Edit /func/config.php and enter the Database information (DB Name, Credentials, etc.).  
- Point web browser to the site (check to make sure the index file loads).  
- If the main page loads, then open [HOST]/restr/setup.php (from the browser) and enter the default login.  
  - This will setup the database for use.  
- Begin adding computers by pointing to /admin and loggin in from there.  
  - Go to Computers -> Register and fill out the web registration form (for each computer).  
  - Each Computer must have the client installed (which automatically registers it to run while logged in).  
- The script must be updated to include the Server IP, Server Name, and the Directory  

## REMOVAL

- For client machines, run the uninstaller from the Add/Remove Programs
- For the server, drop the database and remove the files from the WWW directory.

## NOTES

- I use phpMyAdmin for administration beyond what the web interface provides, however I DO NOT package this.  
  - This is a separate download, even though there is a link to it in the Admin Console.  
- In the demo, all are running on the same server (Linux, PHP, Apache, MySQL, memcached, php-pecl-memcache)  
  - These functions can be disributed, but must be configured accordingly (memcached is great with this).  
- I have recreated this on a virtual machine using the software noted above and have gotten this to work with basic configurations.  
- The server configuration is completely up to the server admin, however the software above is necessary for this platform to run (Apache, MySQL, Memcache, etc.).  
  - It is basically just a LAMP server with memcached.

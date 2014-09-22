## Installation

I assume you already have Wamp Server (www.wamp.com) on your computer.

1. First download or clone this repository into a folder 'PirateChest' in your www directory.
2. Navigate to the application/_install folder and run the Install.bat file as administrator. On successful install move to step 3.
3. Go to the root directory and run the PirateChest.bat file. Congratulations you can now navigate to your IP:3000 on your browser. 
4. Register the admin account and login. 
5. Upload the files you will like to share.
6. Connect from other devices on PirateChest Wi-Fi network and navigate to IP:3000.
7. Try downloading the files you uploaded.
8. Use Ctrl + C to close the server and to switch off the network run PirateChestStop.bat as administrator.

Congrats You Have Successfully Made Your First Lunch.

**Note:: No need to do 1-4 all the time after install as this will reset the PirateChest. Just lunch the server.

**Note:: For large files upload, edit php.ini as follows(for 513MB max upload)
upload_max_filesize = 513M
post_max_size = 513M
memory_limit = 512M
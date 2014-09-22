## PirateChest

PirateChest is a file sharing application written in PHP. It helps you share files from your computer making it serve to 100 clients at the same time via Wi-Fi. These clients can download upload, chat with you and other clients in real-time. 

PirateChest is totally independent of the internet thereby making it secure for any activity.

## Installation

I assume you already have Wamp Server on your computer.

1. First download or clone this repository into a folder 'PirateChest' in your www directory.
2. Navigate to the application/_install folder and run the Install.bat file. On successful install move to step 3.
3. Go to the root directory and run the PirateChest.bat file as administrator. Congratulations you can now navigate to your IP:3000 on your browser. 
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

## Use cases
* Class rooms - Asking questions and sharing files between instructor and students
* Meet ups - Asking questions and sharing files.
* Meetings - Asking questions and sharing files.
* Hack days - Asking questions, sharing encryption keys, API keys etc. and sharing files.
* Personal - Sharing files between computer and mobile or other devices.
The possibilities are endless.

### Contributing To PirateChest

**All issues and pull requests should be filed on the [AminuBakori/PirateChest](http://github.com/AminuBakori/PirateChest) repository.**

### License

PirateChest is an open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

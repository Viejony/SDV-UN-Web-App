# SDV-UN-Web-App

This web application makes the use of the SDV (LabFabEx in National University of Colombia) simpler, through a user interface based on a map and navigation buttons.

To use this web application, you need to provide a php backend, a mySQL database for user management and Apache Server for webhosting. XAMMP software can manage this set of tools.

## Installing XAMPP
Follow this tutorial to install XAMPP in Ubuntu: [XAMPP oun your Ubuntu](https://vitux.com/how-to-install-xampp-on-your-ubuntu-18-04-lts-system/)

On Windows, download the installer [here](https://www.apachefriends.org/es/index.html), execute it and click in continue, etc.

## Loading project in XAMPP
1. Go to XAMPP folder. On Ubuntu, this folder typically is ```/opt/lampp```. On Windows, this folder can be ```C:\xampp```. 
2. There is a folder named htdocs. Go to that folder.
3. Inside htdocs, clone this project using git: ```git clone https://github.com/Viejony/SDV-UN-Web-App```
3. Rename the folder ```SDV-UN-Web-App``` to ```SDV```. This operatión simplifies the URL name in the browser.


## SQL Database
Follow [this](https://skillforge.com/how-to-create-a-database-using-phpmyadmin-xampp/) tutorial to create databases in XAMPP with phpMyAdmin.

The database must be like this:
- Name: sdv_un
- Table: users
- Columns:
    * id: int, primary key, auto_increment
    * username: varchar1
    * password: varchar
    * ip: varchar
    * status: varchar

## Accesing to SDV-UN-Web-App
In your favorite web browser, with XAMPP runing and configured, go to this web page:
```http://localhost/SDV```

You can acces to this aplication from other device conected in the same local network. To this, you will need the IP direction of PC with XAMPP. For example:
```http://l192.168.1.57/SDV```
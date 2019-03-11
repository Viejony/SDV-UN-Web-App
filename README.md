# SDV-UN-Web-App

This web application makes the use of the SDV (LabFabEx in National University of Colombia) simpler, through a user interface based on a map and navigation buttons.

To use this web application, you need to provide a php backend, a mySQL database for user management and Apache Server for webhosting. XAMMP software can manage this set of tools.
The database must be like this:
- Name: sdv_un
- Table: users
- Columns:
    * id: int, primary key, auto_increment
    * username: varchar
    * password: varchar
    * ip: varchar
    * status: varchar

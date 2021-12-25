# final-tp-PHP

## By Mattéo FERREIRA et Maxime MOURGUES

Table of Contents:
[ToC]

## Installation guide:
### Pre-requires:
- Php 8.+
- You need to uncomment `extension=openssl` in your `php.ini` file.
> :memo: You can find it around ~line 940
> :warning: Without this line uncommented, the mailing system will not work, so please, do it.
- phpMyAdmin
> If you have Xamp/Lamp you already have it.

### Set-up:
Create a new database in `phpMyAdmin` named ==forum==, then:
- Go to `Import`
    - Upload the `forum.sql`, then click on **Run**
    > `forum.sql` can be found in `/Path/to/final-tp-PHP/Model/Database`

After that, open any 
Go to `/Path/to/final-tp---/View/WebSite`
Once you're here, type `php -S localhost:<any_port>`
> Of course, don't include the `<>`, just put a port you want your server to run on. For example, you can use `8080

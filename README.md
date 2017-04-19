# FoodCoopShop Installer
Installs the FoodCoopShop open source software for your foodcoop

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

FoodCoopShop is a free open source software for foodcoops. For more information about it visit the [project details homepage](https://www.foodcoopshop.com/).

This Installer aims at easing the installation by providing a web interface for setup and automising the required steps.

## Requirements
See the [Installation requirements](https://github.com/foodcoopshop/foodcoopshop/wiki/Installation-details) of the FoodCoopShop itself. This Installer will run on bare PHP and test for these requirements before doing anything.

Required PHP modules not shown there: GD

## Install the Installer

[Download the latest version](https://github.com/foodcoopshop/fcs-installer/tree/master/latest) (2 files) to Your computer and upload the files to the DocumentRoot of Your webserver. Now run the installer using Your favourite webbrowser by opening `http://yourdomain.tld/index.php`

# Developers area

If you have any questions please contact us on [FoodCoopShop's GitHub Repository](https://github.com/foodcoopshop/foodcoopshop/).

This project is highly connected to the latest version of FoodCoopShop. To contribute to this project You must have deep knowledge about the FoodCoopShop internals. You must use a yet unused webserver.

## Get sourcecode
**Clone the repository** into the project folder (e.g. ~/MyProjects/) of Your local machine.
```
cd /path/to/projects/
$ git clone https://github.com/foodcoopshop/fcs-installer.git
```
You shall now have a subdirectory fcs-installer/ in it.

## Install required packages
Install the composer vendors
```
cd /path/to/projects/fcs-installer
$ composer install --prefer-dist
```

## Build the project phar
```
$ cd /path/to/projects/fcs-installer
$ ./make.sh
```
This will build Your PHAR file and copy it with all other required files into /fcs-installer/latest/. Copying to a \*.php name is required, as normal webhosting setups do not recognize \*.phar as a PHP file and attempt to send the file to the user instead of running it.

## Run the Installer
Upload the contents of /fcs-installer/latest/* to Your webservers DocumentRoot and open `http://yourdomain.tld/` in Your browser.

## Pull requests
Pull requests are welcome, please make sure your modifications are to the develop branch of FCS Installer and they are well tested!

# Links
* **Official website**: [https://www.foodcoopshop.com](https://www.foodcoopshop.com)

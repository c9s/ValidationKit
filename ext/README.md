ValidationKit C extension baseon Phalcon kernel
=====================

ValidationKit C extension is rewritten in C with phalcon kernel, providing high
performance and lower resource consumption.

* NOT All Validators are porting to C extension.

Get Started
-----------

### Linux/Unix/Mac

On a Unix based platform you can easily compile and install the extension from
sources.

#### Requirements
We need some packages previously installed.

* PHP 5.x development resources
* GCC compiler

Ubuntu:

    sudo apt-get install php5-devel php5-mysql gcc make

Suse:

    yast2 -i php5-pear php5-dev libmysqlclient gcc make autoconf2.13

Compilation
-----------

Follow these instructions to generate a binary extension for your platform:

     # git clone git@github.com:racklin/ValidationKit.git
     # cd ValidationKit/ext
     # export CFLAGS="-O2 -fno-delete-null-pointer-checks"
     # phpize
     # ./configure --enable-validationkit
     # make
     # sudo make install

Add extension to your php.ini

     extension=validationkit.so

Finally restart the webserver


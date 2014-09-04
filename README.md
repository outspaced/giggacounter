Giggacounter
============

Giggacounter is a simple Kohana 3 module that takes the user gigography APIs from Songkick and Last.fm and draws bar charts based on the chosen breakdown of the user's gig attendance.

HOSTED DEMO
===========

There is a hosted demo at http://giggacounter.outspaced.com/

USAGE
=====

Giggacounter can be installed using Composer, just add these instructions to your composer.json:

{
        "repositories": [
                {
                        "type": "vcs",
                        "url": "git@github.org:outspaced/giggacounter.git"
                }
        ],
        "require": {
                "outspaced/giggacounter": "dev-master",
        }
}

Once installed, it's just a case of enabling the module (also requires enabling the cache module) and navigating to <yoururl>/giggacounter/ - as long as you have a valid Kohana setup, no other set up should be necessary.

COPYRIGHT
======

Author: Alex Brims <alex.brims@gmail.com>  
Copyright: © Alex Brims 2014
Licence: GNU GPL v3.0

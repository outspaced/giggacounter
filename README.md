Giggacounter
============

Giggacounter is a simple Kohana 3 module that takes the user gigography APIs from Songkick and Last.fm and draws bar charts based on the chosen breakdown of the user's gig attendance.

HOSTED DEMO
===========

There is a hosted demo at http://giggacounter.outspaced.com/

USAGE
=====

Giggacounter can be installed using Composer, just add these instructions to your composer.json:

<pre>
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
</pre>

Once installed, it is necessary to add API keys for Songkick and Last.FM in order to use.
	https://www.songkick.com/api_key_requests/new
	http://www.last.fm/api/account/create

These keys must be added to giggacounter/config/giggacounter.php.

Once this is done, it is just a case of enabling the module (plus the cache module) and navigating to &lt;yoururl&gt;/giggacounter/ - no other set up should be necessary.

COPYRIGHT
======

Author: Alex Brims &lt;alex.brims@gmail.com&gt; 
Copyright: © Alex Brims 2014
Licence: GNU GPL v3.0

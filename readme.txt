=== Plugin Name ===
Contributors: uktw
Tags: theatre, concerts, tickets
Requires at least: 2.7
Tested up to: 5.0.3
Stable tag: 1.0
Donate link: http://www.uktw.co.uk/tickets/

Search and display information from UK Theatre Web's extensive database of UK what's on information.

== Description ==

This plugin provides access to UK Theatre Web's unique database of what's on information for the UK. Specialising in live performance  (theatre, opera, dance, concerts) and exhibitions. The data includes details of productions, cast and venues and includes a searchable archive going back to the mid-1990s.

Ticket information is provided by the SeatChoice ticket finder service through affiliate links to checked and safe ticket agents and retailers - these affiliate links are explicitly labelled with the Ticket Supplier's details and capabilities. The SeatChoice engine searches all major suppliers and provides both live availability and price searches. Information is provided on offers, tickets, meal deals and theatre breaks. All ticket, offer and break details are provided though affiliate links to appropriate suppliers - it is hoped soon to be able to offer earnings-sharing with users of this widget.

The system operates in English, no translations of the database are available so no translations of the widget have been provided.

= Widget =

The widget can be dropped into your template and can be set to display a number of items

* Top London Shows
* Top Regional Shows
* A single show, venue, tour or "work"
* A search box
* A randomw London show

The title and content of each instance of the widget can be set in the admin area.

= Shortcode =

In the following examples, L327 (Phantom of the Opera) represents the Qtix code for the event. Qtix codes can be found from the listings pages on [UKTW](http://www.uktw.co.uk/) and may refer to a venue, work, production (tour) or listing (these terms are [defined here](http://www.uktw.co.uk/archive/).

* [uktw qtix="L327" format="title"] - retrieves the title for L327 and links it to the UK Theatre Web page
* [uktw qtix="L327" format="image"] - creates a linked image for L327
* [uktw qtix="L327" format="title"]click here for details[/uktw] - creates a link
* [uktw format="bio"]Trevor Nunn[/uktw] - creates a link to the Trevor Nunn search page
* [uktw format="search"]les mis[/uktw] - creates a link to search results for "les mis"
* [uktw format="search" key="les miserables"]search les mis[/uktw] - creates a link to search results for "les miserables"
* [uktw format="town" key="glasgow"]search glasgow[/uktw] - creates a link to search results for towns/venues matching "Glasgow"
* [uktw format="town"]glasgow[/uktw] - creates a link to search results for townsvenues matching "Glasgow"

All external links are target="uktw".

= Template Tags =

Display the title of a Qtix code
  echo ( uktw_qtix_tag( 'L322', 'title' ) ) ; 

Get the link to a Qtix code
echo ( uktw_qtix_tag( 'L322', 'link' ) ) ; 

Combined example
echo ( "<a href = '" . uktw_qtix_tag( 'L322', 'link' ) . "' >" . uktw_qtix_tag( 'L322', 'title' ) . "</a>" ) ; 

Additional template tags will be provided eventually, if required.

== Installation ==

1. Upload the files to a new sub-directory `/wp-content/plugins/uktw`
1. Activate the plugin through the 'Plugins' menu in WordPress
1. You now have access to new Shortcodes, template tags and widgets

The single setting "Affiliate" may be used in future to track sales and provide feedback to those who have installed the plugin. Set it to an alphanumeric name, e.g. FREDDIBNER and we will start tracking shortly.

== Frequently Asked Questions ==

= Where does the information come from? =

All of the content is provided from the UK Theatre Web database and the SeatChoice ticket finder and comparison engine.

== Screenshots ==

None provided yet ...

== Changelog ==

= 0.3 =
* Minor update to readme

= 0.2 =
* Initial update

= 0.1 =
* Initial version

== Upgrade Notice ==

= 0.3 =
Very minor changes

= 0.2 =
Minor changes, addition of template tags.

= 0.1 =
As this is the initial version, no upgrade is required

== UK Theatre Web ==

The UK Theatre Web website and database is owned and operated by Dynamic Listing Ltd who are an Affiliate member of STAR (The Society of Ticket Agents and Retailers)


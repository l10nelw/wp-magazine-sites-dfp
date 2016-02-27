Implementation of DoubleClick For Publishers (DFP) ad management service on a Wordpress site with multiple sections.

Sections (categories) can be ad-targeted, e.g. fashion ads in the Fashion section. The correct ad codes are deployed on a page depending on the section it belongs to.

Implementation includes a non-standard ad unit (called skinner) that runs a clickable background image.

Ad code generating tool is included in this repo.

Customise these files as necessary:

functions.php - Code here is to be added to the Wordpress site's functions.php, or equivalent area if provided by a framework. If <head> area provided, you can add the code within ad_head() into it, and remove the ad_head() definition and add_action() line.

adunits.py - Python script that generates a CSV file that can be imported into DFP to bulk-create ad units.
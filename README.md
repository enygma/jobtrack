JobTrack
===================

The JobTrack application is intended as a learning platform for the integration of FuelPHP (http://fuelphp.com),
a PHP backend, and the Backbone.js (http://backbonejs.org/) Javascript framework.

My goal with the project is not to neccesarily make a fully-functioning application, but rather to learn about
the challenges associated with integration a RESTful API backend into Backbone.

The functionality of the system includes:
- Being able to store position information
- Storing Applicant information
- Storing Position information
- Tagging on both Positions and Applicants
- Linking Positons and Applicants by tags
- Viewing lists of the most recent Applicants and Positions added

**Technologies used:**
- Backbone.js
- Require.js
- jQuery
- Underscore.js
- Bootstrap-dropdown (plugin)
- FuelPHP
- MySQL

**Setup:**

1. Unpack the files into your document root
2. Create a database to use and run the "app/config/init.sql" to create the tables
3. Load the app!

**Default Database settings:**
> user: jobtrack
> pwd: jt42
> db name: jobtrack

@author Chris Cornutt <ccornutt@phpdeveloper.org>

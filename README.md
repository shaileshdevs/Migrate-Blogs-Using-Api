# Migrate Blogs Using API

What does this plugin do?
-
* This plugin allows you to import the users as authors and blogs as Articles in your WordPress site.
* It imports the users and blogs from an external site using API.

How does the plugin work?
-
Here is the workflow about how the plugin works:
* The plugin creates a custom post type named as "Articles".
* This "Articles" custom post type has only three fields:
  - Title
  - Description
  - Author
* To import the users or blogs into your WordPress site, visit the submenu "Fetch Users & Articles" [ Articles > Fetch Users & Articles ].
* When you click on the button "Fetch Users", the plugin extracts the data at https://jsonplaceholder.typicode.com/users using API.
* Then, it imports the users into your WordPress site as Authors.
* The following standard WordPress fields related to user are populated by this plugin:
  - Username
  - Email
  - Display Name
* It also populates the following custom user fields created by the plugin itself:
  - Address Street
  - Address Suit
  - Address City
  - Address Pincode
  - Phone
  - Company Name
  - Website
* When you click on the button "Fetch Articles", the plugin extract the data at https://jsonplaceholder.typicode.com/posts using API.
* It imports the blogs as Articles into your WordPress site.
* It assigns all of the newly created Articles to one of the authors imported after you clicked on the "Fetch Users" button.
* If there is no author imported earlier, it assigns all Articles to admin itself.
* It populates the following fields in the Articles custom post type:
  - Title
  - Description
  - Author
  

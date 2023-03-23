This is a Web programming project I completed in the first semester assigment in my second year.
I was tasked with creating functionality into the backend of the website as the front end was already created.
It is an auction style website where we was tasked with duties mainly 
- Using POST/GET request to send and retrieve data from the backend 
We had to:
- Create accounts
- Create listings
- Allow certain users access to specific areas of the websites depending on the type of access
that there were given from the database.

We used PHP 8.1 as the logic for the website (Logic, POST/GET requests) and we used MySQL 
to store data into our database
CSY2028 Web Programming PHP & MySQL Assignment 1
This is an assignment aimed to assess the ability to create a database driven website using PHP and MySQL. The task is to implement functionality into a website for a startup auction site where users can advertise products for sale at auction. The front end developer has supplied an HTML layout with the relevant CSS and Images which should be used for every page of the website. The contents of the main tag will differ on each page, but everything else in the layout should be visible on each page.

Aims and Objectives
The objective of this assignment is to assess the ability to create a database-driven website using PHP and MySQL.

Brief
As a backend developer working for a web development agency, the task is to build a website for a startup auction site where users can advertise products for sale at auction. The front-end developer has supplied an HTML layout with the relevant CSS and Images. The website should be able to allow anyone to register, advertise a product on the site and categorize it.

To keep things organized, the website's owner wants to be able to add categories that people can assign products to. Some example categories are Electronics, Home, Motors, and Fashion. Anyone should be able to register and categorize products.

The home page should display the 10 most recently created auctions. The public should be able to browse products and filter by category. Members of the public should be able to add reviews to each other. The reviews for each product should be visible below the product description, and reviews should only be visible on the page of the product they were posted to.

Requirements
The system must use the layout that was supplied by the designer and have two access levels. Admin users can control the categories on the site, and standard users can post auctions.

Password Protected Administration Area
Add categories
Edit categories
Delete categories
Added categories should appear on the top of the website.
Publicly Visible Front End
Register an account and log in
Users can post auctions on the website by supplying the product's information: Name, Description and end date/time. Auctions must be associated with the currently logged-in user.
When posting an auction, the user should be able to select from one of the categories managed by the administrator and see all auctions in that category (Use the HTML from the “Latest Listings / Search Results / Category listing” section of the supplied layout)
The homepage should display the 10 most recently added auctions
Users should be able to edit auctions they have created to fix typos or update information
Users should be able to delete auctions they have created
Click on one of the categories to view products in that category (products from other categories should not be visible)
Click on an auction and see a page displaying information about that auction (Use the HTML from the “Product Page” section of the supplied layout)
Add your review of a user
The reviews for a user should be displayed at the bottom of any of their auction listings.
The remaining time of the auction should be calculated and displayed on the auction page using the end date/time supplied when the auction was created.
Additional Requirements
In addition to the requirements outlined above, additional features can be added to improve the grade, as outlined below.

There are marks available for usability, you should use select boxes/checkboxes/radio buttons in place of text input where applicable and consider how user-friendly the website is. Users should never need to type in or remember numerical IDs.


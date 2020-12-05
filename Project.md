# ITCS 333/473: Project

### BASIC REQUIREMENTS:
You should form groups of 3 to 5 students each.

### PROJECT MAIN GOAL:
Use current web and Internet development tools and techniques to create a small webapplication.

### PROJECT THEME: Online Customer-to-Customer Auction System

## The main functionalities of the system might include but not limited to the following:
1. Registration and Login [All required]
	- Users can register themselves to the system (must be validated using regular expressions)
	- Users can login to the system (authorization)
2. User Profile Management [All required]
	- Users can manage and edit their profile (change info, change password, change profile picture).
3. User Participations [All required]
	- All users can create their own auctions. An auction should include the product details with picture(s), start time/date, end time/date, start price.
	- Users can browse available active auctions
	- Users can search auctions
	- Users can view auctions details
	- Users can participate in auctions by bidding. Only valid bidding can beaccepted by entering new bid > current bid.
	- The auction should be controlled by date and time, user can only bid while the action is active. The highest bidder will win the auction.
	- Users can views a history of all the auctions won with auction details.
	- When the auction ends, the owner can mark it as complete or failed.
	- The auction owner can edit all failed auctions (no participations or the buyer didn’t complete the buying process) when it’s ended, and republish it again.
4. User additional functionalities
[Required for team of 4 or 5, bonus for team of 3]
	- User, who won the auction, can privately communicate with the
	auction owner through the website messaging system and vice versa.
	- All user can send public general questions for active auctions and the
	auction owner can respond publicly.
	- User, who won the auction, can rate (stars rating) the auction owner
	through the website rating system and vice-verse. This can be done one
	time only by the user for each auction won. Each user will have two
	separate ratings, one as buyer rating and the second as seller rating.


### Your system should display overall/cumulative rating (no individual rating is required)

#### Note: All form Inputs should be Validated using regular expressions for all the
functions you have implemented.

### MAIN PROGRAMMING TOOLS:
Assume the website will live on an Apache server so it can only be implemented in
PHP, HTML\CSS and or JavaScript along with the use of MYSQL database.

## GRADING:
Your web-application implementation must show that you are able to decide which
technology (HTML, CSS, JavaScript, PHP, Databases) to use for each website function.

For Example, Client-Side scripts should be used for input validation while Server-Side
scripts should be used for processing user data.

Basically, the grade will be divided into the following areas:

    1. Implementation: The level of complexity and the number of the functions you implement using PHP, files, or database and/or JavaScript (65%).
    
    2. The aesthetic design, the usability of your Website using HTML or/and CSS (15%). All pages should have unified design.
    
    3. Web Hosting: uploading your complete website online and make sure all functionalities are working - (10%).
    
    4. Final submission: (complete code/DB + One Page Instructions) - (10%) for
    completeness, clarity and submission on time.
        a. The instruction should include the following:
            i. Team members details (Student ID, Name and Section)
            ii. Online URL
            iii. Instructions to access your system (usernames/passwords of existing users for testing purposes)
            iv. Instructions to setup your submitted code/DB in local computer.
            
## Deadline for Submission is on Sunday, 13th December 2020

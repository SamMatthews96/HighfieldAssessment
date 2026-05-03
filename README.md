This is my submission for the Highfield technical assessment.

This project consists of a web app that features a form, where a user can enter 
category, min_price and max_price. Upon submit, the page redirects to a page that 
displays the results of the search as json.

I ran the script with the command "php -S localhost:80".
The form is viewable at http://localhost:80/index.php.
The script to filter the courses is at http://localhost:80/courses.php.

Accepted parameters are:
* category: string
* min_price: numeric
* max_price: numeric

Any unexcepted parameters will return an error message.
Any parameters of the wrong type will return an error message.

Example usage:
/courses.php?category=safety&min_price=30&max_price=100

What I'd do with more time
* Generally speaking, in a real-life situation, I'd ask questions to better understand
the context, to understand exactly what problem I'm trying to solve.
* Display the results in the page, in a more readable format, perhaps as a table.
* Style the form to make it more appealing.
* More advanced filters, for example, keywords in the course name: e.g. The form
could include a "course name" field, such that when a user enters "Health", the 
"Health & Safety" course is displayed.
* Real-time filtering: if I entered a value, the page could display the results 
after a short delay (300-500ms), though server performance would have to be considered.
* If I was working with a larger dataset and displaying results in page, pagination might
be necessary.

Assumptions
* The dataset is small and static, hence a json file is an acceptable format.
* The response can be displayed on a separate page.
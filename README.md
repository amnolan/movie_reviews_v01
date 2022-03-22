# movie_reviews_v01
A dynamic version of the static spoof of Rotten Tomatoes.

This site allows visits to different movie reviews using PHP, HTML and CSS. The largest challenge of course was styling with a close second of array mapping.

I was given an image of what the site should look like, the review text and the movie description text and images, and asked to match it exactly. This PHP webpage is the result of that exercise.

The basic idea is that you have several different movies which are stored in text files. Upon request, the app matches the request params with the requested movie title, which is looks up from a file and then loads the data into the UI dynamically. It does not require a database or database connection. The application should be able to run with everything provided in this project.

The core logic for the simple web app is contained in [movie.php](../master/movie.php).
The styling is contained in [movie.css](../master/movie.css).

Below is an example of navigating to `http://localhost:8080/movie.php?film=princessbride`

![Search](https://github.com/amnolan/movie_reviews_v01/blob/master/screenshot_of_page.png)


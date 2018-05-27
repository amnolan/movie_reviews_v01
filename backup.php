<?php
	$request_uri = $_GET['film'];

	# used to create the absolute uri
	$base_uri = "http://$_SERVER[HTTP_HOST]";

	$film_name = $request_uri;
	$working_dir = getcwd();
	$file = "${working_dir}/${film_name}/info.txt";
	$title = file("${working_dir}/${film_name}/info.txt");
	$title_disp = map_title($title);
	$overall_freshness = tomato_overall_disp($title_disp['score']);

	$title_names = array("title", "year", "score", "total_reviews");;
	$film_detail;
	
	function map_title( $ra ){
		# remove excess whitespace and give the array indicies meaningful names
		# otherwise you must reference by number, this is not a good pattern
		$ra['title'] = trim($ra[0]);
		$ra['year'] = trim($ra[1]);
		$ra['score'] = trim($ra[2]);
		$ra['total_reviews'] = trim($ra[3]);
		return $ra;
	}

	function map_array_to_hash($ra, $names_ra){
		for( $i = 0; i < count($ra); $i++ ){
			$map_ra[$names_ra[$i]] = $ra[$i];
			print($map_ra[$names_ra[$i]]);
		}
		return $map_ra;
	}

	map_array_to_hash( $title, $title_names);

	function map_film_detail( $ra ){

	}

	function tomato_overall_disp($score){
		return ( $score > 60 ? "fresh" : "rotten");
	}

?>


<!DOCTYPE html>
<html>
	<head>

		<title>TMNT - Rancid Tomatoes</title>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="movie.css" type="text/css" rel="stylesheet" />
        
        <link rel="icon" 
            type="image/png" 
            href="http://YOUR_SITE_HERE/rotten.gif" />
	</head>

	<body id="page_body" class="general_text">
	    <div id="banner" >
			<img class="center_x" src="http://YOUR_SITE_HERE/banner.png" alt="Rancid Tomatoes" />
		</div>

		<h1 id="title" class="center_x_text"><?= $title_disp['title']?> (<?= $title_disp['year']?>)</h1>
		
        <div id="inner_body" class="center_x">
            <div class="right_column movie_info">
                <div>
                    <img <?="src=\"${film_name}/overview.png\""?> alt="general overview" />
                </div>

                <dl>
                    <dt>STARRING</dt>
                    <dd>Patrick Stewart <br /> Mako <br /> Sarah Michelle Gellar <br /> Kevin Smith</dd>

                    <dt>DIRECTOR</dt>
                    <dd>Kevin Munroe</dd>

                    <dt>RATING</dt>
                    <dd>PG</dd>

                    <dt>THEATRICAL RELEASE</dt>
                    <dd>Mar 23, 2007</dd>

                    <dt>MOVIE SYNOPSIS</dt>
                    <dd>After the defeat of their old arch nemesis, The Shredder, the Turtles have grown apart as a family.</dd>

                    <dt>MPAA RATING</dt>
                    <dd>PG, for animated action violence, some scary cartoon images and mild language</dd>

                    <dt>RELEASE COMPANY</dt>
                    <dd>Warner Bros.</dd>

                    <dt>RUNTIME</dt>
                    <dd>90 mins</dd>

                    <dt>GENRE</dt>
                    <dd>Action/Adventure, Comedies, Childrens, Martial Arts, Superheroes, Ninjas, Animated Characters</dd>

                    <dt>BOX OFFICE</dt>
                    <dd>$54,132,596</dd>

                    <dt>LINKS</dt>
                    <dd>
                        <ul>
                            <li><a href="http://www.rottentomatoes.com/m/teenage_mutant_ninja_turtles/">RT Review</a></li>
                            <li><a href="http://www.rottentomatoes.com/">RT Home</a></li>
                        </ul>
                    </dd>
                </dl>
            </div>

            <div>
                <!-- The rating bar: at the top, used to display the total aggregate score. -->
                <div id="rating_header">
                    <img <?="src=\"${base_uri}/${overall_freshness}big.png\""?> alt=<?="\"$overall_freshness\""?> />
                    <span class="stinker_font"><?=$title_disp['score']?>%</span>
                    <span class="reviews_total general_text">(<?=$title_disp['total_reviews']?> reviews total)</span>
                </div>
                
                <div class="columns general_text">
                    <div class="column">
                        <div class="spacing_bottom overflow">
                            <p class="comments overflow">
                                <img src="http://YOUR_SITE_HERE/rotten.gif" alt="Rotten" class="icons"/>
                                <q>Ditching the cheeky, self-aware wink that helped to excuse the concept's inherent corniness, the movie attempts to look polished and 'cool,' but the been-there animation can't compete with the then-cutting-edge puppetry of the 1990 live-action movie.</q>
                            </p>
                            <p >
                                <img src="http://YOUR_SITE_HERE/critic.gif" alt="Critic" class="reviewer_icon"/>
                                Peter Debruge <br />
                                <span class="publication">Variety</span>
                            </p>
                        </div>
                        <div class="spacing_bottom overflow">
                            <p class="comments overflow">
                                <img src="http://YOUR_SITE_HERE/fresh.gif" alt="Fresh" class="icons" />
                                <q>TMNT is a fun, action-filled adventure that will satisfy longtime fans and generate a legion of new ones.</q>
                            </p>
                            <p>
                                <img src="http://YOUR_SITE_HERE/critic.gif" alt="Critic" class="reviewer_icon"/>
                                Todd Gilchrist <br />
                                <span class="publication">IGN Movies</span>
                            </p>
                        </div>
                        <div class="spacing_bottom">
                            <p class="comments overflow">
                                <img src="http://YOUR_SITE_HERE/rotten.gif" alt="Rotten" class="icons"/>
                                <q>It stinks!</q>
                            </p>
                            <p>
                                <img src="http://YOUR_SITE_HERE/critic.gif" alt="Critic" class="reviewer_icon"/>
                                Jay Sherman (unemployed)
                            </p>
                        </div>
                        <div class="spacing_bottom overflow">
                            <p class="comments overflow">
                                <img src="http://YOUR_SITE_HERE/rotten.gif" alt="Rotten" class="icons"/>
                                <q>The rubber suits are gone and they've been redone with fancy computer technology, but that hasn't stopped them from becoming dull.</q>
                            </p>
                            <p>
                                <img src="http://YOUR_SITE_HERE/critic.gif" alt="Critic" class="reviewer_icon"/>
                                Joshua Tyler <br />
                                <span class="publication">CinemaBlend.com</span>
                            </p>
                        </div>
                        <div class="spacing_bottom overflow">
                            <p class="comments overflow">
                                <img src="http://YOUR_SITE_HERE/rotten.gif" alt="Rotten" class="icons"/>
                                <q >YOUR REVIEW HERE</q>
                            </p>
                            <p>
                                <img src="http://YOUR_SITE_HERE/critic.gif" alt="Critic" class="reviewer_icon"/>
                                NAME <br />
                                <span class="publication">PUBLICATION</span>
                            </p>
                        </div>
                    </div>
                    <div class="column">
                        <div class="spacing_bottom overflow">
                            <p class="comments overflow">
                                <img src="http://YOUR_SITE_HERE/rotten.gif" alt="Rotten" class="icons"/>
                                <q>The turtles themselves may look prettier, but are no smarter; torn irreparably from their countercultural roots, our superheroes on the half shell have been firmly co-opted by the industry their creators once sought to spoof.</q>
                            </p>
                            <p>
                                <img src="http://YOUR_SITE_HERE/critic.gif" alt="Critic" class="reviewer_icon"/>
                                Jeannette Catsoulis <br />
                                <span class="publication">New York Times</span>
                            </p>
                        </div>
                        <div class="spacing_bottom overflow">
                            <p class="comments overflow">
                                <img src="http://YOUR_SITE_HERE/rotten.gif" alt="Rotten" class="icons"/>
                                <q>Impersonally animated and arbitrarily plotted, the story appears to have been made up as the filmmakers went along.</q>
                            </p>
                            <p>
                                <img src="http://YOUR_SITE_HERE/critic.gif" alt="Critic" class="reviewer_icon"/>
                                Ed Gonzalez <br />
                                <span class="publication">Slant Magazine</span>
                            </p>
                        </div>
                        <div class="spacing_bottom overflow">
                            <p class="comments overflow">
                                <img src="http://YOUR_SITE_HERE/fresh.gif" alt="Fresh" class="icons"/>
                                <q>The striking use of image and motion allows each sequence to leave an impression. It's an accomplished restart to this franchise.</q>
                            </p>
                            <p>
                                <img src="http://YOUR_SITE_HERE/critic.gif" alt="Critic" class="reviewer_icon"/>
                                Mark Palermo <br />
                                <span class="publication">Coast (Halifax, Nova Scotia)</span>
                            </p>
                        </div>
                        <div class="spacing_bottom overflow">
                            <p class="comments overflow">
                                <img src="http://YOUR_SITE_HERE/rotten.gif" alt="Rotten" class="icons"/>
                                <q>The script feels like it was computer generated. This mechanical presentation lacks the cheesy charm of the three live action films.</q>
                            </p>
                            <p>
                                <img src="http://YOUR_SITE_HERE/critic.gif" alt="Critic" class="reviewer_icon"/>
                                Steve Rhodes <br />
                                <span class="publication">Internet Reviews</span>
                            </p>
                        </div>
                        <div class="spacing_bottom overflow">
                            <p class="comments overflow">
                                <img src="http://YOUR_SITE_HERE/rotten.gif" alt="Rotten" class="icons"/>
                                <q>YOUR REVIEW HERE</q>
                            </p>
                            <p>
                                <img src="http://YOUR_SITE_HERE/critic.gif" alt="Critic" class="reviewer_icon"/>
                                NAME <br />
                                <span class="publication">PUBLICATION</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <p class="after general_text" id="reviewNumBot">(1-10) of 88</p>
        </div>
	</body>
</html>



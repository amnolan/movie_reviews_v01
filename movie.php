<?php
	# figure out what the user is trying to view
	$request_uri = $_GET['film'];
	# used to create the absolute uri and for looking up the film
	$film_name = $request_uri;
	# get the file path to enable the ability look up files
	$working_dir = getcwd();
	# set the base path for the current film being viewed
	$base_path = "${working_dir}/${film_name}";

	# get info file for film
	$file = "${base_path}/info.txt";
	$title = file( "${base_path}/info.txt" );

	$link_title_underscore = strtolower( str_replace(" ", "_", $title[0]) );

	# get the overview file
	$film = file( "${base_path}/overview.txt" );

	$dir_list = scandir( "${base_path}/" );
	# set the base static url for images
	$hw2_uri = "http://YOUR_SITE_HERE/hw2/";

	# get review file path and assign them to an array variable
	$review_names = get_items_matching_sub_str( $dir_list, "review" );
	$reviews = array_of_files( $review_names , $base_path );
	# set up hashmaps to make referencing them more pratical and human-readable in the php - html below
	# only works where data is in a fixed order - for instance
	$title_names = array( 'title', 'year', 'score', 'total_reviews' );
	$review_names = array( 'content','freshness','name','subname' );

	# convert to a mapped array
	$title_disp = map_array_to_hash( $title, $title_names );
	$review_temp = get_files( $reviews );
	# the objects are now ready for rendering
	$review_final_mapped = map_2d_array_to_hash(  $review_temp, $review_names );
	$overall_freshness = strtolower( tomato_overall_disp( $title_disp['score'] ) );

?>

<!DOCTYPE html>
<html>
	<head>
		<title><?= $title_disp['title']?> - Rancid Tomatoes</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="movie.css" type="text/css" rel="stylesheet" />
        <link rel="icon" 
            type="image/png" 
            <?="href=\"http://YOUR_SITE_HERE${overall_freshness}.gif\""?> />
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
                	<?php foreach ( $film as $key => $value ) { 
            	 	   	$row_item = explode( ':',$value );
            	 	   	?>
	                   	<dt><?=get_film_detail_header_disp( $row_item[0] )?></dt>
                    	<dd><?=lb_toggle_html( $row_item[1] )?></dd>
                	<?php } ?> <!-- end foreach -->
                    <dt>LINKS</dt>
                    <dd>
                        <ul>
                            <li>
                            	<!-- 
                            		Dyamically change the rotten tomatoes link as well to link to the predicted url
									This is highly likely to break if you have a large number of films with variable titles.
									Unless it is provided in a file, db or a webservice.
                            	-->
                            	<a <?="href=\"http://www.rottentomatoes.com/m/${link_title_underscore}\""?> alt="RT Review">RT Review</a>
                        	</li>
                            <li><a href="http://www.rottentomatoes.com/">RT Home</a></li>
                        </ul>
                    </dd>
                </dl>
            </div>

            <div>
                <!-- The rating bar: at the top, used to display the total aggregate score. -->
                <div id="rating_header">
                    <img <?="src=\"${hw2_uri}${overall_freshness}big.png\""?> alt=<?="\"$overall_freshness\""?> />
                    <span class="stinker_font"><?=$title_disp['score']?>%</span>
                    <span class="reviews_total general_text">(<?=$title_disp['total_reviews']?> reviews total)</span>
                </div>
                
                <!-- This is the first column on the left where the reviews begin showing -->
                <div class="columns general_text">
				<div class="column">
	                <?php for( $i = 0; $i < count( $review_final_mapped ); $i++ ) {
	                	$freshness = strtolower( $review_final_mapped[$i]['freshness'] );
	                	$cutoff = (int)( count( $review_final_mapped ) / 2 );
						;?>
						<div class="spacing_bottom overflow">
							<p class="comments overflow">
								<img <?="src=\"${hw2_uri}${freshness}.gif\""?> alt=<?="\"$freshness\" class=\"icons\""?> />
	                            <q><?=$review_final_mapped[$i]['content']?></q>
	                        </p>
	                        <p>
	                            <img src="http://wYOUR_SITE_HERE/critic.gif" alt="Critic" class="reviewer_icon"/>
	                            <?=$review_final_mapped[$i]['name']?><br />
	                            <span class="publication"><?=$review_final_mapped[$i]['subname']?></span>
	                        </p>
	                    </div>
		               <?php
						# this handles the even - odd requirement.
		               	if( $i == $cutoff - 1 ){?>
		               		</div>
		               		<div class="column">

		           	  <?php }?><!-- end if -->

					<?php } ?><!-- end for -->

						</div>  
                    </div>
                </div>
                <p class="after general_text" id="reviewNumBot">(1-<?=count($review_final_mapped)?>) of 88</p>
            </div>
        </div>
	</body>
</html>
<?php
	# helper methods

	# maps array to a hash which allows for human-readable array references rather than numeric
	function map_array_to_hash( $ra, $names_ra ){
		$mapped_ra = array();
		for( $i = 0; $i < count( $ra ); $i++ ) {
			$mapped_ra[$names_ra[$i]] = trim( $ra[$i] );
         }
		return $mapped_ra;
	}

	# for arrays of arrays although the names are not generic, it is a generic method logic-wise
	function map_2d_array_to_hash( $review_temp, $review_names ){
		$review_final_mapped = array();
		foreach ( $review_temp as $key => $curr_review ) {
			$mapped_rev = map_array_to_hash( $curr_review, $review_names );
			array_push( $review_final_mapped, $mapped_rev );
		}
		return $review_final_mapped;
	}

	# takes a comma separated string and sets them up to display as newline
	function lb_toggle_html( $str ){
		$tmp = str_replace( ",", "\n", $str );
		$tmp = nl2br( $tmp );
		return $tmp;
	}

	# helps with str manipulations, breaks apart the right hand column contents to make display simpler
	function get_film_detail_header_disp( $ra ){
   		$res = explode( ':',$ra );
   		return $res[0];
	}

	# use this to search the file directory
	function get_items_matching_sub_str( $files_in_dir, $sought ){
		$files_to_return = array();
		foreach ( $files_in_dir as $key => $f ) {
			if( strlen( strstr( $f,$sought) ) > 0 ){
				array_push( $files_to_return, $f );
			}
		}
		return $files_to_return;
	}

	# gets the array of file paths
	function array_of_files( $file_list, $folder ){
		$ret_files = array();
		for( $j = 0; $j < count( $file_list ); $j++ ){
			$tmp = $file_list[$j];
			$curr_file_path = "${folder}/${tmp}";
			array_push( $ret_files, $curr_file_path );
		}
		return $ret_files;
	}

	# gets the files
	function get_files( $ra ){
		$ret_files = array();
		for( $j = 0; $j < count( $ra ); $j++ ){
			$curr_file = file( $ra[$j] );
			array_push( $ret_files, $curr_file );
		}
		return $ret_files;
	}

	# perhaps too simple for a function but I like to keep logic separate in case it can be reused
	function tomato_overall_disp( $score ){
		return ( $score > 60 ? "fresh" : "rotten" );
	}
?>
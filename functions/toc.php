<?php

// TOC 代码来自 https://jeroensormani.com/automatically-add-ids-to-your-headings/
function get_toc($content) {
	// get headlines
	$headings = get_headings($content, 1, 6);

	// parse toc
	ob_start();
	echo "<div class='table-of-contents container-sm mb-5'>";
	echo "<div class='toc-header'><span class='toc-headline'>目录</span>";
	echo "<!-- Table of contents by webdeasy.de -->";
	echo "<span class='toggle-toc custom-setting' title='collapse'> [折叠]</span></div>";
	parse_toc($headings, 0, 0);
	echo "</div>";
	return ob_get_clean();
}

function parse_toc($headings, $index, $recursive_counter) {
	// prevent errors

	if($recursive_counter > 60 || !count($headings)) return;

	// get all needed elements
	$last_element = $index > 0 ? $headings[$index - 1] : NULL;
	$current_element = $headings[$index];
	$next_element = NULL;
	if($index < count($headings) && isset($headings[$index + 1])) {
		$next_element = $headings[$index + 1];
	}

	// end recursive calls
	if($current_element == NULL) return;

	// get all needed variables
	$tag = intval($headings[$index]["tag"]);
	$id = $headings[$index]["id"];
	$classes = isset($headings[$index]["classes"]) ? $headings[$index]["classes"] : array();
	$name = $headings[$index]["name"];

	// element not in toc
	if(isset($current_element["classes"]) && $current_element["classes"] && in_array("nitoc", $current_element["classes"])) {
		parse_toc($headings, $index + 1, $recursive_counter + 1);
		return;
	}

	// parse toc begin or toc subpart begin
	if($last_element == NULL) echo "<ul>";
	if($last_element != NULL && $last_element["tag"] < $tag) {
		for($i = 0; $i < $tag - $last_element["tag"]; $i++) {
			echo "<ul>";
		}
	}

	// build li class
	$li_classes = "";
	if(isset($current_element["classes"]) && $current_element["classes"] && in_array("toc-bold", $current_element["classes"])) $li_classes = " class='bold'";

	// parse line begin
	echo "<li" . $li_classes .">";

	// only parse name, when li is not bold
	if(isset($current_element["classes"]) && $current_element["classes"] && in_array("toc-bold", $current_element["classes"])) {
		echo $name;
	} else {
		echo "<a href='#" . $id . "'>" . $name . "</a>";
	}
	if($next_element && intval($next_element["tag"]) > $tag) {
		parse_toc($headings, $index + 1, $recursive_counter + 1);
	}

	// parse line end
	echo "</li>";

	// parse next line
	if($next_element && intval($next_element["tag"]) == $tag) {
		parse_toc($headings, $index + 1, $recursive_counter + 1);
	}

	// parse toc end or toc subpart end
	if ($next_element == NULL || ($next_element && $next_element["tag"] < $tag)) {
		echo "</ul>";
		if ($next_element && $tag - intval($next_element["tag"]) >= 2) {
			echo "</li>";
			for($i = 1; $i < $tag - intval($next_element["tag"]); $i++) {
				echo "</ul>";
			}
		}
	}

	// parse top subpart
	if($next_element != NULL && $next_element["tag"] < $tag) {
		parse_toc($headings, $index + 1, $recursive_counter + 1);
	}
}

function get_headings($content, $from_tag = 1, $to_tag = 6) {
	$headings = array();
	preg_match_all("/<h([" . $from_tag . "-" . $to_tag . "])([^<]*)>(.*)<\/h[" . $from_tag . "-" . $to_tag . "]>/", $content, $matches);

	for($i = 0; $i < count($matches[1]); $i++) {
		$headings[$i]["tag"] = $matches[1][$i];
		// get id
		$att_string = $matches[2][$i];
		preg_match("/id=\"([^\"]*)\"/", $att_string , $id_matches);
		$headings[$i]["id"] = $id_matches[1];
		// get classes
		$att_string = $matches[2][$i];
		preg_match_all("/class=\"([^\"]*)\"/", $att_string , $class_matches);
		for($j = 0; $j < count($class_matches[1]); $j++) {
			$headings[$i]["classes"] = explode(" ", $class_matches[1][$j]);
		}
		$headings[$i]["name"] = strip_tags($matches[3][$i]);
	}
	return $headings;
}

function add_table_of_content($content) {
	if (!is_single()) return $content;
	$paragraphs = explode("</p>", $content);
	$paragraphs_count = count($paragraphs);
	$middle_index= absint(floor($paragraphs_count / 2));
	$new_content = '';
	for ($i = 0; $i < $paragraphs_count; $i++) {
		if ($i === 0) {
			$new_content .= get_toc($content);
		}
		$new_content .= $paragraphs[$i] . "</p>";
	}
	return $new_content;
}

// 为标题自动添加 ID
function auto_id_headings( $content ) {
	$content = preg_replace_callback( '/(\<h[1-6](.*?))\>(.*)(<\/h[1-6]>)/i', function( $matches ) {
		if ( ! stripos( $matches[0], 'id=' ) ) :
			$matches[0] = $matches[1] . $matches[2] . ' id="' . sanitize_title( $matches[3] ) . '">' . $matches[3] . $matches[4];
		endif;
		return $matches[0];
	}, $content );

	return $content;

}

add_filter( 'the_content', 'auto_id_headings' );
add_filter('the_content', 'add_table_of_content');
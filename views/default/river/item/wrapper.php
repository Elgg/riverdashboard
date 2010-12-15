<?php
/**
 * Elgg river item wrapper.
 * Wraps all river items.
 *
 * @todo: Clean up this logic.
 * It looks like this only will allow comments on non user and non group forum
 * topic entities.
 *
 * Different chunks are used depending on if comments exist or not.
 *
 *
 */

$object = get_entity($vars['item']->object_guid);
$object_url = $object->getURL();
$likes_count = elgg_count_likes($object);

//user
//if displaying on the profile get the object owner, else the subject_guid
if (elgg_get_context() == 'profile' && $object->getSubtype() ==  'thewire') {
	$user = get_entity($object->owner_guid);
} else {
	$user = get_entity($vars['item']->subject_guid);
}

// get last three comments display
// want the 3 most recent comments (order by time_created desc = 3 2 1 limit 3)
// but will display them with the newest at the bottom (1 2 3)
if ($comments = get_annotations($vars['item']->object_guid, "", "", 'generic_comment', "", "", 3, 0, "desc")) {
	$comments = array_reverse($comments);
}

// for displaying "+N more"
// -3 from the count because the 3 displayed don't count in the "more"
$comment_count = count_annotations($vars['item']->object_guid, $vars['item']->type, $vars['item']->subtype, 'generic_comment');
if ($comment_count < 3) {
	$more_comments_count = 0;
} else {
	$more_comments_count = $comment_count - 3;
}

?>
<div class="river-item riverdashboard" id="river_entity_<?php echo $object->guid; ?>">
	<span class="river-item-useravatar">
		<?php echo elgg_view("profile/icon",array('entity' => $user, 'size' => 'small')); ?>
	</span>

	<div class="river-item-contents clearfix">
<?php

// body contents, generated by the river view in each plugin
echo $vars['body'];

// display latest 3 comments if there are any
if ($comments){
	$counter = 0;

	echo "<div class='river-comments-tabs clearfix'>";
	echo "<a class='river-more-comments show_comments_button link'>" . elgg_echo('comments') . '</a>';

	if ($likes_count != 0) {
		echo elgg_view('forms/likes/display', array('entity' => $object));
	}

	echo "</div>"; // close river-comments-tabs

	echo "<div class='river-comments'>";

	if ($likes_count != 0) {
		//show the users who liked the object
		// this is loaded via ajax to avoid pounding the server with avatar requests.
		echo "<div class='likes-list hidden'></div>";
	}

	echo "<div class=\"comments_container\">";
	// display appropriate comment link
	if ($more_comments_count > 0) {
		echo "<a class=\"river-more-comments show_more_button link\">" .
		elgg_echo('riverdashboard:n_more_comments', array($more_comments_count)) . '</a>';

		echo "<a style=\"display: none\" class=\"river-more-comments show_less_button link\">" . elgg_echo('riverdashboard:show_less') . '</a>';
	}
	echo "<div class=\"comments_list\">";
	foreach ($comments as $comment) {
		//get the comment owner
		$comment_owner = get_user($comment->owner_guid);
		//get the comment owner's profile url
		$comment_owner_url = $comment_owner->getURL();
		// color-code each of the 3 comments
		// @todo this isn't used in CSS...
		if( ($counter == 2 && $comment_count >= 4) || ($counter == 1 && $comment_count == 2) || ($counter == 0 && $comment_count == 1) || ($counter == 2 && $comment_count == 3) ) {
			$alt = 'latest';
		} else if( ($counter == 1 && $comment_count >= 4) || ($counter == 0 && $comment_count == 2) || ($counter == 1 && $comment_count == 3) ) {
			$alt = 'penultimate';
		}
		//display comment
		echo "<div class='river-comment $alt clearfix'>";
		echo "<span class='river-comment-owner-icon'>";
		echo elgg_view("profile/icon", array('entity' => $comment_owner, 'size' => 'tiny'));
		echo "</span>";

		//truncate comment to 150 characters and strip tags
		$contents = elgg_get_excerpt($comment->value, 150);

		echo "<div class='river-comment-contents'>";
		echo "<a href=\"{$comment_owner_url}\">" . $comment_owner->name . '</a>&nbsp;<span class="elgg_excerpt">' . parse_urls($contents) . '</span>';
		echo "<span class='entity-subtext'>" . elgg_view_friendly_time($comment->time_created) . "</span>";
		echo "</div></div>";
		$counter++;
	}

	// close comments_list, comments_container and river-comments
	echo '</div></div>' . elgg_make_river_comment($object) . '</div>';
} else {
	// tab bar nav - for users that liked object
	if ($vars['item']->type != 'user' && $likes_count != 0) {
		echo "<div class='river-comments-tabs clearfix'>";
	}

	if ($likes_count != 0) {
		echo elgg_view('forms/likes/display', array('entity' => $object));
	}

	if ($vars['item']->type != 'user' && $likes_count != 0) {
		echo "</div>"; // close river-comments-tabs
	}

	if ($vars['item']->type != 'user') {
		echo "<div class='river-comments'>";
	}
	if ($likes_count != 0) {
		//show the users who liked the object
		echo "<div class='likes-list hidden'>";
		echo list_annotations($object->getGUID(), 'likes', 99);
		echo "</div>";
	}

	// if there are no comments to display
	// and this is not a user - include the inline comment form
	if ($vars['item']->type != 'user') {
		echo elgg_make_river_comment($object);
	}
	if ($vars['item']->type != 'user') {
		echo "</div>";
	}
}
?>
	</div>
</div>

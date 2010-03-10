<?php
/**
 * Elgg river item wrapper.
 * Wraps all river items.
 */

//set required variables
$object = get_entity($vars['item']->object_guid);
//get object url
$object_url = $object->getURL();
//user
//if displaying on the profile get the object owner, else the subject_guid
if(get_context() == 'profile' && $object->getSubtype() ==  'thewire')
	$user = get_entity($object->owner_guid);
else
	$user = get_entity($vars['item']->subject_guid);

//get the right annotation type
//*todo - use the same for comments, everywhere e.g. comment
switch($vars['item']->subtype){
	case 'thewire':
	$annotation_comment = 'wire_reply';
	break;
	default:
	$annotation_comment = 'generic_comment';
	break;
}

//count comment annotations
$comment_count = count_annotations($vars['item']->object_guid, $vars['item']->type, $vars['item']->subtype, $annotation_comment);

//count like annotations
$likes = count_annotations($vars['item']->object_guid, $vars['item']->type, $vars['item']->subtype, "likes");

//get last two comments display
$get_comments = get_annotations($vars['item']->object_guid, "", "", $annotation_comment, "", "", 3, 0, "desc");

if($get_comments){
	//reverse the array so we can display comments in the right order
	$get_comments = array_reverse($get_comments);	
}

//minus two off the comment total as we display two by default
if($comment_count < 3)
	$num_comments = 0;
else
	$num_comments = $comment_count - 3;
?>
<div class="river_item">
	<!-- avatar -->
	<span class="river_item_useravatar" style="float:left;margin:0 10px 10px 0;">
		<?php
			echo elgg_view("profile/icon",array('entity' => $user, 'size' => 'small'));
		?>
	</span>
	<!-- body contents, generated by the river view in each plugin -->
	<?php
		echo $vars['body'];
	?>
	<div class="clearfloat"></div>
	<!-- display comments and likes if on  the dashboard/live feed -->
	<div class="river_item_annotation">
		<?php
			//display the number of comments and likes if there are any
			if($num_comments != 0){
				echo "<div class='river_more_comments'><span class='more_comments'>";
				//set the correct context comment or comments
				if($num_comments == 1)
					echo "<a href=\"{$object_url}\">+{$num_comments} more comment</a>";
				else
					echo "<a href=\"{$object_url}\">+{$num_comments} more comments</a>";
					
				echo "</span></div>";	
			}
			//display latest 2 comments if there are any
			if($get_comments){
				$counter = 0;
				$background = "";
				echo "<div class='river_comments'>";
				foreach($get_comments as $gc){
					//get the comment owner
					$comment_owner = get_user($gc->owner_guid);
					//get the comment owner's profile url
					$comment_owner_url = $comment_owner->getURL();
					// color-code each of the 3 comments
					if( ($counter == 2 && $comment_count >= 4) || ($counter == 1 && $comment_count == 2) || ($counter == 0 && $comment_count == 1) || ($counter == 2 && $comment_count == 3) )
						$alt = 'latest';
					else if( ($counter == 1 && $comment_count >= 4) || ($counter == 0 && $comment_count == 2) || ($counter == 1 && $comment_count == 3) )
						$alt = 'penultimate';
					
					//display comment
					echo "<div class='river_comment {$alt}'>";
					echo "<div class='river_comment_owner_icon'>";
					echo elgg_view("profile/icon",array('entity' => $comment_owner, 'size' => 'tiny'));
					echo "</div>";
					//truncate comment to 150 characters
					if(strlen($gc->value) > 150) {
				        	$gc->value = substr($gc->value, 0, strpos($gc->value, ' ', 150)) . "...";
				    }
					$contents = strip_tags($gc->value);
				    echo "<div class='comment_wrapper'>";
					echo "<a href=\"{$comment_owner_url}\">" . $comment_owner->name . "</a> " . parse_urls($contents);
					echo "<br /><span class='river_item_time'>" . friendly_time($gc->time_created) . "</span>";
					echo "<div class=\"clearfloat\"></div>";
					echo "</div></div>";
					$counter++;
				}
				echo "</div>";
			}
			//display the comment link
			if($vars['item']->type != 'user'){
				//for now don't display the comment link on bookmarks and wire messages
				if($vars['item']->subtype != 'thewire' && $vars['item']->subtype != 'bookmarks' && $vars['item']->subtype != '')
					echo "<span class='comment_link'><a href=\"{$object_url}\">Comment</a></span>";
			}
		?>
	</div>
	<div class="clearfloat"></div>
</div>
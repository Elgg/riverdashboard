<?php
/**
 * Elgg riverdashboard CSS
 * 
 */
?>
#riverdashboard_updates {
	border-bottom:1px solid #cccccc;
}
#riverdashboard_updates a.update_link {
	display: inline-table;
	color:white;
	font-weight: bold;
	padding:1px 8px 2px 24px;
	margin-top:9px;
    cursor: pointer;
	background: red url("<?php echo $vars['url']; ?>mod/riverdashboard/graphics/refresh.png") no-repeat 5px 3px;
    -webkit-border-radius: 10px; 
    -moz-border-radius: 10px;    
}
#riverdashboard_updates a.update_link:hover {
	background: #4690D6 url("<?php echo $vars['url']; ?>mod/riverdashboard/graphics/refresh.png") no-repeat 5px -22px;
	color:white;
	text-decoration: none;
}
.riverdashboard_filtermenu {
	margin:10px 0 10px 0;
	float:right;
}

/* RIVER ENTRY */
.river_item {
	border-bottom:1px solid #cccccc;
	padding:7px 0 7px 0;
}
.river_item p {
	margin:0;
}
.river_item .entity_subtext {
	padding-left:5px;
	padding-right:5px;
	font-size:85%;
}
.river_item_useravatar {
	float:left;
	margin-top:3px;
	margin-left:1px;
}
.river_item_contents {
	margin-left:55px;
}
.river_content_display {
	border-left:1px solid #DDDDDD;
	font-size:85%;
	line-height:1.5em;
	margin:8px 0 5px 0;
	padding-left:5px;
}
.following_icon {
	width:20px;
	height:25px;
	margin:0 2px 0 2px;
	background: url(<?php echo $vars['url']; ?>mod/riverdashboard/graphics/follow_icon.png) no-repeat left -7px;
}

/* LATEST COMMENTS IN RIVER */
.river_comments_tabs {
	max-height: 19px;
	overflow:hidden;
}
.river_comments {
	-moz-border-radius-bottomleft:5px;
	-moz-border-radius-bottomright:5px;
	-moz-border-radius-topleft:5px;
	-moz-border-radius-topright:0;
	-webkit-border-top-left-radius:5px;
	-webkit-border-top-right-radius:0;
	-webkit-border-bottom-right-radius:5px;
	-webkit-border-bottom-left-radius:5px; 
    background-color: #eeeeee;
}
.river_comment {
	padding:3px;
	border-bottom:1px solid white;	
}
.river_comment.penultimate {

}
.river_comment.latest {

}
/* hidden inline comment form */
.river_comment_form.hidden {
	padding:5px;	
}
.river_comment_form.hidden .input_text {
	width:560px;
	padding:3px;
}
.river_comment_form.hidden .submit_button {
	margin:0 0 0 10px;
	float:right;
}
.river_link_divider {
	color:#999999;
}
.river_comment_form_button,
.river_user_like_button {
	font-size:85%;
}
/* hidden list of users that liked item */
.river_item .elgg_likes_user {
	border-bottom:1px solid white;
	padding:3px;
}
.river_item .elgg_likes_user .entity_listing_icon {
	margin:3px 0 4px 2px;
}
.river_item .elgg_likes_user .entity_listing_info {
	width:635px;
}
.river_item .elgg_likes_user .entity_metadata {
	margin-top:3px;
}
.river_item p.elgg_likes_owner {
	padding-top:4px;
}
.river_item a.river_more_comments {
	display:block;
	float:right;
	padding:1px 7px 1px 7px;
	margin-left:6px;
	text-align:right;
	font-size:85%;
	width:auto;
	background-color: #eeeeee;
	-moz-border-radius-topleft:4px;
	-moz-border-radius-topright:4px;
	-webkit-border-top-left-radius:4px;
	-webkit-border-top-right-radius:4px;
}
.river_item a.river_more_comments.off {
	background-color: white;
}
.river_item .river_comment_owner_icon {
	float:left;
	margin:3px 8px 4px 2px;
}
.river_item .river_comment_contents {
	margin-left:34px;
}





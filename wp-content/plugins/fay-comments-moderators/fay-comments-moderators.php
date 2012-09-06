<?php
/*
 Plugin Name: WP Comments Moderators
 Plugin URI: http://faycaltirich.blogspot.com/1979/01/fay-comments-moderators-plugin.html
 Description: WP Comments Moderators plugin allows any user (whatever their Role) to moderate any blog comment.
 Version: 4.0.2
 Author: Fayçal Tirich
 Author URI: http://faycaltirich.blogspot.com
 */

$commentsModerators = new Fay_Comments_Moderators();
add_action('admin_menu', array(&$commentsModerators,'add_admin_menu'));
add_action('admin_head', array(&$commentsModerators,'hide_menu_for_subscribers'));
add_action('init', array(&$commentsModerators,'redirect_url_for_subscribers'));

class Fay_Comments_Moderators {

	private static $commentModerationCap = array(
										'moderate_comments',
										'edit_posts',
										'edit_others_posts',
										'edit_published_posts',
										'edit_pages',
										'edit_others_pages',
										'edit_published_pages',
	);
		
	public static function getUsers() {
		global $wp_roles;
		$wp_users = get_users();
		foreach($wp_users as $user) {
			$object = new stdClass();
			$object->ID = $user->ID;
			$object->user_login = $user->user_login;
			$object->display_name = $user->display_name;
			$object->user_email = $user->user_email;
			//
			$user_object = new WP_User($user->ID);
			if(isset($user_object->roles[0])){
				$object->role = $user_object->roles[0];
				$role_name = isset( $wp_roles->role_names[$object->role] ) ? translate_user_role( $wp_roles->role_names[$object->role] ) : __( 'None' );
				$object->role_name = $role_name;
			}
			$object->is_comments_moderator = false;
			$caps = self::$commentModerationCap;
			$checkAll = true;
			foreach($caps as $cap) {
				if(!$user_object->has_cap($cap)){
					$checkAll = false;
					break;
				}
			}
			if($checkAll){
				$object->is_comments_moderator = true;
			}
			$users[]=$object;
		}
		return $users;
	}


	function options_page() {
		$log = '';
		$users = self::getUsers();
		if ( isset($_POST['fcm_submit']) ) {
			$new_users_array = array();
			if(isset($_POST['fcm_users'])) {
				$new_users_array = $_POST['fcm_users'];
			}
			$caps = self::$commentModerationCap;
			foreach($users as $user) {
				if ($user->role!='administrator' && $user->role!='editor') {
					$user_object = new WP_User($user->ID);
					if (in_array($user->ID, $new_users_array)) {
						if (!$user->is_comments_moderator ) {
							foreach($caps as $cap) {
								$user_object->add_cap($cap);
							}
							$user->is_comments_moderator = true;
							$log = $log .'<span style="color:green">Moderation added to '.$user->display_name.'</span><br />';
						}
					} else {
						if ($user->is_comments_moderator ) {
							foreach($caps as $cap) {
								$user_object->remove_cap($cap);
							}
							$user->is_comments_moderator = false;
							$log = $log .'<span style="color:red">Moderation removed from '.$user->display_name.'</span><br />';
						}
					}
				}
			}
		}
		if(!empty($log)) {
			?>
			<!-- Last Action -->
			<div id="message" class="updated fade">
				<p>
				<?php echo $log; ?>
				</p>
			</div>
		<?php
		}
		?>
		<div class="wrap">
		<?php screen_icon(); ?>
			<h2>Comments Moderators</h2>
			<br />
			<?php include 'donate.php';?>
			<br />
			<form method="post" action="">
				<table class="widefat fixed" cellspacing="0">
					<thead>
						<tr class="thead">
							<th id="cb" class="manage-column column-cb column-moderator"
								style="" scope="col"><?php echo __('Moderator'); ?>?</th>
							<th id="username" class="manage-column column-username" style=""
								scope="col"><?php echo __('Username'); ?>
							</th>
							<th id="name" class="manage-column column-name" style=""
								scope="col"><?php echo __( 'E-mail' ); ?>
							</th>
							<th id="name" class="manage-column column-role" style=""
								scope="col"><?php echo __('Role'); ?>
							</th>
						</tr>
					</thead>
		
					<tfoot>
						<tr class="thead">
							<th id="cb" class="manage-column column-cb column-moderator"
								style="" scope="col"><?php echo __('Moderator'); ?>?</th>
							<th id="username" class="manage-column column-username" style=""
								scope="col"><?php echo __('Username'); ?>
							</th>
							<th id="name" class="manage-column column-name" style=""
								scope="col"><?php echo __( 'E-mail' ); ?>
							</th>
							<th id="name" class="manage-column column-role" style=""
								scope="col"><?php echo __('Role'); ?>
							</th>
						</tr>
					</tfoot>
		
					<tbody id="users" class="list:user user-list">
				<?php
				$style = '';
				foreach($users as $user) {
					$is_enable = true ;
					$is_moderator = false;
					if ($user->role=='administrator' || $user->role=='editor')
					{
						$is_enable = false ;
						$is_moderator = true;
					}
					if ($user->is_comments_moderator )
					{
						$is_moderator = true;
					}
					$style = ( ' class="alternate"' == $style ) ? '' : ' class="alternate"';
					?>
					<tr id='user-<?php echo $user->ID; ?>' <?php echo $style; ?>>
						<th scope='row' class='check-column'>
							<input type='checkbox'
							name='fcm_users[]' id='user_<?php echo $user->ID; ?>'
							<?php echo ($is_moderator)?"checked":""; ?>
							<?php echo ($is_enable)?"":"disabled"; ?>
							value='<?php echo $user->ID; ?>' />
						</th>
						<td><?php echo $user->user_login; ?></td>
						<td><?php echo $user->user_email; ?></td>
						<td><?php echo $user->role_name; ?></td>
					</tr>
					<?php
				}
				?>
				</tbody>
			</table>
			<p class="submit">
				<input class="button-primary" type="submit" name="fcm_submit"
					class="button" value="<?php _e('Save Changes'); ?>" />
			</p>
			</form>
		</div>
		<?php
	}

	function hide_menu_for_subscribers(){
		$user = wp_get_current_user();
		$user_object = new WP_User($user->ID);
		if (in_array('subscriber',$user_object->roles)){
			?>
			<script type="text/javascript">
						jQuery(document).ready(function() { jQuery('#menu-posts').remove(); });
						jQuery(document).ready(function() { jQuery('#menu-pages').remove(); });
						jQuery(document).ready(function() { jQuery('#menu-media').remove(); });
						jQuery(document).ready(function() { jQuery('#favorite-actions').remove(); });
						jQuery(document).ready(function() { jQuery('#dashboard_quick_press').remove(); });
						jQuery(document).ready(function() { jQuery('#dashboard_recent_drafts').remove(); });
						var currentPath = window.location.pathname;
						if (currentPath.search('edit.php')!=-1  || currentPath.search('post.php')!=-1 || currentPath.search('post-new.php')!=-1){
									jQuery(document).ready(function() { jQuery('#wpbody-content').remove(); });
						}
			</script>
			<?php
		}
	}

	function redirect_url_for_subscribers() {
		$user = wp_get_current_user();
		$user_object = new WP_User($user->ID);
		if (in_array('subscriber',$user_object->roles)){
			$current_uri = $_SERVER['REQUEST_URI'];
			if (strstr($current_uri,'edit.php') || strstr($current_uri,'post.php') || strstr($current_uri,'post-new.php')){
				$location = get_bloginfo('url').'/wp-admin/index.php';
				wp_redirect($location);
			}
		}
	}

	function add_admin_menu(){
		add_options_page(__('Com\'Moderators'), __('Com\'Moderators'), 'manage_options', __FILE__, array('Fay_Comments_Moderators', 'options_page'));
	}
}
if ( !function_exists('wp_notify_moderator') ) :
/**
 * Notifies the moderator of the blog about a new comment that is awaiting approval.
 *
 * @since 1.0
 * @uses $wpdb
 *
 * @param int $comment_id Comment ID
 * @return bool Always returns true
 */
function wp_notify_moderator($comment_id) {
	global $wpdb;

	if ( 0 == get_option( 'moderation_notify' ) )
	return true;

	$comment = get_comment($comment_id);
	$post = get_post($comment->comment_post_ID);

	/*BEGIN PLUGIN HACK*/
	/***** begin - the old code*******
	 $user = get_userdata( $post->post_author );
	 // Send to the administation and to the post author if the author can modify the comment.
	 $email_to = array( get_option('admin_email') );
	 if ( user_can($user->ID, 'edit_comment', $comment_id) && !empty($user->user_email) && ( get_option('admin_email') != $user->user_email) )
	 $email_to[] = $user->user_email;
	 ***** end - the old code ********/
	$wp_users = Fay_Comments_Moderators::getUsers();
	foreach($wp_users as $user) {
		if($user->is_comments_moderator && !empty($user->user_email)){
			$email_to[] = $user->user_email;
		}
	}
	/*END PLUGIN HACK*/

	$comment_author_domain = @gethostbyaddr($comment->comment_author_IP);
	$comments_waiting = $wpdb->get_var("SELECT count(comment_ID) FROM $wpdb->comments WHERE comment_approved = '0'");

	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.
	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	switch ($comment->comment_type)
	{
		case 'trackback':
			$notify_message  = sprintf( __('A new trackback on the post "%s" is waiting for your approval'), $post->post_title ) . "\r\n";
			$notify_message .= get_permalink($comment->comment_post_ID) . "\r\n\r\n";
			$notify_message .= sprintf( __('Website : %1$s (IP: %2$s , %3$s)'), $comment->comment_author, $comment->comment_author_IP, $comment_author_domain ) . "\r\n";
			$notify_message .= sprintf( __('URL    : %s'), $comment->comment_author_url ) . "\r\n";
			$notify_message .= __('Trackback excerpt: ') . "\r\n" . $comment->comment_content . "\r\n\r\n";
			break;
		case 'pingback':
			$notify_message  = sprintf( __('A new pingback on the post "%s" is waiting for your approval'), $post->post_title ) . "\r\n";
			$notify_message .= get_permalink($comment->comment_post_ID) . "\r\n\r\n";
			$notify_message .= sprintf( __('Website : %1$s (IP: %2$s , %3$s)'), $comment->comment_author, $comment->comment_author_IP, $comment_author_domain ) . "\r\n";
			$notify_message .= sprintf( __('URL    : %s'), $comment->comment_author_url ) . "\r\n";
			$notify_message .= __('Pingback excerpt: ') . "\r\n" . $comment->comment_content . "\r\n\r\n";
			break;
		default: //Comments
			$notify_message  = sprintf( __('A new comment on the post "%s" is waiting for your approval'), $post->post_title ) . "\r\n";
			$notify_message .= get_permalink($comment->comment_post_ID) . "\r\n\r\n";
			$notify_message .= sprintf( __('Author : %1$s (IP: %2$s , %3$s)'), $comment->comment_author, $comment->comment_author_IP, $comment_author_domain ) . "\r\n";
			$notify_message .= sprintf( __('E-mail : %s'), $comment->comment_author_email ) . "\r\n";
			$notify_message .= sprintf( __('URL    : %s'), $comment->comment_author_url ) . "\r\n";
			$notify_message .= sprintf( __('Whois  : http://whois.arin.net/rest/ip/%s'), $comment->comment_author_IP ) . "\r\n";
			$notify_message .= __('Comment: ') . "\r\n" . $comment->comment_content . "\r\n\r\n";
			break;
	}

	$notify_message .= sprintf( __('Approve it: %s'),  admin_url("comment.php?action=approve&c=$comment_id") ) . "\r\n";
	if ( EMPTY_TRASH_DAYS )
	$notify_message .= sprintf( __('Trash it: %s'), admin_url("comment.php?action=trash&c=$comment_id") ) . "\r\n";
	else
	$notify_message .= sprintf( __('Delete it: %s'), admin_url("comment.php?action=delete&c=$comment_id") ) . "\r\n";
	$notify_message .= sprintf( __('Spam it: %s'), admin_url("comment.php?action=spam&c=$comment_id") ) . "\r\n";

	$notify_message .= sprintf( _n('Currently %s comment is waiting for approval. Please visit the moderation panel:',
 		'Currently %s comments are waiting for approval. Please visit the moderation panel:', $comments_waiting), number_format_i18n($comments_waiting) ) . "\r\n";
	$notify_message .= admin_url("edit-comments.php?comment_status=moderated") . "\r\n";

	$subject = sprintf( __('[%1$s] Please moderate: "%2$s"'), $blogname, $post->post_title );
	$message_headers = '';

	$notify_message = apply_filters('comment_moderation_text', $notify_message, $comment_id);
	$subject = apply_filters('comment_moderation_subject', $subject, $comment_id);
	$message_headers = apply_filters('comment_moderation_headers', $message_headers);

	foreach ( $email_to as $email )
	@wp_mail($email, $subject, $notify_message, $message_headers);

	return true;
}
endif;
?>
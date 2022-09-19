<?php 
/**
 * Author: Andrew Killen
 * Description: display all run actions at the bottom of the page
 * via a table, links go to wordpress.org where possible. This must be run as an 
 * mu-plugin becuase it needs to start as early as possible to record all hooks.
 * 
 */


/**
 * Get the roles (comma separated) of the current logged in
 * user.
 * 
 * @return string
 */
function get_user_roles_status() {
	$user = wp_get_current_user();
	$roles = ( array ) $user->roles;
	return implode(",", $roles);
}
/**
 * Action to listen to 'all' hooks and save the info/.
 * 
 */
add_action( 'all', function ( $tag ) {
    static $hooks = array();
    // Only do_action / do_action_ref_array hooks.
    if ( did_action( $tag ) ) {
		// Append the hook name to an array
        $hooks[] = $tag;
    }
	// If the hook is called "shutdown" (the last hook) perform this.
    if ( 'shutdown' === $tag ) {
		// Reduce the hooks to only unique ones rather than every loading occurance.
        $hooks =  array_unique( array_values( $hooks ) ) ;
		// Default where the code was run from
		$location = 'frontend';
		// Default login status
		$login_status = 'when not logged in';
		// Check if login page.
		if ( $GLOBALS['pagenow'] === 'wp-login.php' ) {
			$location = 'login page';
			$login_status = 'when logging in';
		} else if (is_admin()) {
			// Its an admin page
			$location = 'admin page';
			// Adapt login status to include role(s)
			$login_status = "when logged in as " . get_user_roles_status();
		}

		if($location == 'frontend' && is_user_logged_in() ) {			
			// Adapt login status to include role(s)
			$login_status = "when logged in as "  . get_user_roles_status();
		}

	// Output numbers of hooks, location and login status
	echo "<h3>". sizeof($hooks) ."  hooks for the " . $location . ", " . $login_status . "</h3>";
	// Build a table for the output.
	Echo "<table>";
	foreach ($hooks as $name) {
	// Loop	to create each table row.
	?><tr>
		<th><a target="_blank" rel="noopener noreferrer" href="https://developer.wordpress.org/reference/hooks/<?php echo $name ?>/"><?php echo $name ?></a></th>
	      	<td></td>
	</tr><?php	
	}
	// Close the table.
	echo "</table>";

    }
} );

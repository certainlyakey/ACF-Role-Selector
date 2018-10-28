<?php
/**
 * ACF 4 Field Class
 *
 * This file holds the class required for our field to work with ACF 4
 *
 * @author Daniel Pataki
 * @since 3.0.0
 *
 */

/**
 * ACF 4 Role Selector Class
 *
 * The role selector class enables users to select roles. This is the class
 * that is used for ACF 4.
 *
 * @author Daniel Pataki
 * @since 3.0.0
 *
 */
class acf_field_role_selector extends acf_field {

	var $settings;
	var $defaults;

	/**
	 * Field Constructor
	 *
	 * Sets basic properties and runs the parent constructor
	 *
	 * @author Daniel Pataki
	 * @since 3.0.0
	 *
	 */
	function __construct() {

		$this->name     = 'role_selector';
		$this->label    = __( 'User Role Selector', 'acf-role-selector-field' );
		$this->category = __( 'Choice', 'acf' );
		$this->defaults = array(
			'return_value'    => 'name',
			'field_type'      => 'checkbox',
			'allowed_roles'   => '',
		);

		parent::__construct();

		$this->settings = array(
			'path'    => apply_filters( 'acf/helpers/get_path', __FILE__ ),
			'dir'     => apply_filters( 'acf/helpers/get_dir', __FILE__ ),
			'version' => '3.0.0'
		);

	}


	/**
	 * Field Options
	 *
	 * Creates the options for the field, they are shown when the user
	 * creates a field in the back-end. Currently there are three fields.
	 *
	 * The Return Format determines how the value is returned to the front-end.
	 * Role Name returns just the name, Role Object will grab all data
	 * associated with the role.
	 *
	 * The Allowed Roles field lets users choose which roles may be selected.
	 * If all or none of the roles are selected all roles will be allowed.
	 *
	 * The field type determines how the user can select roles using our field.
	 * Checkbox and multiselect is available for multiple selections and radio
	 * buttons and select boxes are available for single selections.
	 *
	 * @param array $field The details of this field
	 * @author Daniel Pataki
	 * @since 3.0.0
	 *
	 */
	function create_options( $field ) {

		$field = array_merge( $this->defaults, $field );
		$key = $field['name'];

		?>

			<!-- Return Format Field -->
			<tr class="field_option field_option_<?php echo $this->name ?>">
				<td class="label">
					<label><?php _e( 'Return Format', 'acf-role-selector-field' ); ?></label>
					<p class="description"><?php _e( 'Specify the value returned to the front end', 'acf-role-selector-field' ); ?></p>
				</td>
				<td>
					<?php
					do_action( 'acf/create_field', array(
						'type'    =>  'radio',
						'name'    =>  'fields[' . $key . '][return_value]',
						'value'   =>  $field['return_value'],
						'layout'  =>  'horizontal',
						'choices' =>  array(
							'name'   => __( 'Role Name', 'acf-role-selector-field' ),
							'object' => __( 'Role Object', 'acf-role-selector-field' ),
						)
					));
					?>
				</td>
			</tr>

			<!-- Allowed Roles Field -->
			<tr class="field_option field_option_<?php echo $this->name ?>">
				<td class="label">
					<label><?php _e( 'Allowed Roles', 'acf-role-selector-field' ); ?></label>
					<p class="description"><?php _e( 'To allow all roles, select none or all of the options to the right', 'acf-role-selector-field' ); ?></p>
				</td>
				<td>
					<?php
					global $wp_roles;
					do_action('acf/create_field', array(
						'type'    =>  'select',
						'multiple' => true,
						'name'    =>  'fields[' . $key . '][allowed_roles]',
						'value'   =>  $field['allowed_roles'],
						'choices' => $wp_roles->role_names
					));
					?>
				</td>
			</tr>

			<!-- Field Type Field -->
			<tr class="field_option field_option_<?php echo $this->name ?>">
				<td class="label">
					<label><?php _e( 'Field Type', 'acf-role-selector-field' ); ?></label>
				</td>
				<td>
					<?php
					do_action('acf/create_field', array(
						'type'    =>  'select',
						'name'    =>  'fields[' . $key . '][field_type]',
						'value'   =>  $field['field_type'],
						'choices' => array(
							__( 'Multiple Values', 'acf-role-selector-field' ) => array(
								'checkbox' => __( 'Checkbox', 'acf-role-selector-field' ),
								'multi_select' => __( 'Multi Select', 'acf-role-selector-field' )
							),
							__( 'Single Value', 'acf-role-selector-field' ) => array(
								'radio' => __( 'Radio Buttons', 'acf-role-selector-field' ),
								'select' => __( 'Select', 'acf-role-selector-field' )
							)
						)
					));
					?>
				</td>
			</tr>
		<?php

	}


	/**
	 * Field Display
	 *
	 * This function takes care of displaying our field to the users, taking
	 * the field options into account.
	 *
	 * @param array $field The details of this field
	 * @author Daniel Pataki
	 * @since 3.0.0
	 *
	 */
	function create_field( $field ) {
	    global $wp_roles;
		$roles = $wp_roles->roles;

		foreach( $roles as $role => $data ) {
			if( is_array( $field['allowed_roles'] ) && !in_array( $role, $field['allowed_roles'] ) ) {
				unset( $roles[$role] );
			}
		}

		$roles = apply_filters( 'acfrsf/allowed_roles', $roles, $field );

		// Select and multiselect fields
	    if( $field['field_type'] == 'select' || $field['field_type'] == 'multi_select' ) :
	    	$multiple = ( $field['field_type'] == 'multi_select' ) ? 'multiple="multiple"' : '';
		?>

			<select name='<?php echo $field['name'] ?>[]' <?php echo $multiple ?>>
				<?php
					foreach( $roles as $role => $data ) :
					$selected = ( !empty( $field['value'] ) && in_array( $role, $field['value'] ) ) ? 'selected="selected"' : '';
				?>
					<option <?php echo $selected ?> value='<?php echo $role ?>'><?php echo $data['name'] ?></option>
				<?php endforeach; ?>
			</select>
		<?php
		// checkbox and radio button fields
		else :
			echo '<ul class="acf-'.$field['field_type'].'-list '.$field['field_type'].' vertical">';
			foreach( $roles as $role => $data ) :
				$checked = ( !empty( $field['value'] ) && in_array( $role, $field['value'] ) ) ? 'checked="checked"' : '';
		?>
		<li><label><input <?php echo $checked ?> type="<?php echo $field['field_type'] ?>" name="<?php echo $field['name'] ?>[]" value="<?php echo $role ?>"><?php echo $data['name'] ?></label></li>
		<?php
			endforeach;

			echo '<input type="hidden" name="' .  $field['name'] . '[]" value="" />';

			echo '</ul>';
		endif;
	}




	/**
	 * Format Value For API
	 *
	 * This filter is appied to the $value after it is loaded from the db
	 * and before it is passed back to the api functions such as the_field
	 *
	 * @param mixed $value The value which was loaded from the database
	 * @param int $post_id The $post_id from which the value was loaded
	 * @param array $field The details of this field
	 * @return mixed $value The modified value
	 * @author Daniel Pataki
	 * @since 3.0.0
	 *
	 */
	function format_value_for_api($value, $post_id, $field) {

		if( $field['return_value'] == 'object' && !empty( $value ) ) {
			foreach( $value as $key => $name ) {
				$value[$key] = get_role( $name );
			}
		}

		return $value;
	}
}

new acf_field_role_selector();

?>

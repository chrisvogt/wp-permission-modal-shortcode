<?php
/**
 * Plugin settings and options.
 *
 */

/**
 * Plugin hooks and filters.
 */
add_action( 'admin_menu', 'pmodal_add_menu' );
add_action( 'admin_init', 'pmodal_register_settings' );

/**
 * Include required files.
 */
// page settings sections & fields
require_once('pmodal-options.php');

function pmodal_add_menu() {
  $cjvpmodal_settings_page = add_menu_page(__('Permission Modal Options'), __('Permission Modals'), 'manage_options', 'pmodal-settings', 'pmodal_settings_page_fn');
}

 /**
 * Helper function for defining variables for the current page
 *
 * @return array
 */
function pmodal_get_settings() {
  $output = array();
  // put together the output array
  $output['pmodal_option_name']     = 'pmodal_options'; // the option name as used in the get_option() call.
  $output['pmodal_page_title']     = __( 'Permission Modal Settings' ); // the settings page title
  $output['pmodal_page_sections']   = pmodal_options_page_sections(); // the setting section
  $output['pmodal_page_fields']     = pmodal_options_page_fields(); // the setting fields
  $output['pmodal_contextual_help']   = ''; // the contextual help
return $output;
}

function pmodal_create_settings_field( $args = array() ) {
  // default array to overwrite when calling the function
  $default = array(
      'id'        => 'default_field', // ID of the seeting in options array & ID of HTML form element
      'title'     => 'Default Field', // Default HTML form label
      'desc'      => 'This is a default description.', // Description for the form element
      'std'       => '', // The default value
      'type'      => 'text', // HTML form element to use
      'section'   => 'main_section', // Section this setting belongs to
      'choices'   => array(), // (optional): values in radio or dropdown
      'class'     => '' //HTML form element class; also used for validation
  );

  extract( wp_parse_args( $args, $defaults ) );

  // additional arguments used in form field output
  $field_args = array(
      'type'      => $type,
      'id'        => $id,
      'desc'      => $desc,
      'std'       => $std,
      'choices'   => $choices,
      'label_for' => $id,
      'class'     => $class
  );

  add_settings_field( $id, $title, array( $this, 'pmodal_form_field_fn' ), __FILE__, $section, $field_args );

}
/**
 * Register the settings.
 */
function pmodal_register_settings() {
  // load the settings sections array
  $settings_output = pmodal_get_settings();
  $pmodal_option_name = $settings_output['pmodal_option_name'];
 
  // settings
  register_setting( $pmodal_option_name, $pmodal_option_name, array( $this, 'pmodal_validate_options' ) );

  // sections
  if(!empty($settings_output['pmodal_page_sections'])) {

    // call add_settings_section() for each
    foreach ( $settings_output['pmodal_page_sections'] as $id => $title ) {
      add_settings_section( $id, $title, 'pmodal_section_fn', __FILE__);
    }

  }

  // fields
  if(!empty($settings_output['pmodal_page_fields'])) {
    // call add_settings_field() for each
    foreach ($settings_output['pmodal_page_fields'] as $option) {
      pmodal_create_settings_field($option);
    }
  }

}

/**
 * Generate the settings page markup.
 * @return echos output
 */
function pmodal_settings_page_fn() {
  // load the settings sections array
  $settings_output = pmodal_get_settings(); ?>

    <div class="wrap">
      <div class="icon32" id="icon-options-general"></div>
      <h2><?php echo $settings_output['pmodal_page_title']; ?><?h2>
      <form action="options.php" method="post">
        <?php
        settings_fields($settings_output['pmodal_option_name']);
        do_settings_sections(__FILE__);
        ?>
        <p class="submit">
          <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
        </p>
      </form>
    </div><!-- end .wrap -->

<?php }

/**
 * Section HTML, displayed before the first option.
 * @return echoes output
 */
function pmodal_section_fn($desc) {
  echo "<p>" . "Settings for this section" . "</p>";
}

/**
 * Form Fields HTML
 * All form field types share the same function!!
 * @return echoes output
 */
function pmodal_form_field_fn($args = array()) {
  extract( $args );
  // get the settings sections array
  $settings_output   = pmodal_get_settings();
  $pmodal_option_name = $settings_output['pmodal_option_name'];
  $options       = get_option($pmodal_option_name);
  // pass the standard value if the option is not yet set in the database
  if ( !isset( $options[$id] ) && 'type' != 'checkbox' ) {
    $options[$id] = $std;
  }
  // additional field class. output only if the class is defined in the create_setting arguments
  $field_class = ($class != '') ? ' ' . $class : '';
  // switch html display based on the setting type.
  switch ( $type ) {
    case 'text':
      $options[$id] = stripslashes($options[$id]);
      $options[$id] = esc_attr( $options[$id]);
      echo "<input class='regular-text$field_class' type='text' id='$id' name='" . $pmodal_option_name . "[$id]' value='$options[$id]' />";
      echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
    break;
    case "multi-text":
      foreach($choices as $item) {
        $item = explode("|",$item); // cat_name|cat_slug
        $item[0] = esc_html__($item[0]);
        if (!empty($options[$id])) {
          foreach ($options[$id] as $option_key => $option_val){
            if ($item[1] == $option_key) {
              $value = $option_val;
            }
          }
        } else {
          $value = '';
        }
        echo "<span>$item[0]:</span> <input class='$field_class' type='text' id='$id|$item[1]' name='" . $pmodal_option_name . "[$id|$item[1]]' value='$value' /><br/>";
      }
      echo ($desc != '') ? "<span class='description'>$desc</span>" : "";
    break;
    case 'textarea':
      $options[$id] = stripslashes($options[$id]);
      $options[$id] = esc_html( $options[$id]);
      echo "<textarea class='textarea$field_class' type='text' id='$id' name='" . $pmodal_option_name . "[$id]' rows='5' cols='30'>$options[$id]</textarea>";
      echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
    break;
    case 'select':
      echo "<select id='$id' class='select$field_class' name='" . $pmodal_option_name . "[$id]'>";
        foreach($choices as $item) {
          $value   = esc_attr($item);
          $item   = esc_html($item);
          $selected = ($options[$id]==$value) ? 'selected="selected"' : '';
          echo "<option value='$value' $selected>$item</option>";
        }
      echo "</select>";
      echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
    break;
    case 'select2':
      echo "<select id='$id' class='select$field_class' name='" . $pmodal_option_name . "[$id]'>";
      foreach($choices as $item) {
        $item = explode("|",$item);
        $item[0] = esc_html($item[0]);
        $selected = ($options[$id]==$item[1]) ? 'selected="selected"' : '';
        echo "<option value='$item[1]' $selected>$item[0]</option>";
      }
      echo "</select>";
      echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
    break;
    case 'checkbox':
      echo "<input class='checkbox$field_class' type='checkbox' id='$id' name='" . $pmodal_option_name . "[$id]' value='1' " . checked( $options[$id], 1, false ) . " />";
      echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
    break;
    case "multi-checkbox":
      foreach($choices as $item) {
        $item = explode("|",$item);
        $item[0] = esc_html($item[0]);
        $checked = '';
          if ( isset($options[$id][$item[1]]) ) {
          if ( $options[$id][$item[1]] == 'true') {
               $checked = 'checked="checked"';
          }
        }
        echo "<input class='checkbox$field_class' type='checkbox' id='$id|$item[1]' name='" . $pmodal_option_name . "[$id|$item[1]]' value='1' $checked /> $item[0] <br/>";
      }
      echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
    break;
  }
}

/**
 * Setting validation callback function.
 * 
 * @return array
 */
function pmodal_validate_options($input) {
  // enhanced security; create a new empty array
  $valid_input = array();

  return $valid_input(); // return validated input
}
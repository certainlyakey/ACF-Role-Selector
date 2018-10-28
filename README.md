This fork fixes some issues of the original plugin by @danielpataki (thanks to work done by @mattsims and @simmerer) and removes SVN structure (work of @Vyygir).

# ACF - Role Selector Field

This plugin adds a user role selector to ACF, allowing you to select one or more user roles using a customizable field.

## Description

This plugin helps you out if you need to have the ability to select one or more user roles. Roles can be chosen with a select element (single or multiple choice), checkboxes or radio buttons. Roles can be returned as a role name or a role object.

You also have the option of specifying allowed roles. This lets you control the roles users are allowed to select.

#### Thanks

- [Advanced Custom Fields](http://www.advancedcustomfields.com/) for the awesome base plugin.
- [Umar Irshad](https://www.iconfinder.com/Umar) for the field icon.

#### Translations

The plugin is currently available in English and Hungarian. Please feel free to submit any new languages via a pull request, I'd be mighty thankful.

#### Useful Links

This Github repository is for the development of this plugin. If you would like to read installation and in-depth usage instructions you might want to look at the WordPress plugin page instead.

- [Plugin Page](https://wordpress.org/plugins/acf-role-selector-field/)
- [SVN Repository](http://plugins.svn.wordpress.org/acf-role-selector-field/)
- [ACF Plugin](https://wordpress.org/plugins/advanced-custom-fields/)
- [ACF Home Page](http://www.advancedcustomfields.com/)
- [ACF Documentation](http://www.advancedcustomfields.com/resources/)
- [ACF Field Template](https://github.com/elliotcondon/acf-field-type-template)
- [ACF on Github](https://github.com/elliotcondon/acf)

# For Developers

The plugin allows you to specify the roles that can be selected but there is also a hook which allows for further changes. The `acfrsf/allowed_roles` filter allows you to modify the set of shown roles easily like so:

```
add_filter('acfrsf/allowed_roles', 'my_role_filter', 10, 2 );
function my_role_filter( $roles, $field ) {
    if( current_user_can( 'activate_plugins' ) ) {
        $roles = array(); // This will enable all roles
    }
    else {
        unset( $roles['administrator'] );
    }
    return $roles;
}
```


# Want To Help?

If you like the plugin and you like helping others out there are a few things you can do:

- **[Buy ACF Pro](http://www.advancedcustomfields.com/pro/)**
- **[Review the plugin](https://wordpress.org/support/view/plugin-reviews/twitter-user-timelines)**
- **Submit a translation** If you speak another language goodly, you can submit a language file, I'd be mighty thankful! Take a look at the lang directory to see what languages we already have. If a language isn't there create one and submit a pull request. If you have no idea what I'm talking about drop me a line and I'll help you out
- **[Tip me on Gratipay](https://gratipay.com/danielpataki/)**

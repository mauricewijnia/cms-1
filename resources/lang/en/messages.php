<?php

return [
    'activate_account_notification_body' => 'You are receiving this email because we received a password reset request for your account.',
    'activate_account_notification_subject' => 'Activate Your Account',
    'asset_container_blueprint_instructions' => 'Blueprints define additional custom fields available when editing assets.',
    'asset_container_create_folder_instructions' => 'When enabled will give users the ability to create folders in this container.',
    'asset_container_disk_instructions' => 'Filesystem disks allow you to specify where to store files — either locally or in a remote location like Amazon S3. They can be configured in `config/filesystems.php`',
    'asset_container_handle_instructions' => 'Used to reference this container on the frontend. It\'s non-trivial to change later.',
    'asset_container_intro' => 'Media and document files live in folders on your server or other file storage services. Each of these locations is called a container.',
    'asset_container_move_instructions' => 'When enabled will allow users to move files around inside this container.',
    'asset_container_quick_download_instructions' => 'When enabled will add a quick download button in the Asset Manager.',
    'asset_container_rename_instructions' => 'When enabled will allow users to rename the files in this container.',
    'asset_container_title_instructions' => 'Usually a plural noun, like Images or Documents',
    'asset_folders_directory_instructions' => 'We recommend avoiding spaces and special characters to keep your URLs clean.',
    'blueprints_button_help_text' => 'You will be able to customize your Blueprint once it\'s created.',
    'blueprints_intro' => 'Blueprints define and organize fields to create the content models for collections, forms, and other data types.',
    'blueprints_title_instructions' => 'Usually a singular noun, like Article or Product',
    'cache_utility_application_cache_description' => 'Laravel\'s unified cache used by Statamic, third party addons, and composer packages.',
    'cache_utility_description' => 'Manage and view important information about Statamic\'s various caching layers.',
    'cache_utility_image_cache_description' => 'The image cache stores copies of all transformed and resized images.',
    'cache_utility_stache_description' => 'The Stache is Statamic\'s content store that functions much like a database. It is generated automatically from your content files.',
    'cache_utility_static_cache_description' => 'Static pages bypass Statamic completely and are rendered directly from your server for maximum performance.',
    'collection_configure_amp_instructions' => 'AMP versions will be routed to <code>{site url}/amp/{entry url}</code>',
    'collection_configure_articles_description' => 'Entries with dates in the future will be private.',
    'collection_configure_blueprints_instructions' => 'Choose from existing Blueprints or create a new one.',
    'collection_configure_content_model_intro' => 'Your content model determines what fields and behaviors define this collection.',
    'collection_configure_dates_intro' => 'You can select different date behaviors.',
    'collection_configure_default_status_draft_description' => 'Entries will default to <span class="text-grey-60">draft</span> status.',
    'collection_configure_default_status_published_description' => 'Entries will default to <span class="text-green">published</span> status.',
    'collection_configure_events_description' => 'Entries with dates in the past will be private.',
    'collection_configure_handle_instructions' => 'Used to reference this collection on the frontend. It\'s non-trivial to change later.',
    'collection_configure_intro' => 'A collection is a group of related entries that share behavior, attributes, and settings.',
    'collection_configure_layout_instructions' => 'Set this collection\'s default layout. Entries can override this setting with a `template` field named `layout`. It is unusual to change this setting.',
    'collection_configure_mount_instructions' => 'Optionally set an entry that will act as a parent. Also enables shortcut links in any structures.',
    'collection_configure_no_dates_description' => 'Entries will not have any dates.',
    'collection_configure_order_intro' => 'Choose how you want your Collection to be ordered.',
    'collection_configure_ordered_alpha_ascending' => 'Entries will be sorted from A to Z.',
    'collection_configure_ordered_alpha_descending' => 'Entries will be sorted from Z to A.',
    'collection_configure_ordered_by_date_description' => 'Entries are ordered by date.',
    'collection_configure_ordered_by_title_description' => 'Entries are ordered alphabetically by title.',
    'collection_configure_ordered_date_ascending' => 'Entries will be sorted from oldest to newest (unusual).',
    'collection_configure_ordered_date_descending' => 'Entries will be sorted from newest to oldest.',
    'collection_configure_ordered_sequentially_ascending' => 'Entries will be sorted from lowest to highest.',
    'collection_configure_ordered_sequentially_descending' => 'Entries will be sorted from highest to lowest.',
    'collection_configure_ordered_sequentially_description' => 'Entries are ordered sequentially and can be manually reordered.',
    'collection_configure_route_instructions' => 'Routes are optional. If you don\'t need a URL, you don\'t need a route.',
    'collection_configure_routing_intro' => 'Route rules determine the URL pattern of your collection\'s entries.',
    'collection_configure_structure_instructions' => 'Enable hierarchial (parent/child) URLs.',
    'collection_configure_structure_route_instructions' => 'A route is required when choosing a structure. You can also use `parent_uri` and `depth`.',
    'collection_configure_taxonomies_instructions' => 'Allow taxonomy relationships to be defined on entries in this collection.',
    'collection_configure_template_instructions' => 'Set this collection\'s default template. Entries can override this setting with a `template` field.',
    'collection_configure_dated_instructions' => 'Publish dates can be used to schedule and expire content.',
    'collection_configure_date_behavior_public' => 'Public - Always visible',
    'collection_configure_date_behavior_unlisted' => 'Unlisted - Hidden from listings, URLs visible',
    'collection_configure_date_behavior_private' => 'Private - Hidden from listings, URLs 404',
    // 'collection_configure_' =>
    // 'collection_configure_' =>
    'collection_configure_title_instructions' => 'We recommend a plural noun, like "Articles" or "Products".',
    'collection_next_steps_configure_description' => 'Configure URLs and routes, define blueprints, date behaviors, ordering and other options.',
    'collection_next_steps_create_entry_description' => 'Create your first entry or stub out a handful of placeholder entries, it\'s up to you.',
    'collection_next_steps_documentation_description' => 'Learn more about collections, how they work, and how to configure them.',
    'collection_next_steps_scaffold_description' => 'Quickly generate empty blueprints and frontend views based on the name of your collection.',
    'collection_scaffold_instructions' => 'Choose which blank resources to generate. Existing files will not be overwritten.',
    'collections_amp_instructions' => 'Enable Accelerated Mobile Pages (AMP). Automatically adds routes and URL for entries in this collection. Learn more in the [documentation](https://statamic.dev/amp)',
    'collections_blueprint_instructions' => 'Entries in this collection may use any of these blueprints.',
    'collections_default_publish_state_instructions' => 'While creating new entries in this collection the published toggle will default to **true** instead of **false** (draft).',
    'collections_future_date_behavior_instructions' => 'How future dated entries should behave.',
    'collections_layout_instructions' => 'Set this collection\'s default layout.',
    'collections_links_instructions' => 'Entries in this collection may contain links (redirects) to other entries or URLs.',
    'collections_mount_instructions' => 'Choose an entry on which this collection should be mounted. Learn more in the [documentation](https://statamic.dev/collections-and-entries#mounting).',
    'collections_orderable_instructions' => 'Enable manual ordering via drag & drop.',
    'collections_past_date_behavior_instructions' => 'How past dated entries should behave.',
    'collections_route_instructions' => 'The route controls entries URL pattern.',
    'collections_sort_direction_instructions' => 'The default sort direction.',
    'collections_structure_instructions' => 'Structures enable page hierarchies that control order and URL.',
    'collections_taxonomies_instructions' => 'Connect entries in this collection to taxonomies. Fields will be automatically added to publish forms.',
    'collections_template_instructions' => 'Set a default template.',
    'default_value_instructions' => 'Set the default value for this field.',
    'email_utility_configuration_description' => 'Mail settings are configured in <code>:path</code>',
    'email_utility_description' => 'Check email configuration settings and send test emails.',
    'field_conditions_instructions' => 'When to show or hide this field.',
    'field_desynced_from_origin' => 'Desynced from origin. Click to sync and revert to the origin\'s value.',
    'field_synced_with_origin' => 'Synced with origin. Click or edit the field to desync.',
    'field_validation_instructions' => 'Has access to all of Laravel\'s validation rules.',
    'fields_blueprints_description' => 'Blueprints let you mix and match fields and fieldsets to create the content structures for collections and other data types.',
    'fields_display_instructions' => 'The field\'s label shown in the Control Panel.',
    'fields_fieldsets_description' => 'Fieldsets are simple, flexible, and completely optional groupings of fields that help to organize reusable, pre-configured fields.',
    'fields_handle_instructions' => 'The field\'s template variable.',
    'fields_instructions_instructions' => 'Shown under the field\'s display label, like this very text. Markdown is supported.',
    'fields_listable_instructions' => 'Control the column visibility of this field.',
    'fieldset_link_fields_prefix_instructions' => 'Every field in the linked fieldset will be prefixed with this. Useful if you want to import the same fields multiple times.',
    'fieldset_import_fieldset_instructions' => 'The fieldset to be imported.',
    'fieldset_import_prefix_instructions' => 'The prefix that should be applied to each field when they are imported. eg. hero_',
    'fieldset_intro' => 'Fieldsets are an optional companion to blueprints, allowing you to create partials to be used within blueprints.',
    'fieldsets_button_help_text' => 'You will be able to customize your Fieldset once it\'s created.',
    'fieldsets_title_instructions' => 'Usually describes what fields will be inside, like Image Block',
    'focal_point_instructions' => 'Setting a focal point allows dynamic photo cropping with a subject that stays in frame.',
    'focal_point_previews_are_examples' => 'Crop previews are for example only',
    'forgot_password_enter_email' => 'Enter your email address so we can send a reset password link.',
    'form_configure_blueprint_instructions' => 'Choose from existing Blueprints or create a new one.',
    'form_configure_email_from_instructions' => 'Leave blank to fall back to the site default',
    'form_configure_email_instructions' => 'Configure emails to be sent when new form submission are received.',
    'form_configure_email_reply_to_instructions' => 'Leave blank to fall back to sender.',
    'form_configure_email_subject_instructions' => 'Email subject line.',
    'form_configure_email_template_instructions' => 'Leave blank to use an automagic email template.',
    'form_configure_email_to_instructions' => 'Email address of the recipient.',
    'form_configure_handle_instructions' => 'Used to reference this form on the frontend. It\'s non-trivial to change later.',
    'form_configure_honeypot_instructions' => 'Field name to use as a honeypot. Honeypots are special fields used to reduce botspam.',
    'form_configure_store_instructions' => 'Disable if you wish submissions to only fire events and send email notifications.',
    'form_configure_title_instructions' => 'Usually a call to action, like "Contact Us".',
    'form_wizard_blueprint_instructions' => 'Choose from existing Blueprints or create a new one.',
    'form_wizard_email_notifications_instructions' => 'Be notified of submissions at this email address. You can further customize notification settings later.',
    'form_wizard_fields_intro' => 'Define fields for your form.',
    'form_wizard_intro' => 'Forms are used to collect information from your visitors and dispatch events and notifications to your team when there are new submissions.',
    'getting_started_widget_addons' => 'Addons extend Statamic\'s core capabilities. Go see what\'s possible!',
    'getting_started_widget_blueprints' => 'Blueprints define the custom fields used to create and store your content.',
    'getting_started_widget_collections' => 'Collections contain the different types of content in your site.',
    'getting_started_widget_docs' => 'Get to know Statamic by understanding its capabilities the right way.',
    'getting_started_widget_header' => 'Getting Started with Statamic 3',
    'getting_started_widget_intro' => 'To begin building your new Statamic 3 site, we recommend starting with these steps.',
    'getting_started_widget_navigation' => 'Create multi-level lists of links that can be used to render navbars, footers, and so on.',
    'global_search_open_using_slash' => 'You can open global search using the <kbd>/</kbd> key',
    'global_set_blueprint_instructions' => 'Defines the field layout when editing this global set.',
    'global_set_config_intro' => 'Global Sets manage content available across the entire site, like company details, contact information, or front-end settings.',
    'global_set_handle_instructions' => 'How you will reference this global set in templates, etc.',
    'global_set_title_instructions' => 'The display name of this global set.',
    'max_items_instructions' => 'Set a maximum number of selectable items.',
    'navigation_configure_collections_instructions' => 'Enable linking to entries in these collections.',
    'expect_root_instructions' => 'Considered the first page in the tree a "root" or "home" page.',
    'navigation_configure_handle_instructions' => 'Used to reference this navigation on the frontend. It\'s non-trivial to change later.',
    'navigation_configure_intro' => 'Navigations are multi-level lists of links that can be used to build navbars, footers, sitemaps, and other forms of frontend navigation.',
    'max_depth_instructions' => 'Set a maximum number of levels page may be nested. Leave blank for no limit.',
    'navigation_configure_settings_intro' => 'Enable linking to collections, set a max depth, and other behaviors.',
    'navigation_configure_title_instructions' => 'We recommend a name that matches where it will be used, like "Main Nav" or "Footer Nav".',
    'navigation_documentation_instructions' => 'Learn more about building, configuring, and rendering Navigations.',
    'navigation_empty' => 'Navigations are multi-level lists of links that can be used to build navbars, footers, sitemaps, and other forms of frontend navigation.',
    'navigation_link_to_entry_instructions' => 'Add a link to an entry. Enable linking to additional collections in your config.',
    'navigation_link_to_url_instructions' => 'Add a link to any internal or external URL. Enable linking to entries in your config.',
    'phpinfo_utility_description' => 'Check your PHP configuration settings and installed modules.',
    'publish_actions_create_revision' => 'A revision will be created based off the working copy. The current revision will not change.',
    'publish_actions_current_becomes_draft_because_scheduled' => 'Since the current revision is published and you\'ve selected a date in the future, once you submit, the revision will act like a draft until the selected date.',
    'publish_actions_publish' => 'Changes to the working copy will applied to the entry and it will be published immediately.',
    'publish_actions_schedule' => 'Changes to the working copy will applied to the entry and it will be appear published on the selected date.',
    'publish_actions_unpublish' => 'The current revision will be unpublished.',
    'reset_password_notification_body' => 'You are receiving this email because we received a password reset request for your account.',
    'reset_password_notification_no_action' => 'If you did not request a password reset, no further action is required.',
    'reset_password_notification_subject' => 'Reset Password Notification',
    'role_change_handle_warning' => 'Changing the handle will not update references to it in users and groups.',
    'role_handle_instructions' => 'Handles are used to reference this role on the frontend. Cannot be easily changed.',
    'role_intro' => 'Roles are groups of access and action permissions that can be assigned to users and user groups.',
    'role_title_instructions' => 'Usually a singular noun, like Editor or Admin.',
    'search_utility_description' => 'Manage and view important information about Statamic\'s search indexes.',
    'session_expiry_enter_password' => 'Enter your password to continue where you left off',
    'session_expiry_logged_out_for_inactivity' => 'You have been logged out because you\'ve been inactive for a while.',
    'session_expiry_logging_out_in_seconds' => 'You have been inactive for a while and will be logged out in :seconds seconds. Click to extend your session.',
    'session_expiry_new_window' => 'Opens in a new window. Come back once you\'ve logged in.',
    'tab_sections_instructions' => 'The fields in each section will be grouped together into tabs. Create new fields, reuse existing fields, or import entire groups of fields from existing fieldsets.',
    'taxonomies_blueprints_instructions' => 'Terms in this taxonomy may use any of these blueprints.',
    'taxonomy_wizard_blueprint_instructions' => 'Choose from existing Blueprints or create a new one.',
    'taxonomy_wizard_collections_instructions' => 'Fields are automatically added when taxonomies are attached to collections.',
    'taxonomy_wizard_collections_intro' => 'Optionally attach this taxonomy to existing Collections. You can always do this later by editing a collection\'s settings.',
    'taxonomy_wizard_fields_intro' => 'Blueprints are used to customize the available fields on this taxonomy.',
    'taxonomy_wizard_handle_instructions' => 'Handles are used to reference this taxonomy on the frontend. Cannot be easily changed.',
    'taxonomy_wizard_intro' => 'A taxonomy is a system of classifying data around a set of unique characteristics, such as category or color.',
    'taxonomy_wizard_title_instructions' => 'We recommend using a plural noun, like "Categories" or "Tags".',
    'updates_available' => 'Updates are available!',
    'user_groups_handle_instructions' => 'Used to reference this user group on the frontend. It\'s non-trivial to change later.',
    'user_groups_intro' => 'User groups allow you to organize users and apply permission-based roles in aggregate.',
    'user_groups_role_instructions' => 'Assign roles to give users in this group all of their corresponding permissions.',
    'user_groups_title_instructions' => 'Usually a plural noun, like Editors or Photographers',
    'user_wizard_account_created' => 'The user account has been created.',
    'user_wizard_email_instructions' => 'The email address also serves as a username and must be unique.',
    'user_wizard_intro' => 'Users can be assigned to roles that customize their permissions, access, and abilities throughout the Control Panel.',
    'user_wizard_invitation_body' => 'Activate your new Statamic account on :site to begin managing this website. For your security, the link below expires after 1 hour. After that, please contact the site administrator for a new password.',
    'user_wizard_invitation_intro' => 'Send a welcome email with account activation details to the new user.',
    'user_wizard_invitation_share_before' => 'After you create the user, you\'ll be given details to share with <code>:email</code> via your preferred method.',
    'user_wizard_invitation_share' => 'Copy these credentials and share them with <code>:email</code> via your preferred method.',
    'user_wizard_invitation_subject' => 'Activate your new Statamic account on :site',
    'user_wizard_name_instructions' => 'You can leave the name blank if you want to let the user fill it in.',
    'user_wizard_roles_groups_intro' => 'Users can be assigned to roles that customize their permissions, access, and abilities throughout the Control Panel.',
    'user_wizard_super_admin_instructions' => 'Super admins have complete control and access to everything in the control panel. Grant this role wisely.',
];

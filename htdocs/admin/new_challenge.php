<?php

require('../../include/mellivora.inc.php');

enforce_authentication(CONST_USER_CLASS_MODERATOR);

head('Site management');
menu_management();

section_subhead('New challenge');
form_start(Config::get('MELLIVORA_CONFIG_SITE_ADMIN_RELPATH') . 'actions/new_challenge');
$opts = db_query_fetch_all('SELECT * FROM categories ORDER BY title');

form_input_text('Title');
form_textarea('Description');
form_input_text('Flag');
form_input_text('Points');
form_select($opts, 'Category', 'id', array_get($_GET, 'category'), 'title');
form_input_checkbox('Exposed', false);

form_button_submit('Create challenge');
message_inline_blue('Create and edit challenge to add files.');

section_subhead ("Advanced Settings:");
form_input_checkbox('Automark', true);
form_input_checkbox('Case insensitive');
form_input_text('Num attempts allowed');
form_input_text('Min seconds between submissions', 5);

$opts = db_query_fetch_all('
    SELECT
       ch.id,
       ch.title,
       ca.title AS category
    FROM challenges AS ch
    LEFT JOIN categories AS ca ON ca.id = ch.category
    ORDER BY ca.title, ch.title'
);

form_select($opts, 'Relies on', 'id', $challenge['relies_on'], 'title', 'category');
array_unshift($opts, array('id'=>0, 'title'=> '-- This challenge will become available after the selected challenge is solved (by any user) --'));

form_input_text('Available from', date_time());
form_input_text('Available until', date_time(time() + 31536000));

form_hidden('action', 'new');
form_end();

foot();
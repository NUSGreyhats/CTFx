<?php

require('../../include/mellivora.inc.php');

enforce_authentication(CONST_USER_CLASS_MODERATOR);

head('Site management');
menu_management();

section_title ('Edit CTF Settings');

section_subhead ("Challenge Start / End Times:");
form_start(Config::get('MELLIVORA_CONFIG_SITE_ADMIN_RELPATH') . 'actions/edit_ctf');
form_input_text('CTF Start Time', date_time (Config::get('MELLIVORA_CONFIG_CTF_START_TIME')));
form_input_text('CTF End Time', date_time (Config::get('MELLIVORA_CONFIG_CTF_END_TIME')));
message_inline_blue('You can change the default times from the config file, but you must update the challenges here.');
form_hidden('action', 'change_times');
form_button_submit('Update');
form_end();

foot();
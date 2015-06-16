<?php

// Register the method to expose

$server->register('get_missing_count',
    array('user' => 'xsd:string',
    	'pass' => 'xsd:string',
    	'what' => 'xsd:int'),
    array('return' => 'xsd:int'),
    'urn:askmewsdl',
    'urn:askmewsdl#get_missing_count',
    'rpc',
    'encoded',
    'Get the missing times to fill the possibilities'
);

$server->register('get_update_available',
    array('user' => 'xsd:string',
    	'pass' => 'xsd:string',
    	'version' => 'xsd:string'),
    array('return' => 'xsd:string'),
    'urn:askmewsdl',
    'urn:askmewsdl#get_update_available',
    'rpc',
    'encoded',
    'Get the new version if it is available, else return an empty string'
);

$server->register('get_software_version',
    array('user' => 'xsd:string',
    	'pass' => 'xsd:string',
    	'what' => 'xsd:int'),
    array('return' => 'xsd:string'),
    'urn:askmewsdl',
    'urn:askmewsdl#get_software_version',
    'rpc',
    'encoded',
    'Get software version'
);

$server->register('set_setting',
    array('user' => 'xsd:string',
    	'pass' => 'xsd:string',
    	'id_setting' => 'xsd:int',
    	'val_setting' => 'xsd:string'),
    array('return' => 'xsd:boolean'),
    'urn:askmewsdl',
    'urn:askmewsdl#set_setting',
    'rpc',
    'encoded',
    'Set one setting'
);

$server->register('get_settings',
    array('user' => 'xsd:string',
    	'pass' => 'xsd:string'),
    array('return' => 'xsd:string'),
    'urn:askmewsdl',
    'urn:askmewsdl#get_settings',
    'rpc',
    'encoded',
    'Get the user settings'
);

$server->register('get_categories',
    array('user' => 'xsd:string',
    	'pass' => 'xsd:string'),
    array('return' => 'xsd:string'),
    'urn:askmewsdl',
    'urn:askmewsdl#get_categories',
    'rpc',
    'encoded',
    'Get the user categories'
);

$server->register('get_question',
    array('user' => 'xsd:string',
    	'pass' => 'xsd:string',
    	'category' => 'xsd:int'),
    array('return' => 'xsd:string'),
    'urn:askmewsdl',
    'urn:askmewsdl#get_question',
    'rpc',
    'encoded',
    'Get a question'
);

$server->register('set_question',
    array('user' => 'xsd:string',
    	'pass' => 'xsd:string',
    	'category' => 'xsd:int',
    	'id_word' => 'xsd:int',
    	'responce' => 'xsd:string',
    	'invert' => 'xsd:boolean'),
    array('return' => 'xsd:boolean'),
    'urn:askmewsdl',
    'urn:askmewsdl#set_question',
    'rpc',
    'encoded',
    'Check if the aswer is correct'
);

$server->register('add_word',
    array('user' => 'xsd:string',
    	'pass' => 'xsd:string',
    	'from' => 'xsd:string',
    	'to' => 'xsd:string',
    	'category' => 'xsd:int'),
    array('return' => 'xsd:int'),
    'urn:askmewsdl',
    'urn:askmewsdl#add_word',
    'rpc',
    'encoded',
    'Add a word'
);

$server->register('try_login',
    array('user' => 'xsd:string',
    	'pass' => 'xsd:string'),
    array('return' => 'xsd:boolean'),
    'urn:askmewsdl',
    'urn:askmewsdl#try_login',
    'rpc',
    'encoded',
    'Check username and password'
);

?>

<?php

$event_guid = get_input('event_guid');
$user_guid = get_input('user_guid');

$event = get_entity($event_guid);
$user = get_entity($user_guid);

if (!$user || !$event instanceof \Events\API\Event) {
	register_error(elgg_echo('events:rsvp:not_found'));
	forward(REFERRER, '404');
}

if (!$event->canEdit()) {
	register_error(elgg_echo('events:rsvp:permission_denied'));
	forward(REFERRER, '403');
}

remove_entity_relationship($event->guid, 'invited', $user->guid);
remove_entity_relationship($event->guid, 'access_grant', $user->guid);

system_message(elgg_echo('events:rsvp:uninvite:success'));

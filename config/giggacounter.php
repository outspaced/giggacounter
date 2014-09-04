<?php defined('SYSPATH') or die('No direct access allowed.');

return array(

	'api' => array
	(
		'lastfm' => array
		(
			'api_url'           => 'http://ws.audioscrobbler.com/2.0/?method=user.getpastevents&user=<username>&api_key=<api_key>&format=<result_format>&page=<page>',
			'api_key'           => '',
			'api_name'          => 'lastfm',
			'api_fullname'      => 'Last.FM',
			'api_result_format' => 'json',
				
			'events'   => array
			(
				'key'    => 'events.event',
				'fields' => array
				(
					'date'       => 'startDate',
					'band'       => 'artists.headliner',
					'venue'      => 'venue.name',
					'city'       => 'venue.location.city',
					'country'    => 'venue.location.country',
					'event_type' => NULL						
				),
				'page'        => 'events.@attr.page',
				'total_pages' => 'events.@attr.totalPages'
			),
			'max_count' => 15
		),
		'songkick' => array
		(
			'api_url'           => 'http://api.songkick.com/api/3.0/users/<username>/gigography.<result_format>?apikey=<api_key>&page=<page>',
			'api_key'           => '',
			'api_name'          => 'songkick',
			'api_fullname'      => 'Songkick',	
			'api_result_format' => 'json',
								
			'events'   => array
			(
				'key'    => 'resultsPage.results.event',
				'fields' => array
				(
					'date'       => 'start.date',
					'band'       => array
					(
						'artists'         => 'performance',
						'type_to_extract' => 'Concert',
						'headliner'       => 'headline',
						'billing'         => 'billing',	
						'artist_name'     => 'artist.displayName'	
					),									
					'venue'      => 'venue.displayName',
					'city'       => 'location.city',
					'country'    => 'venue.metroArea.country.displayName',
					'event_type' => 'type'							
				),

			),
			'max_count' => 15
		),
	),

	'counters' => array
	(
		'date'     => 'Date',
		'band'     => 'Band',
		'venue'    => 'Venue',
		'city'     => 'City',
		'country'  => 'Country',		
	),	
		
	'sub_counters' => array
	(
		'date' => array
		(
			'year'    => 'Year', 
			'quarter' => 'Quarter', 
			'month'   => 'Month', 
			'week'    => 'Week'
		)	
	),
);

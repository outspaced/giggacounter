<?php
namespace Giggacounter\Api\Counter;
use Giggacounter\Api\Counter as Counter;

/**
 * Counter-specific class for handling API Counters
 * 
 * @package  Giggacounter
 * @category Counter
 * @author   Alex Brims
 */
class Band extends Counter
{
	/**
	 * @var string
	 */
	protected $_chart_title = 'The bands I\'ve seen the most';
	
	/**
	 * Takes the raw input array from the API and extracts the dates into a single-dimensional 
	 * array.  If the band property in config has been set to an array then this method will
	 * run in full.  Otherwise the parent will be used. 
	 * 
	 * @param  array $array
	 * @return array
	 */
	protected function _extract_target_fields(array $array)
	{
		// If there is an array defined for the config for extracting bands then we need to 
		// use this method.  If not then it's a simpler task that the parent can handle
		if ( ! is_array($this->_config('events.fields.band')))
			return parent::_extract_target_fields($array);
		
		$results = array();

		// Loop through the events from the result, and extract the band field
		foreach (\Arr::path($array, $this->_config('events.key')) as $k => $event)
		{
			// Only concerts for the moment
			if ($this->_is_type_to_extract($event))
			{
				foreach (\Arr::path($event, $this->_config('events.fields.band.artists')) as $performance_key => $performance)
				{
					// Only headliners
					if ($this->_is_headliner($performance))
					{
						$results[] = \Arr::path($performance, $this->_config('events.fields.band.artist_name'));
					}
				}
			}
		}
		
		return $results;
	}
	
	/**
	 * Returns TRUE if the band contained within the passed array is the headliner
	 * 
	 * @param  array  $performance
	 * @return boolean
	 */
	protected function _is_headliner(array $performance)
	{
		if (\Arr::get($performance, $this->_config('events.fields.band.billing')) == $this->_config('events.fields.band.headliner'))
			return TRUE;
		
		return FALSE;
	}
	
	/**
	 * If type to extract has been set in config, and the API result provides an event type, then 
	 * they will be checked against each other.  If either is not set then this will automatically
	 * return TRUE
	 * 
	 * @param  array  $event
	 * @return boolean
	 */
	protected function _is_type_to_extract(array $event)
	{
		if ( ! $this->_config('events.fields.band.type_to_extract'))
			return TRUE;

		if ( ! $this->_config('events.fields.event_type'))
			return TRUE;
		
		if (\Arr::path($event, $this->_config('events.fields.event_type')) == $this->_config('events.fields.band.type_to_extract'))
			return TRUE; 
		
		return FALSE;
	}
}
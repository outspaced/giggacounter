<?php
namespace Giggacounter\Api;

/**
 * Last.FM API
 * 
 * @package  Giggacounter
 * @category API
 * @author   Alex Brims
 */
class Lastfm extends \GiggaCounter\Api
{
	/**
	 * @var string
	 */
	protected $api_name = 'lastfm';	
	
	/**
	 * Should the data-gathering loop continue
	 * 
	 * @param  array  $array
	 * @return boolean
	 */	
	protected function _continue(array $array=array())
	{
		if ( ! empty($array) AND \Arr::path($array, $this->_config('events.page')) < \Arr::path($array, $this->_config('events.total_pages')))
			return TRUE;
		
		return FALSE;
	}
}

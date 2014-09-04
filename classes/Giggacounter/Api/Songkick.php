<?php
namespace Giggacounter\Api;

/**
 * Songkick API
 * 
 * @package  Giggacounter
 * @category API
 * @author   Alex Brims
 */
class Songkick extends \GiggaCounter\Api
{
	/**
	 * @var string
	 */
	protected $api_name = 'songkick';
	
	/**
	 * Should the data-gathering loop continue
	 * 
	 * @param  array  $array
	 * @return boolean
	 */
	protected function _continue(array $array=array())
	{
		// Keep going if there's results
		if (\Arr::path($array, $this->_config('events.key')))
			return TRUE;
		
		return FALSE;
	}
}

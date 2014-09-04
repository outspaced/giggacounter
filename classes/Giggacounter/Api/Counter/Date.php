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
class Date extends Counter
{
	/**
	 * @var string
	 */
	protected $_chart_title = 'When I went to gigs';
	
	/**
	 * Formats the result array according to the desired result
	 * 
	 * @param  string $period
	 * @return array
	 */
	public function get_formatted_results($period=NULL)
	{
		$formatted_dates = array();
		
		foreach ($this->_data as $date)
		{
			switch($period)
			{
				case 'year':
					$key = date('Y', strtotime($date));
				break;	
				case 'quarter':
					$key = date('Y-', strtotime($date));
					$key .= ceil(date('m', strtotime($date)) / 3);				
				break;
				case 'month':
					$key = date('Y-m', strtotime($date));
				break;
				case 'week':
					$key = date('Y-W', strtotime($date));
				break;
			}
			
			$formatted_dates = $this->_add_count($formatted_dates, $key);
		}
		
		$formatted_dates = $this->_zerofill_missing($formatted_dates, $period);
		
		return $formatted_dates;
	}
	
	/**
	 * If any dates don't have a value (and therefore no key), this will 
	 * set the key with a value of 0 
	 * 
	 * @param  array $data
	 * @param  string $period
	 * @return array
	 */
	protected function _zerofill_missing(array $data, $period)
	{
		// Right now this can only handle years
		// @todo Make it handle other date types
		if ($period != 'year')
			return $data;
			
		// Get the first array key to begin with
		list($k) = array_keys($data);
		$previous = $k;
		
		foreach ($data as $key => $value)
		{
			if ($key - $previous > 1)
			{
				for ($i = $key-1 ; $i > $previous ; $i--)
				{
					$data[$i] = 0;
				}
			}
			
			$previous = $key;
		}
		
		ksort($data);
		
		return $data;
	}	
}
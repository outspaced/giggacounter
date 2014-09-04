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
class Venue extends Counter
{
	/**
	 * @var string
	 */
	protected $_chart_title = 'The venues I\'ve been to the most gigs in';
	
}

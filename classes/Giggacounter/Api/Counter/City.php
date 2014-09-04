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
class City extends Counter
{
	/**
	 * @var string
	 */
	protected $_chart_title = 'The cities I\'ve been to the most gigs in';
	
}
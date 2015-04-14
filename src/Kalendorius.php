<?php
/**
* Kalendorius
* Generate calendars for a year or month specific
*
* @author Douglas Cabral <contato@douglascabral.com.br>
*
* To change the language of months and days:
* setlocale(LC_ALL, "pt_BR", "portuguese");
* date_default_timezone_set('America/Sao_Paulo');
* 
* Special Thanks for Rubens Takiguti Ribeiro
* @see http://rubsphp.blogspot.com.br/2011/03/gerando-calendarios-com-php.html
* 
* @license LGPL 3 http://www.gnu.org/licenses/lgpl-3.0.txt
*
* @since 24/03/2015
*
* @version 1.4.3
*/

namespace Kalendorius;

class Kalendorius {
	
	const DAY = '%{DAY}%';
	const MONTH = '%{MONTH}%';
	const MONTH_NAME = '%{MONTH_NAME}%';
	const YEAR = '%{YEAR}%';
	
	protected $events = array();
	
	protected $class_table = 'kalendorius';
	
	protected $class_name_month = 'name-month';
	
	protected $class_day = 'day';
	
	protected $class_day_with_event = 'day-event';
	
	protected $class_days_of_week = 'days-of-week';
	
	protected $class_today = 'today';
	
	protected $class_row = 'row';
	
	protected $class_fill = 'extra';
	
	protected $format_day;
	
	protected $format_day_with_event;
	
	protected $format_month;
	
	protected $format_month_name;
	
	protected $format_year;
	
	
	//
	// Constructor
	//
	public function __construct() {
		$this->format_day = self::DAY;
		$this->format_day_with_event = '<a href="#'. self::MONTH .'-'. self::DAY .'">' . self::DAY . '</a>';
		$this->format_month = self::MONTH;
		$this->format_month_name = self::MONTH_NAME;
		$this->format_year = self::YEAR;
	}
	
	
	//
	// Getters and Setters
	//
	public function get_events() {
		return $this->events;	
	}
	
	
	public function add_event( $timestamp ) {
		$this->events[] = $timestamp;	
	}
	
	
	public function get_class_table() {
		return $this->class_table;	
	}
	
	
	public function set_class_table( $class ) {
		$this->class_table = $class;
	}
	
	
	public function get_class_name_month() {
		return $this->class_name_month;	
	}
	
	
	public function set_class_name_month( $class ) {
		$this->class_name_month = $class;
	}
	
	
	public function get_class_day() {
		return $this->class_day;
	}
	
	
	public function set_class_day( $class ) {
		$this->class_day = $class;	
	}
	
	
	public function get_class_day_with_event() {
		return $this->class_day_with_event;
	}
	
	
	public function set_class_day_with_event( $class ) {
		$this->class_day_with_event = $class;	
	}
	
	
	public function get_class_days_of_week() {
		return $this->class_days_of_week;	
	}
	
	
	public function set_class_days_of_week( $class ) {
		$this->class_days_of_week = $class;	
	}
	
	
	public function get_class_today() {
		return $this->class_today;	
	}
	
	
	public function set_class_today( $class ) {
		$this->class_today = $class;
	}
	
	
	public function get_class_row() {
		return $this->class_row;	
	}
	
	
	public function set_class_row( $class ) {
		$this->class_row = $class;
	}
	
	
	public function get_class_fill() {
		return $this->class_fill;	
	}
	
	
	public function set_class_fill( $class ) {
		$this->class_fill = $class;	
	}
	
	
	public function get_format_day() {
		return $this->format_day;	
	}
	
	
	public function set_format_day( $string ) {
		$this->format_day = $string;	
	}
	
	
	public function get_format_day_with_event() {
		return $this->format_day_with_event;	
	}
	
	
	public function set_format_day_with_event( $string ) {
		$this->format_day_with_event = $string;	
	}
	
	  
	public function get_format_month() {
		return $this->format_month;	
	}
	
	
	public function set_format_month( $string ) {
		$this->format_month = $string;
	}
	
	
	public function get_format_month_name() {
		return $this->format_month_name;	
	}
	
	
	public function set_format_month_name( $string ) {
		$this->format_month_name = $string;
	}
	
	
	public function get_format_year() {
		return $this->format_year;	
	}
	
	
	public function set_format_year( $string ) {
		$this->format_year = $string;
	}
	
	
	/**
	 * Generate calendar for a month 
	 * @param integer $month      Number of month [1-12]
	 * @param integer $year       Number of year (2015)
	 * @param boolean [$fill_days = true] Fill with days of before and after months
     * @return string  HTML 
	 */
	public function from_date($month, $year, $fill_days = true) {
		$time_first_day = mktime(0, 0, 0, $month, 1, $year);
		$time_last_day   = mktime(0, 0, 0, $month + 1, 0, $year);

		$first_day_week = (int)date('w', $time_first_day);
		$last_day       = (int)strftime('%d', $time_last_day);
		$last_day_week  = (int)date('w', $time_last_day);


		// Get names of days of week
		for ($i = 1; $i <= 7; $i++) {
			$time = mktime(0, 0, 0, $month, $i - $first_day_week, $year);
			$name_day[$i] = utf8_encode(strftime('%A', $time));
			$name_day_abbr[$i] = utf8_encode(strftime('%a', $time));
		}

		// Days for exhibition
		$days = array();
		if ($first_day_week != 7) {
			$time_last_day_last_month = mktime(0, 0, 0, $month, 0, $year);
			$last_day_last_month = (int)strftime('%d', $time_last_day_last_month);
			for ($i = $first_day_week - 1; $i >= 0; $i--) {
				$days[] = $fill_days ? $last_day_last_month - $i : '';
			}
		}
		$position_before = count($days);;
		for ($i = 1; $i <= $last_day; $i++) {
			$days[] = $i;
		}
		$position_after = count($days);
		if ($last_day_week < 6) {
			$max = 7 - $last_day_week;
			for ($i = 1; $i < $max; $i++) {
				$days[] = $fill_days ? $i : '';
			}
		} elseif ($last_day_week == 7) {
			for ($i = 1; $i <= 6; $i++) {
				$days[] = $fill_days ? $i : '';
			}
		}

		
		$name_month = $this->_format( $this->format_month_name, $time_first_day );
		
		$table = <<<HTML
		<table class="{$this->class_table}">
			<caption class="{$this->class_name_month}">{$name_month}</caption>
			<thead>
				<tr class="{$this->class_days_of_week}">
	  				<th scope="col"><abbr title="{$name_day[1]}">{$name_day_abbr[1]}</abbr></th>
	  				<th scope="col"><abbr title="{$name_day[2]}">{$name_day_abbr[2]}</abbr></th>
	  				<th scope="col"><abbr title="{$name_day[3]}">{$name_day_abbr[3]}</abbr></th>
	  				<th scope="col"><abbr title="{$name_day[4]}">{$name_day_abbr[4]}</abbr></th>
					<th scope="col"><abbr title="{$name_day[5]}">{$name_day_abbr[5]}</abbr></th>
	  				<th scope="col"><abbr title="{$name_day[6]}">{$name_day_abbr[6]}</abbr></th>
	  				<th scope="col"><abbr title="{$name_day[7]}">{$name_day_abbr[7]}</abbr></th>
				</tr>
			</thead>
			<tbody>

HTML;
		$column = 1;
		
		foreach ($days as $i => $day) {
			
			if ($column == 1) {
				$table .= '<tr class="' . $this->class_row .'">';
			}
			
			$class = ($i < $position_before || $i >= $position_after) ? $this->class_fill : '';
			
			$timestamp_day = null;
			$is_today = '';
			$have_events = false;
			
			if ((int)$day != 0) {
				$timestamp_day = mktime(0, 0, 0, $month, (int)$day, $year);
				$timestamp_day_end = mktime(23, 59, 59, $month, (int)$day, $year);
				$is_today = (mktime(0, 0, 0) == $timestamp_day) ? $this->class_today : '';
				$have_events = $this->_search_events( $timestamp_day, $timestamp_day_end );
				
				if ( $have_events ) {
					$class .= ' ' . $this->class_day_with_event;
				}
			}
			
			$table .= '<td class="' . $class . ' ' . $this->class_day . ' ' . $is_today . '">';
			
			if ( $timestamp_day ) {
				$table .= ($have_events) ? $this->_format( $this->format_day_with_event, $timestamp_day ) : $this->_format( $this->format_day, $timestamp_day );
			} else {
				$table .= $day;
			}
			
			$table .= '</td>';
			
			$column += 1;
			
			if ($column == 8) {
				$table .= '</tr>';
				$column = 1;
			}
		} // foreach
		
		$table .= <<<HTML
	</tbody>
	</table>
HTML;
		return $table;
	}
	
	
	
	/**
	 * Generate calendars from year
	 * @param  integer $year       Number of year (2015)
	 * @param  boolean [$fill_days = true] Fill with days of before and after months
	 * @return string  HTML 
	 */
	public function from_year( $year, $fill_days = true ) {
		$HTML = '';
		
		for ( $i = 1; $i <= 12; $i++ ) {
			$HTML .= $this->from_date($i, $year, $fill_days);
		}
		
		return $HTML;
	}
	
	
	
	/**
	 * Format strings 
	 * @param  string  $string     
	 * @param  integer [$timestamp = 0] Timestamp
	 * @return string  
	 */
	protected function _format( $string, $timestamp = 0 ) {
		
		if ( $timestamp === 0 ) {
			$timestamp = time();	
		}
		
		$day = date('j', $timestamp);
		$month = date('n', $timestamp);
		$year = date('Y', $timestamp);
		
		$search = array(self::DAY, self::MONTH, self::MONTH_NAME, self::YEAR);
		$replace = array($day, $month, $this->_get_name_of_month( $timestamp ), $year);
		
		return str_replace($search, $replace, $string);
	}
	
	
	
	/**
	 * Get name of month
	 * @param  int      $timestamp
	 * @return string 
	 */
	protected function _get_name_of_month( $timestamp ) {
		return utf8_encode(strftime('%B', $timestamp));
	}
	
	
	
	/**
	 * Search a event 
	 * @param  integer $start_timestamp 
	 * @param  integer $end_timestamp   
	 * @return boolean|array Array with events or FALSE if not found events
	 */
	protected function _search_events( $start_timestamp, $end_timestamp ) {
		$result = array();
		
		foreach ( $this->events as $event ) {
			if ( $event >= $start_timestamp && $event <= $end_timestamp ) {
				$result[] = $event;
			}
		}
		
		
		if ( !empty($result) ) {
			return $result;	
		}
		
		return false;
	}
}

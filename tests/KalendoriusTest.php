<?php

include '../Kalendorius.php';

class KalendoriusTest extends PHPUnit_Framework_TestCase {
	
	
	public function testConstants() {
		$this->assertEquals('%{DAY}%', Kalendorius::DAY);
		$this->assertEquals('%{MONTH}%', Kalendorius::MONTH);
		$this->assertEquals('%{MONTH_NAME}%', Kalendorius::MONTH_NAME);
		$this->assertEquals('%{YEAR}%', Kalendorius::YEAR);
	}
	
	
	public function testGettersAndSetters() {

		$calendar = new Kalendorius;
		
		// class_table
		$this->assertEquals('kalendorius', $calendar->get_class_table());
		$calendar->set_class_table('table-calendar');
		$this->assertEquals('table-calendar', $calendar->get_class_table());
			
		
		// class_name_month
		$this->assertEquals('name-month', $calendar->get_class_name_month());
		$calendar->set_class_name_month('month');
		$this->assertEquals('month', $calendar->get_class_name_month());
		
		
		// class_day
		$this->assertEquals('day', $calendar->get_class_day());
		$calendar->set_class_day('day-of-month');
		$this->assertEquals('day-of-month', $calendar->get_class_day());
		
		
		// class_days_of_week
		$this->assertEquals('days-of-week', $calendar->get_class_days_of_week());
		$calendar->set_class_days_of_week('days-of-week-2');
		$this->assertEquals('days-of-week-2', $calendar->get_class_days_of_week());
		
		
		// class_today
		$this->assertEquals('today', $calendar->get_class_today());
		$calendar->set_class_today('special');
		$this->assertEquals('special', $calendar->get_class_today());
		
		
		// class_row
		$this->assertEquals('row', $calendar->get_class_row());
		$calendar->set_class_row('r');
		$this->assertEquals('r', $calendar->get_class_row());
		
		
		// class_fill
		$this->assertEquals('extra', $calendar->get_class_fill());
		$calendar->set_class_fill('fill');
		$this->assertEquals('fill', $calendar->get_class_fill());
		
		
		// format_day
		$this->assertEquals('%{DAY}%', $calendar->get_format_day());
		$calendar->set_format_day('%%%');
		$this->assertEquals('%%%', $calendar->get_format_day());
		
		
		// format_month
		$this->assertEquals('%{MONTH}%', $calendar->get_format_month());
		$calendar->set_format_month('%--%');
		$this->assertEquals('%--%', $calendar->get_format_month());
		
		
		// format_month_name
		$this->assertEquals('%{MONTH_NAME}%', $calendar->get_format_month_name());
		$calendar->set_format_month_name('%mn%');
		$this->assertEquals('%mn%', $calendar->get_format_month_name());
		
		
		// format_year
		$this->assertEquals('%{YEAR}%', $calendar->get_format_year());
		$calendar->set_format_year('--year--');
		$this->assertEquals('--year--', $calendar->get_format_year());
	
	}
	
	
	
	public function testFormat() {
		$objcalendar = null;
		$methodformat = null;
		
		$result = $this->getProtectedAndPrivateMethod('_format', 'Kalendorius', array('%{DAY}%', time()));
		$this->assertEquals( date('j'), $result );
		
		
		$result = $this->getProtectedAndPrivateMethod('_format', 'Kalendorius', array('%{DAY}%/%{MONTH}%', time()));
		$this->assertEquals( date('j') . '/' . date('n'), $result );
		
		
		$result = $this->getProtectedAndPrivateMethod('_format', 'Kalendorius', array('%{DAY}% / %{MONTH}%', time()));
		$this->assertEquals( date('j') . ' / ' . date('n'), $result );
		
		
		$result = $this->getProtectedAndPrivateMethod('_format', 'Kalendorius', array('testOk', time()));
		$this->assertEquals( 'testOk', $result );
		
		
		$result = $this->getProtectedAndPrivateMethod('_format', 'Kalendorius', array('', time()));
		$this->assertEmpty( $result );
	}
	
	
	
	public function testGetNameOfMonth() {
		setlocale(LC_ALL, "pt_BR", "portuguese");
		date_default_timezone_set('America/Sao_Paulo');
		
		$result = $this->getProtectedAndPrivateMethod('_get_name_of_month', 'Kalendorius', array(1430045400));	
		$this->assertEquals('abril', strtolower($result));
	}


	
	private function getProtectedAndPrivateMethod($name, $classname, $params = null, &$objout = null, &$methodout = null) {
  		$class = new ReflectionClass($classname);	
  		$methodout = $class->getMethod($name);
		$methodout->setAccessible(true);
  		$objout = new $classname($params);
  		return $methodout->invokeArgs($objout, $params);
	}
}
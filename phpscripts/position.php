<?php
$curMove = '0';
$direction = 90;
$posx = 0;
$nextPosx = 0;
$posy = 0;
$nextPosy = 0;
define ('DEGREES_BETWEEN_DOTS', 72);
define('CAR_WHEEL_RADIUS', 3);
define('BOUNDARY_X', 101);
define('BOUNDARY_Y', 101);
define('OBSTACLE', 10);
$carIsRunning=TRUE;

function registerMove($movement) {
	global $curMove;
	$curMove = $movement;
}

function recalculateCoordinates() {
	global $curMove, $direction;
	global $posx, $posy, $nextPosx, $nextPosy;

	if($curMove == 'w') {

		$nextPosx = $posx + CAR_WHEEL_RADIUS*deg2rad(DEGREES_BETWEEN_DOTS)*sin(deg2rad($direction));
 		$nextPosy = $posy + CAR_WHEEL_RADIUS*deg2rad(DEGREES_BETWEEN_DOTS)*cos(deg2rad($direction));
	
	} elseif($curMove == 's') {
		$nextPosx = $posx - CAR_WHEEL_RADIUS*deg2rad(DEGREES_BETWEEN_DOTS)*sin(deg2rad($direction));
		$nextPosy = $posy - CAR_WHEEL_RADIUS*deg2rad(DEGREES_BETWEEN_DOTS)*cos(deg2rad($direction));
		$direction = $direction + 160;
	}
}

$prevDIYLeftWheel = 0;


// Default movement and obstacle detection logic
function movementLogic() {

	global $posx, $posy, $curMove, $direction, $DIYdistance_LEFT, $DIYdistance, $DIYdistance_RIGHT, $carIsRunning;
	echo "logic";
	echo $carIsRunning;

		if ( $carIsRunning ) {

			echo " forward ";
			forward();

			/*if (  ( !($DIYdistance_RIGHT < OBSTACLE) || !($DIYdistance_LEFT < OBSTACLE) || !($DIYdistance < OBSTACLE) ) && ( ($curMove != 's') || ($curMove != 'a') || ($curMove != 'd') ) ){
				
				forward();
				echo "empros\n";
				$carIsRunning = TRUE;

			}elseif (($curMove != 'a') && ($DIYdistance_LEFT > $DIYdistance_RIGHT)){
				
				left();
				echo "aristera\n";
				$carIsRunning = TRUE;

			}elseif (($curMove != 'd') && ($DIYdistance_LEFT < $DIYdistance_RIGHT)){
				
				right();
				echo "dexia\n";
				$carIsRunning = TRUE;

			}elseif ( ($DIYdistance_RIGHT < OBSTACLE) && ($DIYdistance_LEFT < OBSTACLE) && ($DIYdistance < OBSTACLE) ) {
				
				stop();
				echo "stop\n";
				$carIsRunning = false;
			}
			else{ 

				forward();
				echo "piso\n";
				$carIsRunning = TRUE;
			}*/

			
		}else{

			stop();
			echo "Stops from position.php";
			$carIsRunning = TRUE;
		}

	
}

function carscript() {

	global $posx, $posy, $nextPosx, $nextPosy, $DIYleftWheel, $DIYrightWheel, $prevDIYLeftWheel, $direction;
	// Car logic for boundaries
	// Recalculate position
	if($DIYleftWheel == 1 && $prevDIYLeftWheel != $DIYleftWheel) {
		recalculateCoordinates();
	}
	$prevDIYLeftWheel = $DIYleftWheel;

	if($nextPosx < 0 || $nextPosx > BOUNDARY_X || $nextPosy < 0 || $nextPosy > BOUNDARY_Y){
		// Out of boundary. Handle same as obstacle.
		echo "It has to stop and rotate" . $direction . "!!";
		
		
		rotateLeft(160);
		$direction = $direction + 160;
		$carIsRunning = TRUE;

		movementLogic();
		recalculateCoordinates();
		echo "Rotated... in bounds again";
		

		
	} else {
		// we are still inside the boundary. Update posx and posy and execute normal logic.
		$posx = $nextPosx;
		$posy = $nextPosy;
		movementLogic();		
	}
	var_dump($posx.' '.$posy.' '.$DIYleftWheel.' '.$prevDIYLeftWheel);

	
}

//echo 'going forward';


// A boundary limit has been detected. Choose a move to avoid
/*function handleBoundary() {
	global $DIYdistance_LEFT, $DIYdistance_RIGHT;
	if($DIYdistance_LEFT > $DIYdistance_RIGHT){
		left();
	}else{
		right();
	}
}*/

// An obstacle has been detected. Choose a move to avoid it

register_shutdown_function(function() {
	shutdown();
});

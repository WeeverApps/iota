<?php
/*
*	R3S Specification PHP Example
*
*	Author:				Robert Gerald Porter
*	Version:			0.8.1
*	License: 			GPL v3.0
*
*	This extension is free software: you can redistribute it and/or modify
*	it under the terms of the GNU General Public License as published by
*	the Free Software Foundation, either version 3 of the License, or
*	(at your option) any later version.
*
*	This extension is distributed in the hope that it will be useful,
*	but WITHOUT ANY WARRANTY; without even the implied warranty of
*	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*	GNU General Public License for more details <http://www.gnu.org/licenses/>.
* 
*/


// Example Channel Class

class R3SChannelMap {

	public 		$thisPage;
	public 		$lastPage;
	public 		$count;
	public 		$type			= "htmlContent";
	public 		$sort;
	public 		$language		= "en-GB"; 
	public 		$copyright;
	public 		$license;
	public 		$generator		= "Cartographer-Content for Joomla 1.5 v0.8";
	public 		$publisher;
	public 		$rating;
	public 		$url;
	public 		$description;
	public  	$geo;
	public 		$name;
	public 		$r3sVersion		= "0.8";
	public 		$relationships;
	public 		$items;

}


// Example Channel Items Class

class R3SItemMap {

	public 		$type;
	public 		$description;
	public 		$name;
	public 		$datetime		= array("published"=>"","modified"=>"","start"=>"","end"=>"");
	public 		$image			= array("mobile"=>"","full"=>"");
	public 		$tags			= array();
	public 		$geo;
	public 		$url;
	public 		$uuid;
	public 		$author;
	public 		$publisher;
	public 		$relationships;

}


// Example htmlContent Details Class

class R3SHtmlContentDetailsMap {

	public 		$html;
	public 		$name;
	public 		$datetime		= array("published"=>"","modified"=>"");
	public 		$image			= array("mobile"=>"","full"=>"");
	public 		$tags			= array();
	public		$geo;
	public 		$url;
	public 		$uuid;
	public 		$author;
	public 		$publisher;
	public 		$generator		= "Cartographer Details R3S Template for Joomla 1.5";
	public 		$copyright;
	public 		$rating;
	public 		$r3sVersion		= "0.8";
	public 		$license;
	public 		$relationships;

}
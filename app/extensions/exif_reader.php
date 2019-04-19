<?php
/*
 * MODIFIED BY X3!!!

 * Exif Reader
 *
 * A small exif reader class intended for quick access to common 
 * data in photos aded by cameras.
 *
 * @author Kenth 'keha76' Hagström <keha1976@gmail.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 * @version 1.0
 **/
class KEHA76_Exif_Reader {
	/**
	 *   Get general EXIF details
	 *   Example of returned data:
	 *
	 *   Array
	 *   (
	 *      [Make] => NIKON CORPORATION
	 *      [Model] => NIKON D7000
	 *      [FocalLength] => 35 mm
	 *      [Exposure] => 10/500
	 *      [Aperture] => f/1.8
	 *      [ShutterSpeed] => 1/50s
	 *      [Date] => 2013:01:01 10:00:09
	 *      [ISO] => 500
	 *  )
	 *
	 *   @access public
	 *   @param string $imagePath 
	 *   @return void
	**/
	public function getDetails($imagePath) {

		// Check if the variable is set and if the file itself exists before continuing
		if(file_exists($imagePath)){

			// There are 2 arrays which contains the information need, so it's easier to state them both
			//$dataIFD0 = exif_read_data($imagePath, 'IFD0', 0);
	    //$dataEXIF = exif_read_data($imagePath, 'EXIF', 0);
	    $dataEXIF = @exif_read_data($imagePath, 'ANY_TAG', 0);

	    // Create exif array
	    $myexif = array();

	    // vals
	    if(isset($dataEXIF['Make'])) $myexif['make'] = $dataEXIF['Make'];
	    if(isset($dataEXIF['Model'])) $myexif['model'] = $dataEXIF['Model'];
	    if(isset($dataEXIF['DateTimeOriginal'])) $myexif['date_taken'] = date('c', strtotime($dataEXIF['DateTimeOriginal']));
	    if(isset($dataEXIF['COMPUTED']['ApertureFNumber'])) $myexif['aperture'] = $dataEXIF['COMPUTED']['ApertureFNumber'];
	    if(isset($dataEXIF['FocalLength'])) $myexif['focal_length'] = $this->getFocalLength($dataEXIF['FocalLength']);
	    if(isset($dataEXIF['ExposureTime'])) $myexif['exposure'] = $dataEXIF['ExposureTime'];
	    if(isset($dataEXIF['ISOSpeedRatings'])) $myexif['iso'] = $dataEXIF['ISOSpeedRatings'];
	    if(isset($dataEXIF['ShutterSpeedValue'])) $myexif['shutter_speed'] = $this->getShutter($dataEXIF);
	    if(isset($dataEXIF['ApertureValue'])) $myexif['f_stop'] = $this->getFstop($dataEXIF['ApertureValue']);

	    // width/height
	    if(isset($dataEXIF['COMPUTED']['Width'])) $myexif['width'] = $dataEXIF['COMPUTED']['Width'];
	    if(isset($dataEXIF['COMPUTED']['Height'])) $myexif['height'] = $dataEXIF['COMPUTED']['Height'];

	    // coordinates location
    	$gps = @$this->get_image_location($dataEXIF);
    	if($gps && count($gps) === 2) {
    		$myexif['latitude'] = $gps[0];
    		$myexif['longitude'] = $gps[1];
    	}

			// return array if not empty
			return $myexif;
	  } else {
			return false;
		}
	}

	private function getFloat($value) {
		$pos = strpos($value, '/');
		if($pos === false) {
			return (float)$value;
		} else {
			$a = (float)substr($value, 0, $pos); 
			$b = (float)substr($value, $pos+1); 
			return ($b == 0) ? ($a) : ($a / $b);
		}
	}

	public function getShutter($exif) {
		$apex    = $this->getFloat($exif['ShutterSpeedValue']); 
		$shutter = pow(2, -$apex);
		if($shutter == 0) return false;
		if($shutter >= 1) return round($shutter) . 's';
		return '1/' . round(1 / $shutter) . 's'; 
	}

	public function getFocalLength($val) {
		$focal = explode('/', $val);
		if(!empty($focal[0]) && !empty($focal[1]) && $focal[0] > 0 && $focal[1] > 0){
			$focalLength = round($focal[0] / $focal[1]);
		} else {
			$focalLength = $focal;
		}
		return $focalLength;
	}

	public function getFstop($val) {
	  $apex  = $this->getFloat($val);
		$fstop = pow(2, $apex/2);
	  if($fstop == 0) return false;
		return 'f/' . round($fstop, 1);
	}

	private function get_image_location($exif){
		$arr = array('GPSLatitudeRef', 'GPSLatitude', 'GPSLongitudeRef', 'GPSLongitude');
		foreach ($arr as $val) {
			if(!isset($exif[$val])) return false;
		}

    $GPSLatitudeRef = $exif[$arr[0]];
    $GPSLatitude    = $exif[$arr[1]];
    $GPSLongitudeRef= $exif[$arr[2]];
    $GPSLongitude   = $exif[$arr[3]];
    
    $lat_degrees = count($GPSLatitude) > 0 ? $this->gps2Num($GPSLatitude[0]) : 0;
    $lat_minutes = count($GPSLatitude) > 1 ? $this->gps2Num($GPSLatitude[1]) : 0;
    $lat_seconds = count($GPSLatitude) > 2 ? $this->gps2Num($GPSLatitude[2]) : 0;
    
    $lon_degrees = count($GPSLongitude) > 0 ? $this->gps2Num($GPSLongitude[0]) : 0;
    $lon_minutes = count($GPSLongitude) > 1 ? $this->gps2Num($GPSLongitude[1]) : 0;
    $lon_seconds = count($GPSLongitude) > 2 ? $this->gps2Num($GPSLongitude[2]) : 0;
    
    $lat_direction = ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
    $lon_direction = ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;
    
    $latitude = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60*60)));
    $longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60*60)));

    return array($latitude, $longitude);
	}

	private function gps2Num($coordPart){
    $parts = explode('/', $coordPart);
    if(count($parts) <= 0)
    return 0;
    if(count($parts) == 1)
    return $parts[0];
    return floatval($parts[0]) / floatval($parts[1]);
	}
}

?>
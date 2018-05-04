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
	    if(@array_key_exists('Make', $dataEXIF)) $myexif['make'] = $dataEXIF['Make'];
	    if(@array_key_exists('Model', $dataEXIF)) $myexif['model'] = $dataEXIF['Model'];
	    if(@array_key_exists('DateTimeOriginal', $dataEXIF)) $myexif['date_taken'] = date('c', strtotime($dataEXIF['DateTimeOriginal']));
	    //if(@array_key_exists('DateTime', $dataEXIF)) $myexif['date_taken'] = date('c', strtotime($dataEXIF['DateTime']));
	    if(@array_key_exists('ApertureFNumber', $dataEXIF['COMPUTED'])) $myexif['aperture'] = $dataEXIF['COMPUTED']['ApertureFNumber'];
	    if(@array_key_exists('FocalLength', $dataEXIF)) $myexif['focal_length'] = $this->getFocalLength($dataEXIF);
	    if(@array_key_exists('ExposureTime', $dataEXIF)) $myexif['exposure'] = $dataEXIF['ExposureTime'];
	    if(@array_key_exists('ISOSpeedRatings', $dataEXIF)) $myexif['iso'] = $dataEXIF['ISOSpeedRatings'];
	    if(@array_key_exists('ShutterSpeedValue', $dataEXIF)) $myexif['shutter_speed'] = $this->getShutter($dataEXIF);
	    if(@array_key_exists('ApertureValue', $dataEXIF)) $myexif['f_stop'] = $this->getFstop($dataEXIF);

	    // width/height
	    if(@array_key_exists('COMPUTED', $dataEXIF)){
	    	if(@array_key_exists('Width', $dataEXIF["COMPUTED"])) $myexif['width'] = $dataEXIF["COMPUTED"]["Width"];
	    	if(@array_key_exists('Height', $dataEXIF["COMPUTED"])) $myexif['height'] = $dataEXIF["COMPUTED"]["Height"];
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

	public function getFocalLength($exif) {
		$focal = explode('/', $exif['FocalLength']);
		if(!empty($focal[0]) && !empty($focal[1]) && $focal[0] > 0 && $focal[1] > 0){
			$focalLength = round($focal[0] / $focal[1]);
		} else {
			$focalLength = $focal;
		}
		return $focalLength;
	}

	public function getFstop($exif) {
	  $apex  = $this->getFloat($exif['ApertureValue']);
		$fstop = pow(2, $apex/2);
	  if($fstop == 0) return false;
		return 'f/' . round($fstop, 1);
	}
}

?>
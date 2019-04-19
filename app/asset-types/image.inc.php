<?php

Class Image extends Asset {

  static $identifiers = array('jpg', 'jpeg', 'gif', 'png');

  function __construct($file_path) {
  	# create and store additional data required for this asset
    $this->set_extended_data($file_path);
    # create and store data required for this asset
    parent::__construct($file_path);
  }

  function set_extended_data($file_path) {
  	# small/large disabled, not used in X3

    # Get image exif
		$ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
    if(extension_loaded('exif') && ($ext === 'jpg' || $ext === 'jpeg' || $ext === 'png')) {
    	$image = new KEHA76_Exif_Reader();
    	$exif = $image->getDetails($file_path);

    	if(!empty($exif)) {

    		# Replace image.date
	    	if(isset($exif['date_taken'])) {
	    		$exif_date = true;
	    		$this->data['date'] = strtotime($exif['date_taken']);
	    	}

	    	# width/height
	    	if(isset($exif['width'])) $this->data['width'] = $exif['width'];
	    	if(isset($exif['height'])) $this->data['height'] = $exif['height'];

        // store EXIF
        $this->data['exif'] = $exif;
    	}
  	}

    # set asset.width & asset.height variables if not set from EXIF.
    $img_data = getimagesize($file_path, $info);
    if(!isset($this->data['width']) || !isset($this->data['height'])){
	    preg_match_all('/\d+/', $img_data[3], $dimensions);
	    $this->data['width'] = $dimensions[0][0];
	    $this->data['height'] = $dimensions[0][1];
    }

    # set iptc variables
    if(isset($info["APP13"])) {
      $iptc = iptcparse($info["APP13"]);

      # asset.title or headline
      if(isset($iptc["2#005"][0])) {
      	$this->data['title'] = $this->utf8_validate($iptc["2#005"][0]);
      } else if(isset($iptc["2#105"][0])){
      	$this->data['title'] = $this->utf8_validate($iptc["2#105"][0]);
      }
      # asset.description
      if(isset($iptc["2#120"][0])) $this->data['description'] = $this->utf8_validate($iptc["2#120"][0]);
      # asset.keywords
      //if(isset($iptc["2#025"][0])) $this->data['keywords'] = $this->utf8_validate($iptc["2#025"][0]);

      // only apply the following IPTC values if "use iptc"
      if(X3Config::$config['back']['use_iptc']) {

	      # image.hidden
	      if(isset($iptc["2#219"][0]) && $iptc["2#219"][0] == '1') $this->data['hidden'] = true;

	      # image reference date
	      if(!isset($exif_date) && isset($iptc["2#047"][0]) && is_numeric($iptc["2#047"][0])) $this->data['date'] = intval($iptc["2#047"][0]);

	      # image link
	      if(isset($iptc["2#217"][0])) $this->data['link'] = $this->utf8_validate($iptc["2#217"][0]);

	      # image link target
	      if(isset($iptc["2#218"][0]) && in_array($iptc["2#218"][0], array('auto','_self','_blank','popup','x3_popup'))) $this->data['target'] = $iptc["2#218"][0];

	      # image custom index
	      if(isset($iptc["2#216"][0]) && is_numeric($iptc["2#216"][0])) $this->data['index'] = intval($iptc["2#216"][0]);

        # image params
        //if(isset($iptc["2#220"][0])) $this->data['params'] = $iptc["2#220"][0];
        if(isset($iptc["2#220"][0])) $this->data['params'] = $this->utf8_validate($iptc["2#220"][0]);
    	}
    }
  }
}

?>
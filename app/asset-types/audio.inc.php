<?php

Class Audio extends Asset {

  static $identifiers = array('mp3', 'ogg');

  function __construct($file_path) {
    # create and store data required for this asset
    parent::__construct($file_path);
    # create and store additional data required for this asset
    $this->set_extended_data($file_path);
  }

  function set_extended_data($file_path) {
    # Get ID3 v2
    $i = new Id3v2;
    $res = $i->read($file_path);
    $this->data['title'] = $res["Title"];
    $this->data['author'] = $res["Artist"];
    $this->data['album'] = $res["Album"];
    $this->data['spotify'] = $res["URL"];
  }

}

Class Id3v2 { 

  public $error;
  
  private $tags = array(
    'TALB' => 'Album',
    'TCON' => 'Genre',
    'TENC' => 'Encoder',
    'TIT2' => 'Title',
    'TPE1' => 'Artist',
    'TPE2' => 'Ensemble',
    'TYER' => 'Year',
    'TCOM' => 'Composer',
    'TCOP' => 'Copyright',
    'TRCK' => 'Track',
    'WXXX' => 'URL',
    'COMM' => 'Comment'
    );
     
  private function decTag($tag, $type)
  {
    //TODO- handling of comments is quite weird
    //but I don't know how it is encoded so I will leave the way it is for now
    if ($type == 'COMM')
    {
      $tag = substr($tag, 0, 3) . substr($tag, 10);
    }
    //mb_convert_encoding is corrupted in some versions of PHP so I use iconv
    switch (ord($tag[2]))
    {
      case 0: //ISO-8859-1
          return iconv('UTF-8', 'ISO-8859-1', substr($tag, 3));
      case 1: //UTF-16 BOM
          return iconv('UTF-16LE', 'UTF-8', substr($tag, 5));
      case 2: //UTF-16BE
          return iconv('UTF-16BE', 'UTF-8', substr($tag, 5));
      case 3: //UTF-8
          return substr($tag, 3);
    }
    return false;
  }
  
  public function read($file)
  {
    $f = fopen($file, 'r');
    $header = fread($f, 10);
    $header = @unpack("a3signature/c1version_major/c1version_minor/c1flags/Nsize", $header);

        if (!$header['signature'] == 'ID3')
    {
      $this->error = 'This file does not contain ID3 v2 tag';   
      fclose($f);
      return false;   
    }

      $result = array();
    for ($i=0; $i<22; $i++)
    {
      $tag = rtrim(fread($f, 6));
      
      if (!isset($this->tags[$tag])) break;
      
      $size = fread($f, 2);
      $size = @unpack('n', $size);
      $size = $size[1]+2;
  
      $value = fread($f, $size);  
      $value = $this->decTag($value, $tag);
  
      $result[$this->tags[$tag]] = $value;
    }
    
    fclose($f);
      return $result; 
  } 
}

?>
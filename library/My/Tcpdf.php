<?php
//require_once('../tcpdf/tcpdf.php');
require_once(str_replace('\\', '/', realpath(dirname(__FILE__) . '/..')).'/tcpdf/tcpdf.php');
class My_Tcpdf extends TCPDF{
	
	public $_data = array();

		
	public function __construct($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false)
	{
		//parent::TCPDF($orientation,$unit,$format,$unicode,$encoding,$diskcache);	
		parent::__construct($orientation,$unit,$format,$unicode,$encoding,$diskcache);	
	}
		
		public function mainTitle($_txt) {
			$this->SetYetY(100);
			//$this->SetFont('arialunicid0','',14);
			//$rgb_arr = convertHTMLColorToDec('#ffdab9');
			$rgb_arr = $this->convertHTMLColorToDec('#000000');
			//$rgb_arr = convertHTMLColorToDec('#ffffff');
			$this->SetFillColor($rgb_arr['R'],$rgb_arr['G'],$rgb_arr['B']);
			$rgb_arr = $this->convertHTMLColorToDec('#84E4F8');			
			$this->SetTextColor($rgb_arr['R'],$rgb_arr['G'],$rgb_arr['B']);			
			//$this->Cell(0,6,$_txt,0,1,'L',1);
			//$this->Ln(4);
			//Save ordinate
			//$this->y0 = $this->GetY();
		}
		
		public function setData($data)
		{
			$this->_data = $data;
		}
		
    //Page header
    public function Header()
    { //global $_dataForm;
        // Logo center
        /*
        $this->Image(K_PATH_IMAGES.'logo.gif','',5,70,'','','','',true,300,'C');
        // Set font
			//$rgb_arr = convertHTMLColorToDec('#000000');
			//$this->SetFillColor($rgb_arr['R'],$rgb_arr['G'],$rgb_arr['B']);
			$rgb_arr = convertHTMLColorToDec('#000000');
			$this->SetTextColor($rgb_arr['R'],$rgb_arr['G'],$rgb_arr['B']);    
		$_y = $this->GetY(); //remember Y-axis
        */
       	// $this->Image(K_PATH_IMAGES.'logo_winsol.png','',5,'','','','','',true,300,'R');
        // Set font
			//$rgb_arr = convertHTMLColorToDec('#000000');
			//$this->SetFillColor($rgb_arr['R'],$rgb_arr['G'],$rgb_arr['B']);
			$rgb_arr = $this->convertHTMLColorToDec('#C50165');
			$this->SetTextColor($rgb_arr['R'],$rgb_arr['G'],$rgb_arr['B']);    
		$_y = $this->GetY(); //remember Y-axis    	
    	$_htmlText = '<span style="font-size:15pt;"><strong>Winsol</strong></span><br />';
    	$_htmlText .= 'Ramen & deuren, rolluiken, poorten, zonwering';
    	$this->writeHTML($_htmlText,true, 0, true, 0,'L');     	    	
    } 	
		
    // Page footer 
    public function Footer() {
        $this->SetY(-12);
    	$_htmlText = '';
    	$this->SetFont("helvetica", "", 8);
    	$this->Ln(0.5);
	$this->writeHTML($_htmlText,true, 0, true, 0,'L');
	$this->Cell(0, 10, 'Pag. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    } 		
}

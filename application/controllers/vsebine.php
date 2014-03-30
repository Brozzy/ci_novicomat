<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vsebine extends CI_Controller {
	
	/* v konstruktorju razreda naložimo vse potrebne razrede, modele in helperje s katerim si v akcijah kontrolerja pomagamo. */
	function __construct() {
		parent::__construct();
		
		/* lažje sestavimo formo */
		$this->load->helper('form');
		
		/* knjižnica s katero pregledujemo backend errorje pri formah. */
		$this->load->library('form_validation');

		/* uporabniški in vsebinski model */
		$this->load->model("UserModel");
		$this->load->model("VsebineModel");
		
		/* Template knjižnica in privzeta templeta (template komponente se nastavljajo v config/template.php) */
		$this->load->library('Template');
		$this->template->set_template("master");
	}
	
	/* Ustvarimo nov prispevek (to je lahko lokacija, dogodek itd..) */
	public function NovPrispevek() {
		/* ustvarimo nov prispevek */
		$Prispevek = $this->VsebineModel->CreatePrispevek();
		
		/* nastavimo spremenljivko, ki bo v view vnesla spremenljivke (primer: "Vsebina" => $Prispevek) v pogledu nastane spremenljivka $Vsebina, ki vsebuje vrednosti spremenljivke $Prispevek v kontrolerju. */  
		$Var = array("Prispevek" => $Prispevek, "User" => $this->UserModel->GetById($this->session->userdata("UserId")));
		
		/* naložimo template in vse njene komponentne poglede oz. partial view-e */
		$this->template->write('Title', 'Dodaj prispevek | novicomat.com');
		$this->template->write_view('Header', '_Header',$Var);
		$this->template->write_view('Panel', '_Panel');
		$this->template->write_view('Content', "Vsebine/Prispevek/_Edit",$Var);
		$this->template->write_view('Footer', '_Footer');
		$this->template->render();
	}
	
	/* Vrnemo prispevek oz. vsebino */
	public function GetPrispevek($PrispevekId) {
		/* Vrnemo vsebino iz baze */
		$Prispevek = $this->VsebineModel->GetById($PrispevekId);
		
		/* vrnemo vse lastnosti uporabnika */
		$User = $this->UserModel->GetById($this->session->userdata("UserId"));
		
		/* nastavimo spremenljivko, ki bo v view vnesla spremenljivke (primer: "Vsebina" => $Prispevek) v pogledu nastane spremenljivka $Vsebina, ki vsebuje vrednosti spremenljivke $Prispevek v kontrolerju. */  
		$Var = array("Prispevek" => $Prispevek, "User" => $User);
		
		/* v primeru, da vsebina še ni pripravljena za vpogled drugim uporabnikom preusmerimo nazaj domov. To se lahko zgodi v primeru, da nekdo direktno vpiše v url id od te vsebine - vendar ni lastnik oz avtor te vsebine. */ 
		if($Prispevek->state > 2 || $Prispevek->created_by == $User->id) {
			 
			/* Če je uporabnik enak avtorju vsebine naložimo urejanje vsebine namesto pogleda - razen, če avtor želi predogled (ForceView) */
			if($User->id == $Prispevek->created_by && !isset($this->input->post["ForceView"]))
				$this->template->write_view('Content', "Vsebine/Prispevek/_Edit",$Var);
			else
				$this->template->write_view('Content', "Vsebine/Prispevek/_View",$Var);
	
			/* nastavimo ostale komponente template */
			$this->template->write('Title', $Prispevek->title.' | novicomat.com');
			$this->template->write_view('Header', '_Header',$Var);
			$this->template->write_view('Panel', '_Panel');
			$this->template->write_view('Footer', '_Footer');
			$this->template->render();
		}
		else redirect(base_url()."Home","refresh");
	}
}

?>
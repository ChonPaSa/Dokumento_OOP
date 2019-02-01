<?php
class PageSwitch{
	//Attributes
	protected $action 		= "";								// switch
	//protected $formData 	= array();							// Form data
	protected $template 	= "views/main.html";	// HTML-Seite
	protected $headline 	= "Bitte melden Sie sich an";	// HTML-Seite
	protected $content 		= "Under construction...."; 		// Seiteninhalt der Unterseite
	protected $navigation	= '<li><a href="?action=home">Startseite</a></li>';
	protected $back			= '<a href="?action=home"><i class="fas fa-caret-square-left"></i></a>';
	
//#############################################SELECTPAGE
	public function selectPage($page)
	{
		$this->action = $page;
		if(isset($_POST["anmelden"]))
		{
			include_once "controller/login.php";
		}
		if (isset($_POST["bestaetigen"]))
			{
				unset($_SESSION["userName"]);
				session_unset();
				session_destroy(); 
			}
		if (isset($_SESSION["userName"]))
		{
			$this->navigation = '<li><a href="?action=home">Startseite</a></li>
								<li><a href="?action=hochladen">Hochladen</a></li>
								<li><a href="?action=suchen">Suchen</a></li>
								<li><a href="?action=verwalten">Verwalten</a></li>
								<li><a href="?action=logout">Logout</a></li>';
		}
		if (isset($_SESSION["url"])&& $this->action != "hochladen2")  //if upload canceled delete file
		{
			unlink($_SESSION["url"]);
			unset($_SESSION["url"]);
		}
		switch($this->action)
		{
			case "home":			$this->actionHome();			break;
			case "hochladen":		$this->actionHochladen(); 		break;
			case "hochladen2":		$this->actionHochladen2(); 		break;
			case "suchen":			$this->actionSuchen();			break;
			case "verwalten":		$this->actionVerwalten();		break;
			case "logout":			$this->actionLogout();			break;
			default:				$this->action404();			
		}
		$htmlFile = file_get_contents($this->template);
		$html = str_replace("{{headline}}", $this->headline, $htmlFile);
		$html = str_replace("{{NAVIGATION}}", $this->navigation, $html);
		$html = str_replace("{{NOTIFICATIONS}}", notifications(), $html);
		$html = str_replace("{{CONTENT}}", $this->content, $html);
		$html= str_replace("{{BACK}}", $this->back, $html);
		return $html;
	}
//############################################################HOME
	public function actionHome()
	{
		if (isset($_SESSION["userName"]))
		{
			$this->headline = "Hallo ".$_SESSION['userName']."! Willkommen in Documento";
			$this->content = file_get_contents("views/home.html");
			$this->back = "";
		}
		else
		{
			$this->headline = "Bitte melden Sie sich an";
			$this->content = file_get_contents("views/login.html");
			$this->back = "";
		}
	}
	
//############################################################HOCHLADEN
	protected function actionHochladen()
	{
		if (isset($_SESSION["userName"]))
		{
			$this->headline = "Hochladen";
			$this->content = file_get_contents("views/hochladen.html");
			if(isset($_FILES["docdatei"]))
			{
				include_once "controller/hochladen.php";
			}
		}
		else
		{
			$this->headline = "Bitte melden Sie sich an";
			$this->content = file_get_contents("views/login.html");
			$this->back = "";
		}
	}
	
	//#########################################################################HOCHLADEN2
	protected function actionHochladen2()
	{
		if (isset($_SESSION["userName"]))
		{
			$this->headline = "Hochladen";
			include_once "controller/hochladen2.php";
			if ((isset($_POST["docname"])) && $_POST["docname"]!="")
			{
				$this->content = replaceValues($doc,"views/confirm.html","disabled");
			}
			else
			{
				$html = file_get_contents("views/hochladen2.html");
				$html = readLabels($html, "");
				$html = readCategories($html);
				$this->content = $html;
			}
		}
		else
		{
			$this->headline = "Bitte melden Sie sich an";
			$this->content = file_get_contents("views/login.html");
			$this->back = "";
		}
	}	

	//################################################################SUCHEN
	protected function actionSuchen()
	{
		if (isset($_SESSION["userName"]))
		{
			include_once "controller/suchen.php";
			$this->back= '<a href="?action=suchen"><i class="fas fa-caret-square-left"></i></a>';
		}
		else
		{
			$this->headline = "Bitte melden Sie sich an";
			$this->content = file_get_contents("views/login.html");
			$this->back = "";
		}
	}
	
	//##########################################################VERWALTEN
	protected function actionVerwalten()
	{
		if (isset($_SESSION["userName"]))
		{
			$this->headline = "Kategorien und Schlagworte Verwalten";
			$table = file_get_contents("views/verwalten.html");
			include_once "controller/verwalten.php";
			$table = str_replace("{{LABELS}}", $printLabel, $table);
			$this->content= str_replace("{{CATEGORIES}}", $printCategory, $table);
		}
		else
		{
			$this->headline = "Bitte melden Sie sich an";
			$this->content = file_get_contents("views/login.html");
			$this->back = "";
		}		
	}
	
	//#################################################LOGOUT
	protected function actionLogout()
	{
		if (isset($_SESSION["userName"]))
		{
			$this->headline = "Logout";
			$this->content = file_get_contents("views/logout.html");
		}
		else
		{
			$this->headline = "Bitte melden Sie sich an";
			$this->content = file_get_contents("views/login.html");
			$this->back = "";
		}		
	}
	protected function action404()
	{
		$this->headline = "Seite Nicht Gefunden";
		$this->content = file_get_contents("views/404.html");
		$this->back = "";
	}
	
}

?>
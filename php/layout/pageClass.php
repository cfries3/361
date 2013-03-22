<?php
	//add in any other content pages
    class Page {

        protected $str_title;
        protected $str_css;
        protected $str_script;
        
        
        public function Page($str_setTitle, $str_setCSS, $str_setScript) {
        	$this->str_title = $str_setTitle;
        	$this->str_css = $str_setCSS;
        	$this->str_script = $str_setScript;
        }
           

        public function display($i_numScripts) {
            echo "<html>\n<head>\n";
            $this->displayTitle();
            $this->displayCSS();
            $this->displayJS($i_numScripts);
            echo "</head>\n" .
				 "<body>\n" .
				 "<div id=\"pageBanner\">\n";
            //page banner
			include('banner.php'); 
            echo <<<_END
				</div>
				<div id="page">
					<div id="main">
						<div id="logo" class="floatLeft">
							<img src="images/logo.png" alt="Company Name" />
						</div>
						<div id="vLine1" class="dividerLine floatLeft"></div>	
						<div id="header" class="floatLeft">
_END;
            //place title of header
            echo "<h1>" . $this->str_title . ".</h1>\n" .
				 "</div>" .
				 "<div id=\"hLine1\" class=\"dividerLine floatLeft\"></div>\n" .
				 "<div id=\"hLine2\" class=\"dividerLine floatLeft\"></div>\n";
            //sidebar navigation
            include('sideNav.php'); 
			echo "<div id=\"vLine2\" class=\"dividerLine floatLeft\"></div>\n";
			//page content
			switch ($this->str_title) {
				case "Project List":
					include('content/projects.php');
					break;
				case "Discussion Board":
					include('content/discussions.php');
					break;
				case "Discussion":
					include('content/posts.php');
					break;
				case "Announcements":
					include('content/announcements.php');
					break;
				case "Check Out":
					include('content/checkOut.php');
					break;
				case "Work Report":
					include('content/reports.php');
					break;
				case "Invoice":
					include('content/invoices.php');
					break;
				case "Accounts":
					include('content/accountList.php');
					break;
				//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			}
			echo "</div>\n" .
				"</div>\n";
			//footer
			include('footer.php');
			echo "</body>\n" .
				 "</html>\n";
        }

        
        protected function displayTitle() {
            echo "<title>" . $this->str_title . "</title>\n";
        }  

        
        protected function displayCSS() {
        	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"./../../css/default.css\" />\n" .
          		 "<link rel=\"stylesheet\" type=\"text/css\" href=\"./../../css/" . $this->str_css . "\" />\n";
        }
        
        
        protected function displayJS($i_numScripts) {
        	$i = 0;
        	
        	echo "<script type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js\"></script>\n";
        	while ($i_numScripts != 0) {
        		echo "<script type=\"text/javascript\" src=\"./../../js/" . $this->str_script[$i] . "\"></script>\n";
        		++$i;
        		--$i_numScripts;
        	}
        }  
        
    }
?>
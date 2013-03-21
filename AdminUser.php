<?php

class AdminUser implements user{


	public function displayButtons( $tid){
		printf('<form action="showPunches.php" method="post">
				<input type="hidden" name="tid" value="%s" />
				<input type="submit" value="show punches"/>
				</form>', $tid);

	}


}








?>
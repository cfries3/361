<?php 

require_once './../databaseFunctions.php';
require_once './../layout/formClass.php';


	
	$i_tid = get_POST('taskID');
	$str_author = get_POST('creator');
	$str_title = get_POST('title');
	$i_uid = $_SESSION['userid'];
	
	//If creating a new topic
	if ($i_tid == 0) {
		echo "<p><b>Create a new topic:</b></p>";
		
		//check if post is set
		if (isset($_POST['Post'])) {
			$i_newTopicID = createTopic($i_uid);
			echo "<p><b>The topic has been created</b></p>";
			

			$eResult = queryMysql("SELECT e.fname, e.lname FROM user AS u INNER JOIN employee AS e ON u.uid = e.uid WHERE u.uid=$i_uid");
			$str_fname = mysql_result($eResult, 0, 'fname');
			$str_lname = mysql_result($eResult, 0, 'lname');
			$str_author = $str_fname . " " . $str_lname;
			toTopic($i_newTopicID, $str_author);
		
		//otherwise display form
		} else {
			$obj_form1 = new Form("reply.php");
			$obj_form1->textField("Topic", 30);
			$obj_form1->textareaField("Post", 30, 5);
			$obj_form1->hiddenField("taskID", $i_tid);
			$obj_form1->hiddenField("creator", $str_author);
			$obj_form1->hiddenField("title", $str_title);
			$obj_form1->closeFormat("Submit");
		}
	
	//If replying to a previous topic
	} else {
		echo "<p>You are responding to " . $str_author . "'s post: <b>" . $str_title . "</b></p>";
		
		//check if post is set
		if (isset($_POST['Post'])) {
			updateTopic($i_tid, $i_uid);
			echo "<p><b>The topic has been updated</b></p>";
			toTopic($i_tid, $str_author);
		
		//otherwise display form
		} else {
			$obj_form2 = new Form("reply.php");
			$obj_form2->textareaField("Post", 30, 5);
			$obj_form2->hiddenField("taskID", $i_tid);
			$obj_form2->hiddenField("creator", $str_author);
			$obj_form2->hiddenField("title", $str_title);
			$obj_form2->closeFormat("Submit");
		}
	}


	
	
	function toTopic($i_tid, $str_author) {
		$obj_return = new Form("topic.php");
		$obj_return->hiddenField("topic_id", $i_tid);
		$obj_return->hiddenField("creator", $str_author);
		$obj_return->closeFormat("Return");
		return;
	}
	
	
	
	function updateTopic($i_tid, $i_uid) {
		$str_comment = get_POST('Post'); 
		
		$result = queryMysql("SELECT p.post_id FROM post AS p INNER JOIN topic AS t ON t.topic_id=p.topic_id WHERE t.topic_id=$i_tid ORDER BY p.pdate DESC LIMIT 1");
		$i_originalID = mysql_result($result, 0, 0);
		queryMysql("INSERT INTO `post`(`pdate`, `body`, `uid`, `topic_id`) VALUES (CURRENT_TIMESTAMP,\"$str_comment\",$i_uid,$i_tid)");
		
		$result = queryMysql("SELECT post_id FROM post WHERE body=\"$str_comment\"");
		$i_postID = mysql_result($result, 0, 0);
		
		queryMysql("INSERT INTO `replied_to`(`reply_id`, `original_id`) VALUES ($i_postID,$i_originalID)");
		
		}
		
		
	
	function createTopic($i_uid) {
		$str_topic = get_post('Topic');
		//add the new topic
		queryMysql("INSERT INTO topic (title, uid) VALUES (\"$str_topic\", $i_uid)");
		
		$result = queryMysql("SELECT topic_id FROM topic WHERE title=\"$str_topic\" AND uid=$i_uid");
		$i_newID = mysql_result($result, 0, 0);
		
		$str_comment = get_post('Post');
		//add the first associated post
		queryMysql("INSERT INTO post (body, uid, topic_id) VALUES (\"$str_comment\", $i_uid, $i_newID)");
		return $i_newID;
	}
	
	
?>
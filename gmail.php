<?php 

class Gmail{

	public function __construct($client){
		$this->client = $client;
	}

	public function readLabels(){

		$service = new Google_Service_Gmail($this->client);

		// Print the labels in the user's account.
		$user = 'me';
		$results = $service->users_labels->listUsersLabels($user);

		$the_html = "";

		if (count($results->getLabels()) == 0) {
 			//print "No labels found.\n";
 			$the_html.="<p>No labels found</p>";
		} else {
			//print "Labels:\n";
			$the_html.="<p>Labels:</p>";
		foreach ($results->getLabels() as $label) {
		    //printf("- %s\n", $label->getName());
			  $the_html.="<p>".$label->getName()."</p>";
			  }
			}

			return $the_html;
	}

	/**
 * Get list of Messages in user's mailbox.
 *
 * @param  Google_Service_Gmail $service Authorized Gmail API instance.
 * @param  string $userId User's email address. The special value 'me'
 * can be used to indicate the authenticated user.
 * @return array Array of Messages.
 */

public function listMessages() {

	$the_html  = "";
	$service = new Google_Service_Gmail($this->client);

		// Print the labels in the user's account.
	$userId = 'me';
	$pageToken = NULL;
	$messages = array();
	$opt_param = array();

	$i = 0;

  do {
  	if($i==3) break;
  	$i++;

    try {
      if ($pageToken) {
        $opt_param['pageToken'] = $pageToken;
      }
      $messagesResponse = $service->users_messages->listUsersMessages($userId, $opt_param);
      if ($messagesResponse->getMessages()) {
        $messages = array_merge($messages, $messagesResponse->getMessages());
        $pageToken = $messagesResponse->getNextPageToken();
      }
    } catch (Exception $e) {
      $the_html.= 'An error occurred: ' . $e->getMessage();
    }
  } while ($pageToken);
  foreach ($messages as $message) {
  	$messageId = $message->getId();
	
	print"<p><a href='detalle_correo.php?id=".$message->getId()."'>Message with ID: " . $message->getId() . "</a></p>";

  }
	

  return $the_html;
}

public function getMessage($messageId) {
  try {
  	$service = new Google_Service_Gmail($this->client);
	$userId = 'me';
    $message = $service->users_messages->get($userId, $messageId);
    $msg .= "<pre>".var_export($message, true). "</pre>";
    print $messageId;
    print $msg;
   
  } catch (Exception $e) {
    print 'An error occurred: ' . $e->getMessage();
  }
}
}

 ?>
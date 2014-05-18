<?php
require 'PHPMailer/class.phpmailer.php';
require_once "XML/RSS.php";
date_default_timezone_set('America/Denver');
//echo "running cl script";
$searchTerms = array('');
apartments and housig 
price 1400 - 20000
dogs, cats, pics
chicrugby@aol.com

//craiglist rss pages
$checkThese = array('apa');

foreach($checkThese as $current)
    checkSite($current,$searchTerms);


    function checkSite($site,$terms)
    {


       $file = "http://boulder.craigslist.org/$site/index.rss";
        $rss =& new XML_RSS($file);
        $rss->parse();
        $today = new DateTime(date('c'));
        $checkInterval = 15;
        
       
        
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug  = 0;
        $mail->Debugoutput = 'html';
        $mail->Host       = 'smtp.gmail.com';
        $mail->Port       = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth   = true;
        $mail->Username   = "sullirobert@gmail.com";
        $mail->Password   = "@1@Beaver!";
        $mail->SetFrom('sullirobert@gmail.com', 'Craigslist Alert');
        $mail->AddReplyTo('sullirobert@gmail.com','Rob Sullivan');
        //$mail->AddAddress('amandru@hotmail.com', 'Amanda Sullivan');
	$mail->AddAddress('sullirobert@gmail.com', 'Robert Sullivan');


        
        foreach ($rss->getItems() as $item) 
        {
	    $listingDate = new DateTime($item['dc:date']);
            $interval = date_diff($listingDate,$today);
            $timeDiff = explode(":",$interval->format('%y:%m:%d:%h:%i'));  
            $totalMins = $timeDiff[4] + ($timeDiff[3] * 60) + ($timeDiff[2] * 60 * 24);
            
            //process if posted within the interval mins
             if($totalMins <= $checkInterval)
                   if( needleTipFind($terms,$item['description']))
                   {
                       $mail->Subject = $item['title'];
                       $link = $item['dc:source']; 
                       //$priceAR = explode("$",$item['title']);
                       //$price = $priceAR[1];
                       $message = $item['description'];
                       $message .= "\n\n\n<br/><br/><br/>";
                       $message .= '<a href="'.$link.'">link</a>';

                       
   			$mail->msgHTML($message);                    
                       
                       
 //                       $mail->Send(); 
                        if (!$mail->send()) {
			    echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
			    echo "Message sent!";
			}

                    }     

        }
    }


    
    function needleTipFind($needleAr, $string)
    {
     /*
     * for each term,  we look at each word and run preg_match to find a match
     */
       //return true;
	 $hayStackAr = explode(" ",  strtolower($string));
        foreach($hayStackAr as $word)  //for each word
            foreach($needleAr as $term) // check if each term is present
              if(preg_match ("/$term/", $word)) //in any part of the word
                return true; // then return true

        return false; // term not found in any word
    }

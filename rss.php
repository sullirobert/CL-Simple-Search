<?php
//$term = $_GET['term'];

$terms = array('antique','vintage','collectible','retro','unique','mid-century','midcentury','mid century','boxes','french','provincial');

//$terms = array('computer','apple');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google AJAX Search API Sample</title>
    <script src="http://www.google.com/jsapi?key=AIzaSyA5m1Nc8ws2BbmPRwKu5gFradvD_hgq6G0" type="text/javascript"></script>
    <script>
function sendMail(message)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    //xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","sendMail.php?message="+message,true);
xmlhttp.send();
}
</script>
    
    
    
    
    <script type="text/javascript">

    
    google.load("feeds", "1");
    
    // Our callback function, for when a feed is loaded.
    function feedLoaded(result) {
      if (!result.error) {
        // Grab the container we will put the results into
        var container = document.getElementById("content");
        container.innerHTML = '';
    
        // Loop through the feeds, putting the titles onto the page.
        // Check out the result object for a list of properties returned in each entry.
        // http://code.google.com/apis/ajaxfeeds/documentation/reference.html#JSON
        for (var i = 0; i < result.feed.entries.length; i++) {
          var entry = result.feed.entries[i];
          //alert(entry.title.indexOf("Wood"));
          var d = new Date();
          var e = new Date(entry.publishedDate);
          
         if(e.getTime() > (d.getTime() - 300000 * 15))
             
         
         if(
          <?php
          for($i = 0; $i < count($terms); $i++)
            {
              if($i == 0)
                echo 'entry.title.indexOf("'.$terms[$i].'") != -1';
              else
                echo ' || entry.title.indexOf("'.$terms[$i].'") != -1';
            }
            ?>
            )
              {
          var div = document.createElement("div");
     
             
          div.appendChild(document.createTextNode(i + ': ' + entry.title));
          container.appendChild(div);
          sendMail(entry.title);
              }
        }
      }
    }
    
    function OnLoad() {
      // Create a feed instance that will grab Digg's feed.
      var feed = new google.feeds.Feed("http://boulder.craigslist.org/zip/index.rss");
    
      feed.includeHistoricalEntries(); // tell the API we want to have old entries too
      feed.setNumEntries(250); // we want a maximum of 250 entries, if they exist
    
      // Calling load sends the request off.  It requires a callback function.
      feed.load(feedLoaded);
    }
    
    google.setOnLoadCallback(OnLoad);
    </script>
  </head>
  <body style="font-family: Arial;border: 0 none;">
      <form method="get" action="rss.php">search for:<input name="term" /></form>
    <div id="content">Loading...</div>
  </body>
</html>
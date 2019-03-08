<a href="search.html">Back</a><br>

<?php
// function to clean up the userinput
function cleanSearchTerms($arg) {
    return  explode(" ", preg_replace("/[^a-zA-Z0-9]+/", " ", strtolower(trim($arg))));
}

// function to check if string containts all items in a list
function contains_all($str,array $words) {
    if(!is_string($str))
        { return false; }

    foreach($words as $word) {
        if(!is_string($word) || stripos($str,$word)===false)
            { return false; }
    }
    return true;
}


//convert user input into an array of clean search terms
$searchQuery = $_POST["searchQuery"];
$searchTerms= cleanSearchTerms($searchQuery);
usort($searchTerms, function($a, $b) {return strlen($b) <=> strlen($a);}); //Sort searchTerms on lenght to perform search faster


//read text file
$lines = file('merged.txt');

//show info about search query and txt
echo count($lines) . " links in the database <br> You searched for " . $searchQuery . "<br>"; 


//Saveing timestamp for later
$timeBeforeSearch = microtime(true);

//search for matches
$searchResults = array();

foreach($lines as $line)
{
  if(contains_all($line, $searchTerms))
  {
    array_push($searchResults, $line);
  }
}


//Calculate how long searching took
$searchingTime = round((microtime(true) - $timeBeforeSearch),2) ;

//show results
echo count($searchResults) . " links found in " . $searchingTime . " seconds<br>"; 

echo "<ol>"; 
foreach($searchResults as $result)
{
    echo "<li><a href='".$result."'>$result</a></li><br>";
}
echo "</ol>"; 


// If the text was not found, show a message
if (empty($searchResults))
{
  echo 'No match found';
}
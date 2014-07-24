 <?php
class SimpleParser
{

    ## First off, the data this class needs in order to work.
    
    //List of Smileys
    private $smileyList = array(
        //'smileySymbol' => 'smiley image code';
        ':)'    =>  '<img src="images/emoticons/smiley-02.svg" class="emoticon" alt=":)" />',
        ':('    =>  '<img src="images/emoticons/smiley-16.svg" class="emoticon" alt=":(" />',
		':-('   =>  '<img src="images/emoticons/smiley-16.svg" class="emoticon" alt=":-(" />',
        ':D'    =>  '<img src="images/emoticons/smiley-13.svg" class="emoticon" alt=":D" />',
        ':-D'   =>  '<img src="images/emoticons/smiley-13.svg" class="emoticon" alt=":-D" />',
        ';)'    =>  '<img src="images/emoticons/smiley-04.svg" class="emoticon" alt=";)" />',
		';-)'   =>  '<img src="images/emoticons/smiley-04.svg" class="emoticon" alt=";-)" />',
        ':o'    =>  '<img src="images/emoticons/smiley-06.svg" class="emoticon" alt=":o" />',
		':-o'   =>  '<img src="images/emoticons/smiley-06.svg" class="emoticon" alt=":-o" />',
        ':p'    =>  '<img src="images/emoticons/smiley-05.svg" class="emoticon" alt=":p" />',
		":-p"   =>  '<img src="images/emoticons/smiley-05.svg" class="emoticon" alt=":-p" />',
        ':/'    =>  '<img src="images/emoticons/smiley-07.svg" class="emoticon" alt=":/" />',
        ':['    =>  '<img src="images/emoticons/smiley-08.svg" class="emoticon" alt=":[" />',
		'8-)'   =>  '<img src="images/emoticons/smiley-22.svg" class="emoticon" alt="8-)" />',
		'8)'    =>  '<img src="images/emoticons/smiley-22.svg" class="emoticon" alt="8)" />',
		":'("   =>  '<img src="images/emoticons/smiley-15.svg" class="emoticon" alt=":\'(" />',
		":'-("  =>  '<img src="images/emoticons/smiley-15.svg" class="emoticon" alt=":\'-(" />',
		":s"    =>  '<img src="images/emoticons/smiley-10.svg" class="emoticon" alt=":s" />',
		":-s"   =>  '<img src="images/emoticons/smiley-10.svg" class="emoticon" alt=":-s" />',
		":x"    =>  '<img src="images/emoticons/smiley-20.svg" class="emoticon" alt=":x" />',
		":-x"   =>  '<img src="images/emoticons/smiley-20.svg" class="emoticon" alt=":-x" />',
		"tune"   =>  '<img src="images/emoticons/tune.png" class="emoticon" alt="tune" />',
		"alien"   =>  '<img src="images/emoticons/alien.png" class="emoticon" alt="alien" />',
		"grenade"   =>  '<img src="images/emoticons/handGrenade.png" class="emoticon" alt="grenade" />',
		"<3"   =>  '<img src="images/emoticons/heart.png" class="emoticon" alt="loveIt" />',
		"(^^)"   =>  '<img src="images/emoticons/onFire.png" class="emoticon" alt="onFire" />',
		"thumbsUp"   =>  '<img src="images/emoticons/thumbsUp.png" class="emoticon" alt="thumbsUp!" />',
		">:>"   =>  '<img src="images/emoticons/smiley-27.svg" class="emoticon" alt="devil" />',
		">:->"   =>  '<img src="images/emoticons/smiley-27.svg" class="emoticon" alt="devil" />',
		"o:-)"   =>  '<img src="images/emoticons/smiley-28.svg" class="emoticon" alt="angel" />',
		"O:-)"   =>  '<img src="images/emoticons/smiley-28.svg" class="emoticon" alt="angel" />',
    );
    //Bad word list
    //private $badWordList = array('orange','apple','carrot','grape','pea');
    //Word to Replace with
    //private $goodWord = 'bacon';
    
    ## Main Functions to interact with class
    public function parseText($text,$smileys=1,$badwords=1){
        $text = str_replace('://','#link#',$text);
        //run
        if($smileys==1){
            $text = $this->parseSmiley($text);
        }
        #if($badwords==1){
        #   $text = $this->parseBadWords($text);
        #}
        //fix
        return str_replace('#link#','://',$text);
    }
    //get back orignal string
    public function unParseText($text){
        return $this->unParseSmiley($text);
    }
    
    ## Functions to perform actions

    private function parseSmiley($text){
        return str_ireplace(array_keys($this->smileyList),$this->smileyList,$text);
    }
    private function unParseSmiley($text){
        return str_replace($this->smileyList,array_keys($this->smileyList),$text);
    }
    private function parseBadWords($text){
        return str_replace($this->badWordList,$this->goodWord,$text);
    }
}
?> 
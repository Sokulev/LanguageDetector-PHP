<?php
/**
 * MIT License
 * ===========
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
 * CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @author      Dmitry Sokulev
 * 
 */

/**
* TextTools PHP class
*
* @version 		0.1
*/
class TextTools {
	
	/**
	* Format and cleanup text using various methodics
	*
	* @param string $text text to format and clean
	* @return string formatted and cleaned text
	*/
	private static function formatText($text) {
		$string = str_replace(array("\r\n","(",")",":",";"," / ",","," - ","\"","'"," \ ","\n","\r")," . ",$text);
		$string = preg_replace('~[^\\pL0-9_.]+~u'," ",$string);
		$string = preg_replace( "/\b[^\s\w]{1,4}\b/" , " ", $string);
		$string = preg_replace( "/ {2,}/" , " " , $string );
		$string = preg_replace( "/\.{2,}/" , "." , $string );
		$string = trim( mb_strtolower( $string, 'utf-8' ) );
		return $string;
	}	  
	
	/**
	* Extract 2 and 3 words phrases from text
	*
	* @param string $text text to extract phrases
	* @param integer $minimum_count method will ignore any phrase which occur in text less than $minimum_count times
	* @return string Array associative array of phrases and their statistics
	*/	
	public static function getPhrases($text, $minimum_count = 0) {
		$text = self::formatText($text);
		
		$array=explode(".",$text);
		for($i=0, $counti=count($array); $i<$counti; $i++) {

			$sentence=trim($array[$i]);
			$sen_array=explode(" ",$sentence);
			
			for ($j = 0,$countj = count($sen_array);$j < $countj;$j++) {
				
				// Store phrases consisting of two words
				if($j+1<$countj) {
					$phrase=trim($sen_array[$j])." ".trim($sen_array[$j+1]);					
					if(isset($phrase_array[$phrase])) {
						$phrase_array[$phrase]["phrase_count"]++;
					}
					else {
						$phrase_array[$phrase]["phrase"]=$phrase;
						$phrase_array[$phrase]["phrase_words_count"]=2;
						$phrase_array[$phrase]["phrase_count"]=1;
					}
				}
				
				// Store phrases1 consisting of three words
				if($j+2<$countj) {
					$phrase=trim($sen_array[$j])." ".trim($sen_array[$j+1])." ".trim($sen_array[$j+2]);
					if(isset($phrase_array[$phrase])) {
						$phrase_array[$phrase]["phrase_count"]++;
					}
					else {
						$phrase_array[$phrase]["phrase"]=$phrase;
						$phrase_array[$phrase]["phrase_words_count"]=3;
						$phrase_array[$phrase]["phrase_count"]=1;
					}
				}			
			}
		}

		// Exclude phrases which appear less than $minimum_count times
		while(list($key)=each($phrase_array)) {
			if($phrase_array[$key]["phrase_count"]<$minimum_count) {
				unset($phrase_array[$key]);
			}
		}

		return $phrase_array;
	}	
}

?>
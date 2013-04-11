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
 * @link        Demo page: http://www.sokulev.com/LanguageDetector/demo.php
 * 
 */

/**
* LanguageDetector PHP class
*
* @version     0.5
*
* Phrase-Based Statistical Language Detection.
*
* It is just a Demo Class.
* Detection rate is not excelent and could be greatly improved with some methodics.
* Chinese and Japanese detection rate is poor.
*
* Phrases database based on websites' titles and descriptions from DMOZ Open Directory Project 
*
*/
class LanguageDetector {
	private $languageCodes = array ( 10 => "English", 11 => "Afrikaans", 12 => "Arabic", 13 => "Armenian", 14 => "Asturianu", 15 => "Azerbaijani", 16 => "Bahasa_Indonesia", 17 => "Bahasa_Melayu", 18 => "Bangla", 19 => "Bashkir", 20 => "Belarusian", 21 => "Bosanski", 22 => "Brezhoneg", 23 => "Bulgarian", 24 => "Catala", 25 => "Cesky", 26 => "Chinese_Simplified", 27 => "Chinese_Traditional", 28 => "Cymraeg", 29 => "Dansk", 30 => "Deutsch", 31 => "Eesti", 32 => "Espanol",33 => "Esperanto", 34 => "Euskara", 35 => "Francais", 36 => "Frysk", 37 => "Furlan", 38 => "Foroyskt", 39 => "Gaeilge", 40 => "Gaidhlig", 41 => "Galego", 42 => "Greek", 43 => "Gujarati", 44 => "Hebrew", 45 => "Hindi", 46 => "Hrvatski", 47 => "Interlingua", 48 => "Islenska", 49 => "Italiano", 50 => "Japanese", 51 => "Kannada", 52 => "Kaszebsczi", 53 => "Kazakh", 54 => "Kiswahili", 55 => "Korean", 56 => "Kurdi", 57 => "Kyrgyz", 58 => "Latviski", 59 => "Letzebuergesch", 60 => "Lietuviu", 61 => "Lingua_Latina", 62 => "Magyar", 63 => "Makedonski", 64 => "Marathi", 65 => "Nederlands", 66 => "Nordfriisk", 67 => "Norsk", 68 => "O'zbekcha", 69 => "Occitan", 70 => "Ossetian", 71 => "Persian", 72 => "Polski", 73 => "Portugues", 74 => "Punjabi_Gurmukhi", 75 => "Romana", 76 => "Rumantsch", 77 => "Russian", 78 => "Sardu", 79 => "Seeltersk", 80 => "Shqip", 81 => "Sicilianu", 82 => "Sinhala", 83 => "Slovensko", 84 => "Slovensky", 85 => "Srpski", 86 => "Suomi", 87 => "Svenska", 88 => "Tagalog", 89 => "Taiwanese", 90 => "Tamil", 91 => "Tatarca", 92 => "Telugu", 93 => "Thai", 95 => "Turkce", 96 => "Turkmence", 97 => "Ukrainian" );
	private $DB;
	private $resultCount;
	
	/**
	* Constructor
	*
	* @param DB $DB MySQLi object class
	* @param integer $resultCount max number of detected languages to return
	*/	
	public function __construct(DB $DB, $resultCount = 2) { 
		$this->resultCount = $resultCount;
		$this->DB = $DB;
	}
	
	/**
	* Detect languages
	*
	* @param string Array $phrases associative Array of text phrases
	* @return string Array of detected languages: key-value = language-percent or false if languages not detected
	*/	
	public function execute($phrases) {
		if(count($phrases)>0) {

			// Prepare SQL query
			$array_keys = "(hash=UNHEX(MD5('".implode("')))or(hash=UNHEX(MD5('",array_keys($phrases))."')))";
			$sql="select count(language_id) count, language_id from lang_phrases where (".$array_keys.") group by language_id order by count desc limit ".$this->resultCount;
			
			$this->DB->Query($sql);
			$result = $this->DB->Get();
			
			// Store received data into Array
			if(count($result)>0) {	
				while(list($row) = each($result)) {	
					$retArray[$this->languageCodes[$result[$row]["language_id"]]] = $result[$row]["count"];
					$summPercent += $result[$row]["count"];
				}
			}
			else {
					
				return false;
			}
		}

		// Adjust percentage of each language
		while(list($key) = each($retArray)) {	
			$retArray[$key] = floor(100/$summPercent*$retArray[$key]);
		}
		
		reset($retArray);
		return $retArray;
	}
}
?>

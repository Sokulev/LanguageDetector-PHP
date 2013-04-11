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
 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-Type: text/html; charset=UTF-8");?>
<!doctype html>
<html>
<head>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<style>
		#texttoanalyseid {width: 550px; height: 250px; border: 1px solid #777777; padding: 5px}
		body {margin: auto; width: 700px}
		#resultid {height: 30px}
	</style>
	<script language="javascript">
		function detectLanguages() {
			var page = $.ajax({
					type: 'POST',
					data: $("form").serialize(),
					url: "demo_server_side.php",
					dataType: "HTML",
					async: false
				 }).responseText;
			$("#resultid").text(page);
		}
	</script>	
</head>
<body>
Demo. LanguageDetector Class by Dmitry Sokulev.<br /><br />
<form>
	Paste a Text ( 50 words or more ) :<br />
	<textarea id="texttoanalyseid" name="texttoanalyse">
1925 - The novel The Great Gatsby by F. Scott Fitzgerald (pictured) was first published.

1970 - In the midst of business disagreements with his bandmates, Paul McCartney announced his departure from The Beatles.

Massachusetts Institute of Technology (MIT) is a private research university located in Cambridge, Massachusetts, United States.

Die Lagrange-Punkte (benannt nach dem heute vor 200 Jahren verstorbenen Mathematiker Joseph-Louis Lagrange) oder Librations-Punkte (vom lateinischen librare fur "schwanken" oder "das Gleichgewicht halten") sind die Gleichgewichts-punkte des eingeschrankten Dreikorper-problems in der Himmelsmechanik.

		/ Sample texts borrowed from Wikipedia / </textarea>
	<div id="resultid"></div>
	<input type="button" value="Detect languages" onclick="detectLanguages()" />
</form>

</body>
</html>

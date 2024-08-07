<?php
$html="<p>This is a HTML</p> <b>This is a strip tag function</b> <span>jjjkkk</span>";
$strip=strip_tags($html,'<p>');
echo $strip;
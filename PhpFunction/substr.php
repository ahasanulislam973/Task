<?php
echo  substr("hello world",6)."<br>"; // Here which length(offset) is mentioned, the function will return the value mentioned length and after the rest of the word from the string.
echo substr("hello World",0,2)."<br>";  // offset 0 means return word from 0  and length 2 means returning word length is 2.
echo substr("Hello world",-5); // return the word from last.
<?php
    $template = "Student (Age) Name years old, has done Performance, and the passing status is Passed";
    $file = fopen("sample.csv","r");
    if ($file ==null) die("File does not exist");

    $columns=fgetcsv($file);
    while (!feof($file))    {
        $values = fgetcsv($file);
        $out = str_replace($columns, $values, $template);
        echo $out."\n\r";
    }
?>

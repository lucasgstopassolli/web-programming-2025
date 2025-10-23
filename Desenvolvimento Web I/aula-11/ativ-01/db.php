<?php

$connectionString = "
    host=localhost
    port=5432
    dbname=local
    user=postgres
    password=postgres
    ";
$connection = pg_connect($conectionString);

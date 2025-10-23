<?php

$connectionString = "
    host=localhost
    port=5432
    dbname=CleberClass
    user=postgres
    password=postgres
    ";

$connection = pg_connect($connectionString);
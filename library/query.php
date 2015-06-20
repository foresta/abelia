<?php

class Query {

  const FILE_EXT = ".sql";

  public static function get($sqlFilePath){
    $query = @file_get_contents(QUERY_DIR . $sqlFilePath . self::FILE_EXT);
    return $query;
  }
}

<?

class Book extends Dormio_Model {
  static $meta = array(
    'fields' => array(
      'pk' => array('type' => 'ident', 'sql_column' => 'id'),
      'title' => array('type' => 'string', 'max_length' => 255),
      'isbn' => array('type' => 'string', 'max_length' => 24),
      'price' => array('type' => 'float'),
      'author' => array('type' => 'foreignkey', 'model' => 'Author'),
    ),
  );
  //static function getMeta() { return self::$meta; }
}

class Author extends Dormio_Model {
  static $meta = array(
    'fields' => array(
      'pk' => array('type' => 'ident', 'sql_column' => 'id'),
      'first_name' => array('type' => 'string', 'max_length' => 128),
      'last_name' => array('type' => 'string', 'max_length' => 128),
      'email' => array('type' => 'string', 'max_length' => 128),
      'books' => array('type' => 'reverse', 'model' => 'Book'),
    ),
  );
  //static function getMeta() { return self::$meta; }
}
?>
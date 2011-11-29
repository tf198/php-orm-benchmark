<?

class Book extends Dormio_Model {
  static $meta = array(
    'fields' => array(
      'pk' => array('type' => 'ident', 'db_column' => 'id'),
      'title' => array('type' => 'string', 'max_length' => 255),
      'isbn' => array('type' => 'string', 'max_length' => 24),
      'price' => array('type' => 'float'),
      'author' => array('type' => 'foreignkey', 'model' => 'Author'),
    ),
  );
}

class Author extends Dormio_Model {
  static $meta = array(
    'fields' => array(
      'pk' => array('type' => 'ident', 'db_column' => 'id'),
      'first_name' => array('type' => 'string', 'max_length' => 128),
      'last_name' => array('type' => 'string', 'max_length' => 128),
      'email' => array('type' => 'string', 'max_length' => 128),
      'books' => array('type' => 'reverse', 'model' => 'Book'),
    ),
  );
}
?>
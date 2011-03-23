<?
return array(
  'connection' => array(
    'dsn' => 'sqlite::memory:',
    'dialect' => 'sqlite'
  ),
  'classes' => array(
    'Book' => array(
      'table' => 'book',
      'props' => array(
        'ID' => array('id', 'int', array('pk' => true, 'autoIncrement' => true)),
        'Title' => array('title', 'varchar'),
        'ISBN' => array('isbn', 'varchar'),
        'Price' => array('price', 'float'),
        'AuthorID' => array('author_id', 'int'),
      ),
      'associations' => array(
        array('many-to-one', 'Author', array('key' => 'AuthorID'))
      ),
    ),
    'Author' => array(
      'table' => 'author',
      'props' => array(
        'ID' => array('id', 'int', array('pk' => true, 'autoIncrement' => true)),
        'FirstName' => array('first_name', 'varchar'),
        'LastName' => array('last_name', 'varchar'),
        'Email' => array('email', 'varchar'),
      ),
      'associations' => array(
        array('one-to-many', 'Book', array('key' => 'AuthorID')),
      ),
    ),
  ),
)
?>
<?php

require_once dirname(__FILE__) . '/../AbstractTestSuite.php';

/**
 * This test suite just demonstrates the baseline performance without any kind of ORM
 * or even any other kind of slightest abstraction.
 */
class OptDormioTestSuite extends AbstractTestSuite
{
	function initialize()
	{
    
    require('vendor/dormio/classes/dormio/autoload.php');
    Dormio_Autoload::register();
    require('models.php');
    
    $this->con = Dormio_Factory::PDO(array('connection' => 'sqlite::memory:'));
    $this->initTables();
    
    $dormio = new Dormio_Factory($this->con);
    
    $books = $dormio->manager('Book');
    $authors = $dormio->manager('Author');
    
    $this->author = $dormio->get('Author');
    
    $this->author_insert = $authors->insert(array('first_name', 'last_name'));
    $this->book_insert = $books->insert(array('title', 'author', 'isbn', 'price'));
    
    $this->hydration_set = $books->filter('price', '>', &$this->_hydrate_id)->limit(5);
    $this->with_set = $books->with('author')->filter('title', '=', &$this->_with_title)->limit(1);
    
    $this->complex_set = $authors
      ->where('{pk} > ? OR ({first_name} || {last_name}) = ?', array(&$this->_complex_id, 'John Doe'));
    $this->complex_aggregator = $this->complex_set->aggregate()->count();
      
    $this->fk_set = $books->with('author');
    $this->related_set = $authors->filter('first_name', '=', &$this->_related_name);
	}
	
	function clearCache()
	{
	}
	
	function beginTransaction()
	{
		$this->con->beginTransaction();
	}
	
	function commit()
	{
		$this->con->commit();
	}
	
	function runAuthorInsertion($i)
	{
    $this->author_insert->execute(array('John' . $i, 'Doe' . $i));
		$this->authors[]= $this->con->lastInsertId();
	}

	function runBookInsertion($i)
	{
    $this->book_insert->execute(array(
      'Hello'.$i,
      $this->authors[array_rand($this->authors)],
      '1234',
      $i
    ));
		$this->books[]= $this->con->lastInsertId();
	}
	
	function runPKSearch($i)
	{
    $this->author->load($this->authors[array_rand($this->authors)]);
    $this->author->first_name; // not hydrated until access
	}
	
	function runHydrate($i)
	{
    //$set = $this->book_manager->filter('price', '>', $i)->limit(5);
    $this->_hydrate_id = $i;
    foreach($this->hydration_set as $book) {
      //echo "{$book->title}\n";
    };
	}

	function runComplexQuery($i)
	{
    $this->_complex_id=$this->authors[array_rand($this->authors)];
    $sums = $this->complex_aggregator->run();
	}
	
	function runJoinSearch($i)
	{
    //$set = $this->book_manager->with('author')->filter('title', '=', 'Hello' . $i)->limit(1);
    $this->_with_title = 'Hello' . $i;
    $this->with_set->rewind(); // this runs the query
    //var_dump($this->with_set->current());
	}
  
  function runForeignKey($i) {
    // get a random book and show the authors name
    $book = $this->fk_set->get($this->books[array_rand($this->books)]);
    $book->author->first_name;
  }
  
  function runRelated($i) {
    $this->_related_name = 'John' . $i;
    // load an author by first name and display all their books
    $author = $this->related_set->get();
    //foreach($this->author->books as $book) {}
  }
}
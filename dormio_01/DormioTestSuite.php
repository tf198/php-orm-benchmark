<?php

require_once dirname(__FILE__) . '/../AbstractTestSuite.php';

/**
 * This test suite just demonstrates the baseline performance without any kind of ORM
 * or even any other kind of slightest abstraction.
 */
class DormioTestSuite extends AbstractTestSuite
{
	function initialize()
	{
    
    require_once dirname(__FILE__) . '/vendor/dormio/classes/dormio/autoload.php';
    Dormio_Autoload::register();
    require_once 'models.php';
    
    $this->con = Dormio_Factory::PDO(array('connection' => 'sqlite::memory:'));
    
    //Dormio_Factory::init($this->con);
    $this->dormio = new Dormio_Factory($this->con);
    
		$this->initTables();
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
		$author = $this->dormio->get('Author');
    $author->first_name = 'John' . $i;
		$author->last_name = 'Doe' . $i;
		$author->save();
		$this->authors[]= $author->ident();
	}

	function runBookInsertion($i)
	{
    $book = $this->dormio->get('Book');
    $book->title = 'Hello'.$i;
		$book->author = $this->authors[array_rand($this->authors)];
		$book->isbn = '1234';
		$book->price = $i;
		$book->save();
		$this->books[]= $book->ident();
	}
	
	function runPKSearch($i)
	{
    $author = $this->dormio->get('Author', $this->authors[array_rand($this->authors)]);
    $author->first_name; // not hydrated until access
	}
	
	function runHydrate($i)
	{
    $books = $this->dormio->manager('Book');
    $set = $books->filter('price', '>', $i)->limit(5);
    foreach($set as $book) {}
	}

	function runComplexQuery($i)
	{
    $authors = $this->dormio->manager('Author');
    $c = $authors
      ->where('{pk} > ? OR ({first_name} || {last_name}) = ?', array($this->authors[array_rand($this->authors)], 'John Doe'));
    $sums = $c->aggregate()->count()->run();
    //var_dump($sums);
	}
	
	function runJoinSearch($i)
	{
    $books = $this->dormio->manager('Book');
    $set = $books->with('author')->filter('title', '=', 'Hello' . $i)->limit(1);
    $set->rewind(); // this runs the query
	}
  
  function runForeignKey($i) {
    // get a random book and show the authors name
    $book = $this->dormio->get('Book', $this->books[array_rand($this->books)]);
    $book->author->first_name;
  }
  
  function runRelated($i) {
    // load an author by first name and display all their books
    $authors = $this->dormio->manager('Author');
    $author = $authors->filter('first_name', '=', 'John' . $i)->get();
    foreach($author->books as $book) {}
  }
}
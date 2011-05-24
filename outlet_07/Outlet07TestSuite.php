<?php

require_once dirname(__FILE__) . '/../AbstractTestSuite.php';

/**
 * This test suite just demonstrates the baseline performance without any kind of ORM
 * or even any other kind of slightest abstraction.
 */
class Outlet07TestSuite extends AbstractTestSuite
{
	function initialize()
	{
    
    require_once('models.php');
    require_once('vendor/outlet/classes/outlet/Outlet.php');
    
    $config = include('config.php');
    
    Outlet::init($config);
    $this->outlet = Outlet::getInstance();
    $this->outlet->createProxies();
   
    $this->con = $this->outlet->getConnection();
   
		$this->initTables();
	}
	
	function clearCache()
	{
    $this->outlet->clearCache();
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
    $author = new Author;
    $author->FirstName = "John{$i}";
    $author->LastName = "Doe{$i}";
    $this->outlet->save($author);
    $this->authors[] = $author->ID;
	}

	function runBookInsertion($i)
	{
    $book = new Book;
    $book->Title = "Hello{$i}";
    $book->ISBN = "1234";
    $book->Price = $i;
    $book->AuthorID = $this->authors[array_rand($this->authors)];
    $this->outlet->save($book);
    $this->books[] = $book->ID;
	}
	
	function runPKSearch($i)
	{
    $author = $this->outlet->load('Author', $this->authors[array_rand($this->authors)]);
    $author->FirstName;
	}
	
	function runHydrate($i)
	{
    $books = $this->outlet->from('Book')
      ->where('{Book.Price} >= ?', array($i))
      ->limit(5)
      ->find();
      
    foreach($books as $book) {
      //print "{$book->Title}\n";
    }
	}

	function runComplexQuery($i)
	{
    $authors = $this->outlet->from('Author')
      ->where('{Author.ID} > ? OR ({Author.FirstName} || {Author.LastName}) = ?', array($this->authors[array_rand($this->authors)], 'John Doe'))
      ->limit(1)
      ->findOne();
	}
	
	function runJoinSearch($i)
	{
    $book = $this->outlet->from('Book')
      ->where('{Book.Title} = ?', array("Hello{$i}"))
      ->with('Author')
      ->limit(1)
      ->findOne();
	}
  
  function runForeignKey($i) {
    $book = $this->outlet->load('Book', $this->books[array_rand($this->books)]);
    $book->getAuthor()->FirstName . "\n";
  }
  
  function runRelated($i) {
    // load an author by first name and display all their books
    $author = $this->outlet->from('Author')
      ->where('{Author.FirstName} = ?', array("John" . $i))
      ->limit(1)
      ->findOne();
    foreach($author->getBooks() as $book) {
      //print "{$book->Price}\n";
    }
  }
}
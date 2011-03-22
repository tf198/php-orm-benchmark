<?php

require_once dirname(__FILE__) . '/../AbstractTestSuite.php';

/**
 * This test suite just demonstrates the baseline performance without any kind of ORM
 * or even any other kind of slightest abstraction.
 */
class OptPDOTestSuite extends AbstractTestSuite
{
	function initialize()
	{
		$this->con = new PDO('sqlite::memory:');
		$this->initTables();
    
    $this->author_insert = $this->con->prepare('INSERT INTO author ([first_name],[last_name]) VALUES (?, ?)');
    $this->book_insert = $this->con->prepare('INSERT INTO book ([title],[isbn],[price],[author_id]) VALUES (?, ?, ?, ?)');
    
    $this->pk_stmt = $this->con->prepare('SELECT author.ID, author.FIRST_NAME, author.LAST_NAME, author.EMAIL FROM author WHERE author.ID = ? LIMIT 1');
    $this->pk_stmt->bindParam(1, $this->_param_pk, PDO::PARAM_INT);
    
    $this->hydrate_stmt = $this->con->prepare('SELECT book.ID, book.TITLE, book.ISBN, book.PRICE, book.AUTHOR_ID FROM book WHERE book.PRICE > ? LIMIT 5');
    $this->hydrate_stmt->bindParam(1, $this->_param_hydrate, PDO::PARAM_INT);
    $this->complex_stmt = $this->con->prepare('SELECT COUNT(*) FROM author WHERE (author.ID>? OR (author.FIRST_NAME || author.LAST_NAME) = ?)');
    $this->join_stmt = $this->con->prepare('SELECT book.ID, book.TITLE, book.ISBN, book.PRICE, book.AUTHOR_ID, author.ID, author.FIRST_NAME, author.LAST_NAME, author.EMAIL FROM book LEFT JOIN author ON book.AUTHOR_ID = author.ID WHERE book.TITLE = ? LIMIT 1');
    
    $this->book_stmt = $this->con->prepare('SELECT book.id, book.title, book.isbn, book.price, book.author_id FROM book WHERE book.id=?');
    $this->author_stmt = $this->con->prepare('SELECT author.id, author.first_name, author.last_name, author.email FROM author WHERE author.id=?');
    
    $this->related_stmt = $this->con->prepare('SELECT author.id, author.first_name, author.last_name, author.email FROM author WHERE author.first_name=?');
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
    $this->author_insert->execute(array("John{$i}", "Doe{$i}"));
		$this->authors[]= $this->con->lastInsertId();
	}

	function runBookInsertion($i)
	{
    $this->book_insert->execute(array("Hello{$i}", "1234", $i, $i));
		$this->books[]= $this->con->lastInsertId();
	}
	
	function runPKSearch($i)
	{
    $this->_param_pk = $this->authors[array_rand($this->authors)];
    $this->pk_stmt->execute();
		$author = $this->pk_stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	function runHydrate($i)
	{
    $this->_param_hydrate = $i;
    $this->hydrate_stmt->execute();
		while ($row = $this->hydrate_stmt->fetch(PDO::FETCH_ASSOC)) {
		}
	}

	function runComplexQuery($i)
	{
    $this->complex_stmt->execute(array($this->authors[array_rand($this->authors)], "John Doe"));
		$this->complex_stmt->fetch(PDO::FETCH_NUM);
	}
	
	function runJoinSearch($i)
	{
    $this->join_stmt->execute(array("Hello{$i}"));
		$book = $this->join_stmt->fetch(PDO::FETCH_ASSOC);
	}
  
  function runForeignKey($i) {
    // get a random book and show the authors name
    $this->book_stmt->execute(array($this->books[array_rand($this->books)]));
    $book = $this->book_stmt->fetch(PDO::FETCH_ASSOC);
    
    $this->author_stmt->execute(array($book['author_id']));
    $author = $this->author_stmt->fetch(PDO::FETCH_ASSOC);
    $author['first_name'];
  }
  
  function runRelated($i) {
    // load an author by first name and display all their books
    $this->related_stmt->execute(array('John' . $i));
    $author = $this->related_stmt->fetch(PDO::FETCH_ASSOC);
    $this->book_stmt->execute(array($author['id']));
    while ($row = $this->book_stmt->fetch(PDO::FETCH_ASSOC)) {
      //print $row['price'];
    }
  }
}
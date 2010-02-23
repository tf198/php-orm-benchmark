<?php

require_once dirname(__FILE__) . '/../AbstractTestSuite.php';

class Propel14TestSuite extends AbstractTestSuite
{
	function initialize()
	{
		set_include_path(
			realpath(dirname(__FILE__) . '/build/classes') . PATH_SEPARATOR .
			realpath(dirname(__FILE__) . '/vendor/propel/runtime/classes') . PATH_SEPARATOR .
			get_include_path()
		);

		require_once 'propel/Propel.php';
		$conf = include realpath(dirname(__FILE__) . '/build/conf/bookstore-conf.php');
		$conf['log'] = null;
		Propel::setConfiguration($conf);
		Propel::initialize();
		Propel::disableInstancePooling();
		
		$this->con = Propel::getConnection('bookstore');
		$schemaSQL = file_get_contents(dirname(__FILE__) . '/build/sql/schema.sql');
		$this->con->exec($schemaSQL);
	}
	
	function clearCache()
	{
		BookPeer::clearInstancePool();
		AuthorPeer::clearInstancePool();
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
		$author = new Author();
		$author->setFirstName('John' . $i);
		$author->setLastName('Doe' . $i);
		$author->save($this->con);
		$this->authors[]= $author->getId();
	}

	function runBookInsertion($i)
	{
		$book = new Book();
		$book->setTitle('Hello' . $i);
		$book->setAuthorId($this->authors[array_rand($this->authors)]);
		$book->setISBN('1234');
		$book->save($this->con);
		$this->books[]= $book->getId();
	}
	
	function runPKSearch($i)
	{
		$author = AuthorPeer::retrieveByPk($this->authors[array_rand($this->authors)], $this->con);
	}
	
	function runSearch($i)
	{
		$c = new Criteria();
		$c->add(AuthorPeer::ID, $this->authors[array_rand($this->authors)], Criteria::GREATER_THAN);
		$c->setLimit(5);
		$authors = AuthorPeer::doSelect($c, $this->con);
	}
	
	function runJoinSearch($i)
	{
		$c = new Criteria();
		$c->add(BookPeer::TITLE, 'Hello' . $i, Criteria::EQUAL);
		$c->setLimit(1);
		$books = BookPeer::doSelectJoinAuthor($c, $this->con);
		$book = $books[0];
	}
	
}
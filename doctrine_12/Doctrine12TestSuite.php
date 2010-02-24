<?php

require_once dirname(__FILE__) . '/../AbstractTestSuite.php';

class Doctrine12TestSuite extends AbstractTestSuite
{
	protected $manager;
	
	function initialize()
	{
		// bootstrap Doctrine
		require_once(dirname(__FILE__) . '/vendor/doctrine/Doctrine.php');
		spl_autoload_register(array('Doctrine', 'autoload'));
		$this->manager = Doctrine_Manager::getInstance();

		// set connection
		$this->con = Doctrine_Manager::connection('sqlite:/tmp/Doctrine12TestSuite.db');
		
		// setup autoloading
		$this->manager->setAttribute(Doctrine_Core::ATTR_MODEL_LOADING, Doctrine_Core::MODEL_LOADING_CONSERVATIVE);
		spl_autoload_register(array('Doctrine', 'modelsAutoload'));
		
		// import db
		$this->manager->dropDatabases();
		$this->manager->createDatabases();
		Doctrine_Core::createTablesFromModels(dirname(__FILE__) . '/models');
	}
	
	function clearCache()
	{
		// BookPeer::clearInstancePool();
		// AuthorPeer::clearInstancePool();
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
		$author->first_name = 'John' . $i;
		$author->last_name = 'Doe' . $i;
		$author->save($this->con);
		$this->authors[]= $author->id;
	}

	function runBookInsertion($i)
	{
		$book = new Book();
		$book->title = 'Hello' . $i;
		$book->author_id = $this->authors[array_rand($this->authors)];
		$book->isbn = '1234';
		$book->save($this->con);
		$this->books[]= $book->id;
	}
	
	function runPKSearch($i)
	{
		$author = Doctrine_Core::getTable('Author')->find($this->authors[array_rand($this->authors)]);
	}
	
	function runSearch($i)
	{
		$authors = Doctrine_Query::create()
			->from('Author a')
			->where('a.id > ?', $this->authors[array_rand($this->authors)])
			->limit(5)
			->execute();
	}
	
	function runJoinSearch($i)
	{
		$books = Doctrine_Query::create()
			->from('Book b, b.Author a')
			->where('b.title = ?', 'Hello' . $i)
			->limit(1)
			->fetchOne();
		$book = isset($books[0]) ? $books[0] : null;
	}
	
}
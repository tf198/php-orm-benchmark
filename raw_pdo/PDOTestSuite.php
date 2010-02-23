<?php

require_once dirname(__FILE__) . '/../AbstractTestSuite.php';

class PDOTestSuite extends AbstractTestSuite
{
	function initialize()
	{
		$this->con = new PDO('sqlite:/tmp/PDOTestSuite.db');
		$this->con->exec('DROP TABLE [book]');
		$this->con->exec('DROP TABLE [author]');
		$this->con->exec('CREATE TABLE [book]
		(
			[id] INTEGER  NOT NULL PRIMARY KEY,
			[title] VARCHAR(255)  NOT NULL,
			[isbn] VARCHAR(24)  NOT NULL,
			[price] FLOAT,
			[author_id] INTEGER
		)');
		$this->con->exec('CREATE TABLE [author]
		(
			[id] INTEGER  NOT NULL PRIMARY KEY,
			[first_name] VARCHAR(128)  NOT NULL,
			[last_name] VARCHAR(128)  NOT NULL,
			[email] VARCHAR(128)
		)');
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
		$query = sprintf('INSERT INTO author ([first_name],[last_name]) VALUES (\'John%s\',\'Doe%s\')', $i, $i);
		$this->con->exec($query);
		$this->authors[]= $this->con->lastInsertId();
	}

	function runBookInsertion($i)
	{
		$query = sprintf('INSERT INTO book ([title],[isbn],[author_id]) VALUES (\'Hello%s\',\'1234\',%d)', $i, $this->authors[array_rand($this->authors)]);
		$this->con->exec($query);
		$this->books[]= $this->con->lastInsertId();
	}
	
	function runPKSearch($i)
	{
		$query = 'SELECT author.ID, author.FIRST_NAME, author.LAST_NAME, author.EMAIL FROM author WHERE author.ID = ? LIMIT 1';
		$stmt = $this->con->prepare($query);
		$stmt->bindParam(1, $this->authors[array_rand($this->authors)], PDO::PARAM_INT);
		$stmt->execute();
		$author = $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	function runSearch($i)
	{
		$query = 'SELECT author.ID, author.FIRST_NAME, author.LAST_NAME, author.EMAIL FROM author WHERE author.ID > ? LIMIT 5';
		$stmt = $this->con->prepare($query);
		$stmt->bindParam(1, $this->authors[array_rand($this->authors)], PDO::PARAM_INT);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		}
	}
	
	function runJoinSearch($i)
	{
		$query = 'SELECT book.ID, book.TITLE, book.ISBN, book.PRICE, book.AUTHOR_ID, author.ID, author.FIRST_NAME, author.LAST_NAME, author.EMAIL FROM book LEFT JOIN author ON book.AUTHOR_ID = author.ID WHERE book.TITLE LIKE ? LIMIT 5';
		$stmt = $this->con->prepare($query);
		$str = 'Hello%';
		$stmt->bindParam(1, $str, PDO::PARAM_STR);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		}
	}
}
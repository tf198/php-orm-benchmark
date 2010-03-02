<?php


/**
 * Base class that represents a query for the 'author' table.
 *
 * Author Table
 *
 * @method     AuthorQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     AuthorQuery orderByFirstName($order = Criteria::ASC) Order by the first_name column
 * @method     AuthorQuery orderByLastName($order = Criteria::ASC) Order by the last_name column
 * @method     AuthorQuery orderByEmail($order = Criteria::ASC) Order by the email column
 *
 * @method     AuthorQuery groupById() Group by the id column
 * @method     AuthorQuery groupByFirstName() Group by the first_name column
 * @method     AuthorQuery groupByLastName() Group by the last_name column
 * @method     AuthorQuery groupByEmail() Group by the email column
 *
 * @method     Author findOne(PropelPDO $con = null) Return the first Author matching the query
 * @method     Author findOneById(int $id) Return the first Author filtered by the id column
 * @method     Author findOneByFirstName(string $first_name) Return the first Author filtered by the first_name column
 * @method     Author findOneByLastName(string $last_name) Return the first Author filtered by the last_name column
 * @method     Author findOneByEmail(string $email) Return the first Author filtered by the email column
 *
 * @method     array findById(int $id) Return Author objects filtered by the id column
 * @method     array findByFirstName(string $first_name) Return Author objects filtered by the first_name column
 * @method     array findByLastName(string $last_name) Return Author objects filtered by the last_name column
 * @method     array findByEmail(string $email) Return Author objects filtered by the email column
 *
 * @package    propel.generator.bookstore.om
 */
abstract class BaseAuthorQuery extends ModelCriteria
{

	// query_cache behavior
	protected $queryKey = '';
	protected static $cacheBackend;
				
	/**
	 * Initializes internal state of BaseAuthorQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'bookstore', $modelName = 'Author', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Find object by primary key
	 * Use instance pooling to avoid a database query if the object exists
	 * <code>
	 * $obj  = $c->findPk(12, $con);
	 * </code>
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($this->getFormatter()->isObjectFormatter() && (null !== ($obj = AuthorPeer::getInstanceFromPool((string) $key)))) {
			// the object is alredy in the instance pool
			return $obj;
		} else {
			// the object has not been requested yet, or the formatter is not an object formatter
			return $this
				->filterByPrimaryKey($key)
				->findOne($con);
		}
	}

	/**
	 * Find objects by primary key
	 * <code>
	 * $objs = $c->findPks(array(12, 56, 832), $con);
	 * </code>
	 * @param     array $keys Primary keys to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    the list of results, formatted by the current formatter
	 */
	public function findPks($keys, $con = null)
	{	
		return $this
			->filterByPrimaryKeys($keys)
			->find($con);
	}

	/**
	 * Filter the query by primary key
	 *
	 * @param     mixed $key Primary key to use for the query
	 *
	 * @return    AuthorQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(AuthorPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    AuthorQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(AuthorPeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 * 
	 * @param     int|array $id The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 *
	 * @return    AuthorQuery The current query, for fluid interface
	 */
	public function filterById($id = null)
	{
		if (is_array($id)) {
			return $this->addUsingAlias(AuthorPeer::ID, $id, Criteria::IN);
		} else {
			return $this->addUsingAlias(AuthorPeer::ID, $id, Criteria::EQUAL);
		}
	}

	/**
	 * Filter the query on the first_name column
	 * 
	 * @param     string $first_name The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 *
	 * @return    AuthorQuery The current query, for fluid interface
	 */
	public function filterByFirstName($firstName = null)
	{
		if (is_array($firstName)) {
			return $this->addUsingAlias(AuthorPeer::FIRST_NAME, $firstName, Criteria::IN);
		} elseif(preg_match('/[\%\*]/', $firstName)) {
			return $this->addUsingAlias(AuthorPeer::FIRST_NAME, str_replace('*', '%', $firstName), Criteria::LIKE);
		} else {
			return $this->addUsingAlias(AuthorPeer::FIRST_NAME, $firstName, Criteria::EQUAL);
		}
	}

	/**
	 * Filter the query on the last_name column
	 * 
	 * @param     string $last_name The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 *
	 * @return    AuthorQuery The current query, for fluid interface
	 */
	public function filterByLastName($lastName = null)
	{
		if (is_array($lastName)) {
			return $this->addUsingAlias(AuthorPeer::LAST_NAME, $lastName, Criteria::IN);
		} elseif(preg_match('/[\%\*]/', $lastName)) {
			return $this->addUsingAlias(AuthorPeer::LAST_NAME, str_replace('*', '%', $lastName), Criteria::LIKE);
		} else {
			return $this->addUsingAlias(AuthorPeer::LAST_NAME, $lastName, Criteria::EQUAL);
		}
	}

	/**
	 * Filter the query on the email column
	 * 
	 * @param     string $email The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 *
	 * @return    AuthorQuery The current query, for fluid interface
	 */
	public function filterByEmail($email = null)
	{
		if (is_array($email)) {
			return $this->addUsingAlias(AuthorPeer::EMAIL, $email, Criteria::IN);
		} elseif(preg_match('/[\%\*]/', $email)) {
			return $this->addUsingAlias(AuthorPeer::EMAIL, str_replace('*', '%', $email), Criteria::LIKE);
		} else {
			return $this->addUsingAlias(AuthorPeer::EMAIL, $email, Criteria::EQUAL);
		}
	}

	/**
	 * Filter the query by a related Book object
	 *
	 * @param     Book $book  the related object to use as filter
	 *
	 * @return    AuthorQuery The current query, for fluid interface
	 */
	public function filterByBook($book)
	{
		return $this
			->addUsingAlias(AuthorPeer::ID, $book->getAuthorId(), Criteria::EQUAL);
	}

	/**
	 * Use the Book relation Book object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    BookQuery A secondary query class using the current class as primary query
	 */
	public function useBookQuery($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->join('Book' . ($relationAlias ? ' ' . $relationAlias : ''), $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Book', 'BookQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     Author $author Object to remove from the list of results
	 *
	 * @return    AuthorQuery The current query, for fluid interface
	 */
	public function prune($author = null)
	{
		if ($author) {
			$this->addUsingAlias(AuthorPeer::ID, $author->getId(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

	/**
	 * Code to execute before every SELECT statement
	 * 
	 * @param     PropelPDO $con The connection object used by the query
	 */
	protected function basePreSelect(PropelPDO $con)
	{
		return $this->preSelect($con);
	}

	/**
	 * Code to execute before every DELETE statement
	 * 
	 * @param     PropelPDO $con The connection object used by the query
	 */
	protected function basePreDelete(PropelPDO $con)
	{
		return $this->preDelete($con);
	}

	/**
	 * Code to execute before every UPDATE statement
	 * 
	 * @param     array $values The associatiove array of columns and values for the update
	 * @param     PropelPDO $con The connection object used by the query
	 */
	protected function basePreUpdate(&$values, PropelPDO $con)
	{
		return $this->preUpdate($values, $con);
	}

	// query_cache behavior
	
	public function setQueryKey($key)
	{
		$this->queryKey = $key;
		return $this;
	}
	
	public function getQueryKey()
	{
		return $this->queryKey;
	}
	
	public function cacheContains($key)
	{
		return isset(self::$cacheBackend[$key]);
	}
	
	public function cacheFetch($key)
	{
		return isset(self::$cacheBackend[$key]) ? self::$cacheBackend[$key] : null;
	}
	
	public function cacheStore($key, $value, $lifetime = 3600)
	{
		self::$cacheBackend[$key] = $value;
	}
	
	protected function getSelectStatement($con = null)
	{
		$dbMap = Propel::getDatabaseMap($this->getDbName());
		$db = Propel::getDB($this->getDbName());
	  if ($con === null) {
			$con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
		}
		
		// we may modify criteria, so copy it first
		$criteria = clone $this;
	
		if (!$criteria->hasSelectClause()) {
			$criteria->addSelfSelectColumns();
		}
		
		$con->beginTransaction();
		try {
			$criteria->basePreSelect($con);
			$key = $criteria->getQueryKey();
			if ($key && $criteria->cacheContains($key)) {
				$params = $criteria->getParams();
				$sql = $criteria->cacheFetch($key);
			} else {
				$params = array();
				$sql = BasePeer::createSelectSql($criteria, $params);
				if ($key) {
					$criteria->cacheStore($key, $sql);
				}
			}
			$stmt = $con->prepare($sql);
			BasePeer::populateStmtValues($stmt, $params, $dbMap, $db);
			$stmt->execute();
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
		
		return $stmt;
	}

} // BaseAuthorQuery

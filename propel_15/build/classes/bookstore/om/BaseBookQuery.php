<?php


/**
 * Base class that represents a query for the 'book' table.
 *
 * Book Table
 *
 * @method     BookQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     BookQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     BookQuery orderByISBN($order = Criteria::ASC) Order by the isbn column
 * @method     BookQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method     BookQuery orderByAuthorId($order = Criteria::ASC) Order by the author_id column
 *
 * @method     BookQuery groupById() Group by the id column
 * @method     BookQuery groupByTitle() Group by the title column
 * @method     BookQuery groupByISBN() Group by the isbn column
 * @method     BookQuery groupByPrice() Group by the price column
 * @method     BookQuery groupByAuthorId() Group by the author_id column
 *
 * @method     Book findOne(PropelPDO $con = null) Return the first Book matching the query
 * @method     Book findOneById(int $id) Return the first Book filtered by the id column
 * @method     Book findOneByTitle(string $title) Return the first Book filtered by the title column
 * @method     Book findOneByISBN(string $isbn) Return the first Book filtered by the isbn column
 * @method     Book findOneByPrice(double $price) Return the first Book filtered by the price column
 * @method     Book findOneByAuthorId(int $author_id) Return the first Book filtered by the author_id column
 *
 * @method     array findById(int $id) Return Book objects filtered by the id column
 * @method     array findByTitle(string $title) Return Book objects filtered by the title column
 * @method     array findByISBN(string $isbn) Return Book objects filtered by the isbn column
 * @method     array findByPrice(double $price) Return Book objects filtered by the price column
 * @method     array findByAuthorId(int $author_id) Return Book objects filtered by the author_id column
 *
 * @package    propel.generator.bookstore.om
 */
abstract class BaseBookQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseBookQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'bookstore', $modelName = 'Book', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new BookQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    BookQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof BookQuery) {
			return $criteria;
		}
		$query = new BookQuery();
		if (null !== $modelAlias) {
			$query->setModelAlias($modelAlias);
		}
		if ($criteria instanceof Criteria) {
			$query->mergeWith($criteria);
		}
		return $query;
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
		if ($this->getFormatter()->isObjectFormatter() && (null !== ($obj = BookPeer::getInstanceFromPool((string) $key)))) {
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
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(BookPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(BookPeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 * 
	 * @param     int|array $id The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($id)) {
			return $this->addUsingAlias(BookPeer::ID, $id, Criteria::IN);
		} else {
			return $this->addUsingAlias(BookPeer::ID, $id, $comparison);
		}
	}

	/**
	 * Filter the query on the title column
	 * 
	 * @param     string $title The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function filterByTitle($title = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($title)) {
			return $this->addUsingAlias(BookPeer::TITLE, $title, Criteria::IN);
		} elseif(preg_match('/[\%\*]/', $title)) {
			return $this->addUsingAlias(BookPeer::TITLE, str_replace('*', '%', $title), Criteria::LIKE);
		} else {
			return $this->addUsingAlias(BookPeer::TITLE, $title, $comparison);
		}
	}

	/**
	 * Filter the query on the isbn column
	 * 
	 * @param     string $iSBN The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function filterByISBN($iSBN = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($iSBN)) {
			return $this->addUsingAlias(BookPeer::ISBN, $iSBN, Criteria::IN);
		} elseif(preg_match('/[\%\*]/', $iSBN)) {
			return $this->addUsingAlias(BookPeer::ISBN, str_replace('*', '%', $iSBN), Criteria::LIKE);
		} else {
			return $this->addUsingAlias(BookPeer::ISBN, $iSBN, $comparison);
		}
	}

	/**
	 * Filter the query on the price column
	 * 
	 * @param     double|array $price The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function filterByPrice($price = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($price)) {
			if (array_values($price) === $price) {
				return $this->addUsingAlias(BookPeer::PRICE, $price, Criteria::IN);
			} else {
				if (isset($price['min'])) {
					$this->addUsingAlias(BookPeer::PRICE, $price['min'], Criteria::GREATER_EQUAL);
				}
				if (isset($price['max'])) {
					$this->addUsingAlias(BookPeer::PRICE, $price['max'], Criteria::LESS_EQUAL);
				}
				return $this;	
			}
		} else {
			return $this->addUsingAlias(BookPeer::PRICE, $price, $comparison);
		}
	}

	/**
	 * Filter the query on the author_id column
	 * 
	 * @param     int|array $authorId The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function filterByAuthorId($authorId = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($authorId)) {
			if (array_values($authorId) === $authorId) {
				return $this->addUsingAlias(BookPeer::AUTHOR_ID, $authorId, Criteria::IN);
			} else {
				if (isset($authorId['min'])) {
					$this->addUsingAlias(BookPeer::AUTHOR_ID, $authorId['min'], Criteria::GREATER_EQUAL);
				}
				if (isset($authorId['max'])) {
					$this->addUsingAlias(BookPeer::AUTHOR_ID, $authorId['max'], Criteria::LESS_EQUAL);
				}
				return $this;	
			}
		} else {
			return $this->addUsingAlias(BookPeer::AUTHOR_ID, $authorId, $comparison);
		}
	}

	/**
	 * Filter the query by a related Author object
	 *
	 * @param     Author $author  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function filterByAuthor($author, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(BookPeer::AUTHOR_ID, $author->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Author relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function joinAuthor($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Author');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'Author');
		}
		
		return $this;
	}

	/**
	 * Use the Author relation Author object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    AuthorQuery A secondary query class using the current class as primary query
	 */
	public function useAuthorQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinAuthor($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Author', 'AuthorQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     Book $book Object to remove from the list of results
	 *
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function prune($book = null)
	{
		if ($book) {
			$this->addUsingAlias(BookPeer::ID, $book->getId(), Criteria::NOT_EQUAL);
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

} // BaseBookQuery

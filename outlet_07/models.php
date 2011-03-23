<?
class Book{
  public $Title;
  public $ISBN;
  public $Price;
  
  private $author;
  
  function getAuthor() {
    return $this->author;
  }
  
  function setAuthor(Author $a) {
    $this->author = $a;
  }
}

class Author {
  public $FirstName;
  public $LastName;
  public $Email;
  
  private $books;
  
  function getBooks() {
    return $this->books;
  }
  
  function setBooks($b) {
    $this->books = $b;
  }
}
?>
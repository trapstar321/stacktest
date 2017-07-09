<?php
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class User
{
    /** @ODM\Id(strategy="INCREMENT") */
    private $id;

    /** @ODM\Field(type="string") @ODM\UniqueIndex(order="asc")*/
    private $username;

    /** @ODM\Field(type="string") */
    private $password;

    /** @ODM\Field(type="string") */
    private $firstname;

    /** @ODM\Field(type="string") */
    private $lastname;

    /** @ODM\Field(type="string") */
    private $email;

    /** @ODM\Field(type="string") */
    private $token;

    /**
     * @ODM\ReferenceMany(targetDocument="News")
     */
    private $news = array();

    public function getID(){return $this->id;}

    public function getUsername(){return $this->username;}
    public function setUsername($username){$this->username=$username;}

    public function getPassword(){return $this->password;}
    public function setPassword($password){$this->password=$password;}

    public function getFirstname(){return $this->firstname;}
    public function setFirstname($firstname){$this->firstname=$firstname;}

    public function getLastname(){return $this->lastname;}
    public function setLastname($lastname){$this->lastname=$lastname;}

    public function getEmail(){return $this->email;}
    public function setEmail($email){$this->email=$email;}

    public function getNews(){return $this->news;}
    public function addNews($news){$this->news[]=$news;}    

    public function getToken(){return $this->token;}
    public function setToken($token){$this->token=$token;}

    public function toArray(){
        $arr = []; 
        foreach(get_object_vars($this) as $key=>$value){                        
            if(strcmp($key,"news")!==0){
                $arr[$key]=$value;
            }         
        }
        return $arr;
    }
}

/** @ODM\Document */
class News
{
    /** @ODM\Id(strategy="INCREMENT") */
    private $id;
    
    /** @ODM\Field(type="string") */
    private $title;

    /** @ODM\Field(type="string") */
    private $short_desc;

    /** @ODM\Field(type="string") */
    private $text;

    /** @ODM\Field(type="string") */
    private $img_path;

    /** @ODM\Field(type="date") */
    private $post_date;

    /**
     * @ODM\ReferenceOne(targetDocument="User")
     */
     private $author;

    public function getID(){return $this->id;}

     public function getTitle(){return $this->title;}
     public function setTitle($title){$this->title=$title;}

     public function getShortDesc(){return $this->short_desc;}
     public function setShortDesc($short_desc){$this->short_desc=$short_desc;}

     public function getText(){return $this->text;}
     public function setText($text){$this->text=$text;}

     public function getImgPath(){return $this->img_path;}
     public function setImgPath($img_path){$this->img_path=$img_path;}

     public function getAuthor(){return $this->author;}
     public function setAuthor($author){$this->author=$author;}

     public function getPostDate(){return $this->post_date;}
     public function setPostDate($date){$this->post_date=$date;}

     public function toArray(){         
         $arr = [];             
         foreach(get_object_vars($this) as $key=>$value){               
            if($key=="author"){
                $arr[$key]=$this->author->toArray();
            }else{
                $arr[$key]=$value;
            }         
         }
         return $arr;
     }
}
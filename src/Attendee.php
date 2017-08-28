<?php 
namespace Wedding;
class Attendee {
   
   private $name;

   private $database;  

   private $attending;

   private $partyCount = 0;

   const NAMEERROR = 'Please Provide a UserName';
   const DATABASEERROR = 'Database was not passed in or messed up';
   const ISATTENDINGERROR = 'Attending is not posting correctly';

   function __construct($name = '', $database) { 
      $this->setName($name);
      $this->setDatabase($database);
   }

   private function setDatabase ($database) {
       if (!empty($database)) {
           $this->database = $database; 
       } else {
           throw new \Exception(self::DATABASEERROR);
       }
   }

   public function getDatabase() {
      return $this->database;
   }
 
   private function setName($name) {
       if (!empty($name)) { 
           $this->name = $name; 
       } else {
           throw new \Exception(self::NAMEERROR);
       }
   } 

   public function getName() {
      return $this->name;
   }
 
   public function PartyCount($val = '') {
      if ($val != '') {
	  $this->setPartyCount($val);
	} else {
	  return $this->getPartyCount();
	}

  }
   private function getPartyCount() {
      return $this->partyCount;
   }

 private function setPartyCount($partyCount) {
       if ($partyCount != '') {
           $this->partyCount = $partyCount;
       } else {
           throw new \Exception(self::NAMEERROR);
       }
   }

   public function isAttending($val = ''){
	if ($val != '') {
	  if ($val == 0 || $val == 1) {
            $this->setAttendance($val);
	  } else { 
	    throw new \Exception(self::ISATTENDINGERROR);
          }
	} else {
	  return $this->getAttendance();
	}

   }

   private function getAttendance() {
      return $this->attending;
   }

  private function setAttendance($attending) {
       if ($attending != '') {
           $this->attending = $attending;
       } else {
           throw new \Exception(self::NAMEERROR);
      }
   }

  public function commit() {
    $bool = $this->database->query("INSERT INTO Attendees (name, party_size, attending) VALUES ('{$this->name}','{$this->partyCount}','{$this->attending}');");
    if ($bool === false) {
       throw new \Exception($mysqli->error);
    }
  }

} 

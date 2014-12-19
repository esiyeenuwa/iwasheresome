<?php

	include_once("adb.php");
	
	class sch extends adb{
	
		function sch(){
		adb::adb();
		}
        
        //allows for data entry
        function assignment($subject,$teacher,$year,$assignment){
			return $this->query("insert into assigntable(tid,year, subject,a_description,date) 
		  values('$teacher','$year','$teacher','$assignment',NOW())");
	}
        
        function viewPComments($aid){
           $query="select * from comments where aid='$aid";
            if(!$this->query($query))
               {return false;}
            return $this->query($query);
        }
        function viewComments(){
           $query="select * from comments";
            if(!$this->query($query))
               {return false;}
            return $this->query($query);
        }
       
        
        function viewAssignment(){
             $query="select * from program";
              if(!$this->query($query))
               {return false;}
            return $this->query($query);
        }
        
        function viewTComments($aid, $comment){
            return $this->query("insert into comments(aid,comment) 
		  values('$aid','$comment')");    
        }
       
        
        
               
        function sendClarification($reply, $aid){
            $query="update comments set t_reply ='$reply' where aid=$aid"; 
            if(!$this->query($query))
	{
		return false;
	}
	
		return $this->query($query);
            
	}
        
        function postComment($name,$date,$location,$contact,$description){
             $query="insert into program(pname,pdate,plocation,pphone,pdescription,attendence) 
		  values('$name','$date','$location','$contact','$description',0)"; 
            if(!$this->query($query))
	{
		return false;
	}
	
		return $this->query($query);
        }
        
        
       function sendPText(){
            $query="select number from parent";
              if(!$this->query($query))
               {return false;}
		return $this->query($query);
        }
        
        function numPeople(){
            
           $query="select numPeople from reservation where reservation.date=CURDATE()";
           if(!$this->query($query))
               {return false;}
		return $this->query($query);
        }
		
		
		   function list_today(){
            
           $query="select distinct users.username,dropofflocation.name, ticketid ,reservation.date from reservation, dropofflocation, users where dropofflocation.doid=reservation.doid and users.facultyId=reservation.facultyId and reservation.date=CURDATE()";
           if(!$this->query($query))
               {return false;}
		return $this->query($query);
        }
		
		
		function reserve_num(){
		           $query="select distinct count(*) as reserveNum from reservation, dropofflocation, users where dropofflocation.doid=reservation.doid and users.facultyId=reservation.facultyId and reservation.date=CURDATE()";
				   if(!$this->query($query)){return false;}
		return $this->query($query);
	
		}
        
		
        	//allows for data entry
		 function reserve($name,$date,$destination,$ticketid,$status){
			return $this->query("insert into reservation(date,doid,ticketid,Status,facultyId) 
		  values('$date','$destination','$ticketid','$status','$name')");
		}
        
	function validateId($facultyId){

		$query="select count(*) as number from users where facultyId='$facultyId'";
		if(!$this->query($query)){return false;}
		return $this->query($query);
		
	}
	
	function accBalance($facultyId){

		$query="select account from users where facultyId='$facultyId'";
		if(!$this->query($query)){return false;}
		return $this->query($query);
		
	}
	
	//a query to search for childeren with a particular name
		function search($name){
		$query="select distinct users.username,dropofflocation.name, reservation.facultyId, ticketid ,reservation.date from reservation, dropofflocation, users where dropofflocation.doid=reservation.doid and users.facultyId=reservation.facultyId and users.username like'%$name%' order by date desc";
			
			if(!$this->query($query)){
				return false;
			}
			return $this->fetch();
			
		}
		
	
		//a query to search for childeren with a particular name
		function filter($name){
		$query="select distinct users.username,dropofflocation.name, reservation.facultyId, ticketid ,reservation.date from reservation, dropofflocation, users where dropofflocation.doid=reservation.doid and users.facultyId=reservation.facultyId and date='$name' order by date desc";
			
			if(!$this->query($query)){
				return false;
			}
			return $this->query($query);
			
		}
		
		
		function report($date){

		$query="select distinct facultyId as number from reservation where reservation.date='$date'";
		if(!$this->query($query)){
		return false;
			}
		return $this->query($query);
	 
	}

        //update
	
	function update_vitamin($id,$v_name,$quantity){
	
	$query =" update vitamins set v_name ='$v_name', quantity= $quantity where v_id=$id ";
	
	if(!$this->query($query))
	{
		return false;
	}
	
		return $this->query($query);
	
	
	}
        
        function attendance($name,$event){
            $query="select ucode from eusers where uname='$name'";
            if(!$this->query($query)){
				return false;
			}
			$row=$this->fetch($query);
                        $code=$row['ucode'];
                        $pid=$event.$code;
                       
            $query ="update people set attended ='yes' where pid='$pid'";
	
	if(!$this->query($query))
	{
		return false;
	}	
		return true;
        }
    
        
        function myAttendence($value,$event){
             $query ="select attendence from program where pname='$event'";
              if(!$this->query($query))
            {
                    return false;
            }	
                 $row=$this->fetch();
                 $value= $row['attendence']+1;
                 
            $query ="update program set attendence ='$value' where pname='$event'";

            if(!$this->query($query))
            {
                    return false;
            }	
                    return true;
            } 
        
	
        function numAttend($event){
              $query ="select attendence from program where pname='$event'";

            if(!$this->query($query))
            {
                    return false;
            }	
                    return true;
            }
        }
            
       	
		




?>
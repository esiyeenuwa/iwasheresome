<?php



include("gen.php");
    $cmd=get_datan("cmd");//get datan makes sure that the browser does not show any responses
	//echo "are u called";
switch($cmd){
		case 1:
                //gets all the child welfare details including the fullname
                checkuser();
                break;
                case 2:
                //gets all the child welfare details including the fullname
                listEvents();
                break;
                  case 3:
                //gets all the child welfare details including the fullname
                eventDetail();
                break;
                 case 4:
                //gets all the child welfare details including the fullname
                eventRegisteration();
                break;
                 case 5:
                //gets all the child welfare details including the fullname
                applicationRegisteration();
                break;
                  case 6:
                //gets all the child welfare details including the fullname
                attendenceNo();   
                break;
            default:
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","unknown command");
			echo "}";
	}
        
        function checkuser(){
            $email=get_data('email');
            $code=get_data('code');
            
            if(!get_data('email')){
                echo'{"result":0,"message":"Opps an error ocurred. Please enter your username and password"}';
                return;
            }
            
            include('event_function.php');
            $myEvent=new myevents();
            $row=$myEvent->validateUser($email,$code);
            if(!$row){
                
		echo'{"result":0,"message":"unable to update"}';
		return;
		}
		   $json=array();
                    while($row=$myEvent->fetch()){
                        $json['user'][]=$row;  
                    }
                echo json_encode($json);
                
            }
            
            
            function listEvents(){
                //creates an object of the growing class
		include("event_function.php");
		//$vs=get_data("vs");
                
                $obj = new myevents();
			
			//calls the querry that shows the details of a child
			$row=$obj->listEvent();
	
			if(!$row){
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","Details not found");
			echo "}";
			return;
		}
                
                 $json=array();
                    while($row=$obj->fetch()){
                        $json['event'][]=$row;  
                    }
                echo json_encode($json);	
        
                
            }
            
            
            
                       
            function eventDetail(){
                //creates an object of the growing class
		include("event_function.php");
		 $id=get_data('pid');
            
                if(!get_data('pid')){
                echo'{"result":0,"message":"Opps an error ocurred. Please enter your username and password"}';
                return;
            }
                
                $obj = new myevents();
			
			//calls the querry that shows the details of a child
			$row=$obj->eDetail($id);
	
			if(!$row){
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","Details not found");
			echo "}";
			return;
		}
                
                 $json=array();
                    while($row=$obj->fetch()){
                        $json['event'][]=$row;  
                    }
                echo json_encode($json);	
        
                
            }
            
            
            function eventRegisteration(){
               include("event_function.php");
               $mycode=get_data('code');
               $event=get_data('event');
               if(!$mycode){
                   echo'{"result":0,"message":"not working"}';
		return;
               } $obj = new myevents();
		$row=$obj->register($event,$mycode);	
               if(!$row){
                   echo'{"result":0,"message":"unable to update"}';
		return;
               }else{
               
               //$row=$obj->fetch();
                      
               //// $phone=$row['uphone'];
               // $phone="233".$phone;
               // $phone;
               
             
          //echo'{"result":1,"message":"One item has sucessfully been added"}';
            
           $url = "http://api.smsgh.com/v3/messages/send?"
            . "From=iWasHereSome"
            . "&To=%2B233543035331"
            . "&Content=You%2C+have%2C+succesfully%2C+registered%2C+for%2C+the+%2C+event"
            . "&ClientId=odfbifrp"
            . "&ClientSecret=rktegnml"
            . "&RegisteredDelivery=true";
            // Fire the request and wait for the response
            $response = file_get_contents($url) ;
            var_dump($response);
            }
            }
        
        
            
            function applicationRegisteration(){
                 include("event_function.php");
               $name=get_data('name');
               $email=get_data('email');
               $contact=get_data('contact');
               $organisation=get_data('organisation');
               $randomNo=get_data('random');
               
               if(!$name){
                   echo'{"result":0,"message":"not working"}';
		return;
               } 
               $obj = new myevents();
		if(!$obj->application($name,$email,$contact,$organisation,$randomNo)){	
          
                   echo'{"result":0,"message":"unable to register applicant"}';
		return;
               }
                $row=$obj->fetch();
                      
                $phone=$row['uphone'];
                $phone="233".$phone;
                $phone;
                $phone="+233543035331";
               call($phone);
             
        //  echo'{"result":1,"message":"One item has sucessfully been added"}';
            
            
            }
            
            function call($phone){
           $url = "http://api.smsgh.com/v3/messages/send?"
    . "From=AshTransit"
    . "&To={$phone}"
    . "&Content=Dear+passenger+Your+reservation+for+trip"
    . "&ClientId=odfbifrp"
    . "&ClientSecret=rktegnml"
    . "&RegisteredDelivery=true";
	 // Fire the request and wait for the response
	 $response = file_get_contents($url) ;
	 var_dump($response);
            }    
            
            
            
        function updateConductor(){
            $id= get_datan('id');
		if(!$id){
		//display message
			echo'{"result":0,"message":"not working"}';
		return;
		}
		include ("myGroup_function.php");
			$g=new bus();
                        
		if(!$g->update_conductor($id))
		{
		echo'{"result":0,"message":"unable to update"}';
		return;
		}
		echo'{"result":1,"message":"One item has sucessfully been updated successfully"}';
        }
        
        
        function updateTime(){
             $id= get_datan('id');
             $tt= get_data('tripname');
             echo $id;
             echo $tt;
             if(!$id){
		//display message
			echo'{"result":0,"message":"not working"}';
		return;
		}
                include ("myGroup_function.php");
			$g=new bus();
                        
		if(!$g->myTime($tt,$id))
		{
		echo'{"result":0,"message":"unable to update"}';
		return;
		}
            echo'{"result":1,"message":"One item has sucessfully been updated successfully"}';
        }
        
        function viewBooking(){
           
            //creates an object of the growing class
		include("myGroup_function.php");
		//$vs=get_data("vs");
                
                $obj = new bus();
			
			//calls the querry that shows the details of a child
			$row=$obj->listAll();
	
			if(!$row){
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","Details not found");
			echo "}";
			return;
		}
                
                 $json=array();
                    while($row=$obj->fetch()){
                        $json['bookings'][]=$row;  
                    }
                echo json_encode($json);	
        
        }
        
          function attendenceNo(){
                 include("event_function.php");
               $name=get_data('number');
               $email=get_data('name');
             
               if(!$name){
                   echo'{"result":0,"message":"not working"}';
		return;
               } 
               $obj = new myevents();
		if(!$obj->attendence($number,$name)){	
          
                   echo'error';
		return;
               }
                $row=$obj->fetch();
                      
                $phone=$row['attendence'];
                
                echo $phone;
      
            }    
      
	
?>
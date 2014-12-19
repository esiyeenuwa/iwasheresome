<?php
	include("gen.php");
	$cmd=get_datan("cmd");//get datan makes sure that the browser does not show any responses
	//echo "are u called";
	switch($cmd){
		case 1:
			//gets all the child welfare details including the fullname
			//report();
                        viewComment();
			break;
		case 2:
			//adds a new child welfare detail
			//add_gcDetail();
                        post_assignment();
			break;
		case 3:
			//updates any chances made to the child welfare detail
			sendClarification();
			break;
		case 4:
			//deletes a child welfare detail
			//filter();
                        post_comment();
			break;
		case 5:
			//searches all people with a paticular detail
			//search();
                        view_assignment();
			break;
		case 6:
		//get the number of sick children
			//numPeople();
                    view_assignment2();
			break;
                case 7:
		//get the number of sick children
			//numPeople();
                    markAttendence();
			break;
                
                case 8:
		//get the number of sick children
			//numPeople();
                
                    updateAttendence();
			break;   
                
                     case 9:
		//get the number of sick children
			//numPeople();
                    numAttended();
                 
			break;  
                    
		default:
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","unknown command");
			echo "}";
	}
	
	

	function report(){
	
		include ("bus_functions.php");
		$vs=get_data("vs");
		$obj=new bus();
		$row=$obj->report($vs);
		
		if(!$row)
			{
			echo'{"result":0,"message":"Unable to retrive report"}';
			return;
			}
			$row=$obj->fetch();
			echo "{";
			echo '"num":[';
			while( $row){
					
			echo "{";
			echo jsonn("result",1). ",";
			//echo '"gChild":[{';
			echo jsonn("number",$row['number'] );
		
			echo "}";
			
			$row=$obj->fetch();
			if($row){
				echo ",";
			}

		}
		echo "]";
			echo "}";
		
	}
        
        function viewComment(){
            //creates an object of the growing class
		include("sch_functions.php");
		//$vs=get_data("vs");
                
                $obj = new sch();
			
			//calls the querry that shows the details of a child
			$row=$obj->viewComments();
	
			if(!$row){
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","Details not found");
			echo "}";
			return;
		}
				
		/*$row=$obj->fetch();
			echo "{";
			echo '"person":[';
			while($row){
					
			echo "{";
			echo jsonn("result",1). ",";
			//echo '"gChild":[{';
			echo jsons("aid",$row['aid'] ).",";
			
			echo jsons("comment",$row['comment']);
		
			echo "}";
			
			$row=$obj->fetch();
			if($row){
				echo ",";
			}

		}
		echo "]";
			echo "}";*/
                
                 $json=array();
                    while($row=$obj->fetch()){
                        $json['person'][]=$row;  
                    }
                echo json_encode($json);	
        
        }
        
        function post_comment(){
             $name= get_data('name');
             $date= get_data('date');
             $location= get_data('location');
             $contact= get_data('contact');
             $description= get_data('description');
            
		if(!get_data('name')){
		//display message
			echo'{"result":0,"message":"Unable to add. Non-exsisting hospitail ID"}';
		return;
		}
                include ("sch_functions.php");
                $b= new sch();
                
                if(!$b->postComment($name,$date,$location,$contact,$description)){
                    echo'{"result":0,"message":"Unable to add"}';
                    return;
                }
            echo'{"result":1,"message":"One item has sucessfully been added"}';
            
            
             $url = "http://api.smsgh.com/v3/messages/send?"
            . "From=SchoolAid"
            . "&To=%2B233543035331"
            . "&Content=A%2C+parent%2C+has%2C+a%2C+comment%2C+on+%2C+assignment"
            . "&ClientId=odfbifrp"
            . "&ClientSecret=rktegnml"
            . "&RegisteredDelivery=true";
            // Fire the request and wait for the response
            $response = file_get_contents($url) ;
            var_dump($response);
        }
		
	//add a new assignment
        function post_assignment(){
            $aid= get_datan('teach');
		$subject= get_datan('sub');
		$year=get_datan('year');
		$homework=get_data('task');
                
                //echo "let it goo";
		if(!$aid){
		//display message
			echo'{"result":0,"message":"Unable to add. Non-exsisting hospitail ID"}';
		return;
		}
                include ("sch_functions.php");
                $b= new sch();
                
                if(!$b->assignment($subject,$aid,$year,$homework)){
                    echo'{"result":0,"message":"Unable to add"}';
                    return;
                }
            echo'{"result":1,"message":"One item has sucessfully been added"}';
        
            
            $row= $b->sendPText();
            $row=$b->fetch();
            while($row){
               $num= $row['number'];

            $url = "http://api.smsgh.com/v3/messages/send?"
            . "From=SchoolAid"
            . "&To=%2B233543035331"
            . "&Content=Your%2C+Child%2C+has%2C+a%2C+new%2C+Maths+%2C+assigment"
            . "&ClientId=odfbifrp"
            . "&ClientSecret=rktegnml"
            . "&RegisteredDelivery=true";
            // Fire the request and wait for the response
            $response = file_get_contents($url) ;
            var_dump($response);

             $row=$b->fetch();
            }
         
        
   
            
                }
        
        
        function sendClarification(){
            $aid=get_datan('id');
            $reply=get_data('reply');
            if(!$aid){
		//display message
			echo'{"result":0,"message":"Unable to add. Non-exsisting hospitail ID"}';
		return;
		}
                include ("sch_functions.php");
                $b= new sch();
                
                if(!$b->sendClarification($reply,$aid)){
                    echo'{"result":0,"message":"Unable to add"}';
                    return;
                }
            echo'{"result":1,"message":"One clarification has been sucessfully sent"}';
        }
        
        
        
        function view_assignment(){
            	include("sch_functions.php");
		//$vs=get_data("vs");
                
                $obj = new sch();
			
			//calls the querry that shows the details of a child
			$row=$obj->viewAssignment();
	
			if(!$row){
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","Details not found");
			echo "}";
			return;
		}
	  $json=array();
                while($row=$obj->fetch()){
                    $json['assignment'][]=$row;
                    
                }
                echo json_encode($json);			
	
        }
        
                function view_assignment2(){
            	include("sch_functions.php");
		//$vs=get_data("vs");
                
                $obj = new sch();
			
			//calls the querry that shows the details of a child
			$row=$obj->viewAssignment();
	
			if(!$row){
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","Details not found");
			echo "}";
			return;
		}
                while($row){
                    echo $row['aid']."     ".$row['a_description'];
                    echo '#';
                    $row=$obj->fetch();
		}
			
	
        }
        
	function add_gcDetail(){
		$id= get_datan('id');
		$vh= get_datan('vh');
		$vw=get_datan('vw');
		$vs=get_data('vs');
		
		//echo "let it goo";
		if(!$id){
		//display message
			echo'{"result":0,"message":"Unable to add. Non-exsisting hospitail ID"}';
		return;
		}
		include ("growing_child.php");
			$g=new growing_child();
		if(!$g->add_gcDetail($id,$vh,$vw,$vs))
		{
		echo'{"result":0,"message":"Unable to add"}';
		return;
		}
		echo'{"result":1,"message":"One item has sucessfully been add"}';
	}
	
	//updates an changes in the child welfare detail
	function update_gChild(){
		$id= get_datan('id');
		$vh= get_datan('vh');
		$vw=get_datan('vw');
		$vs=get_data('vs');
		$vc=get_datan('vc');
		
		if(!$id){
		//display message
			echo'{"result":0,"message":"not working"}';
		return;
		}
		include ("growing_child.php");
			$g=new growing_child();
		if(!$g->update_gcDetails($id,$vc,$vh,$vw,$vs))
		{
		echo'{"result":0,"message":"unable to update"}';
		return;
		}
		echo'{"result":1,"message":"One item has sucessfully been updated successfully"}';
	}
	
	//deletes a child welfare detail
	//function del_gDetail(){
	//	$id= get_datan('id');

		//echo "let it goo";
	//	if(!$id){
		//display message
		//echo'{"result":0,"message":"not working"}';
		//return;
		//}
		//include ("growing_child.php");
		//$g=new growing_child();
		//if(!$g->delete_gcDetail($id))
		//{
		//echo'{"result":0,"message":"unable to delete"}';
		//return;
		//}
		//echo'{"result":1,"message":"One item has sucessfully been deleted"}';
	//}
	
	//searches for a child welfare detail
	function search(){
	//creates an object of the growing class
		include("bus_functions.php");
		$vs=get_data("vs");
                
                $obj = new bus();
			
			//calls the querry that shows the details of a child
			$row=$obj->search($vs);
	
			if(!$row){
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","Details not found");
			echo "}";
			return;
		}
				
			echo "{";
			echo jsonn("result",1). ",";
			echo '"person":[{';
			echo jsons("name",$row['name'] ).",";
			echo jsons("username",$row['username']).",";
			echo jsonn("ticketid",$row['ticketid']).",";
			echo jsons("date",$row['date']).",";
			echo jsonn("facultyId",$row['facultyId']);
			echo "}]";
		echo "}";
	}
	
		function filllter(){
	//creates an object of the growing class
		include("bus_functions.php");
		$vs=get_data("vs");
                
                $obj = new bus();
			
			//calls the querry that shows the details of a child
			$row=$obj->filter($vs);
	
			if(!$row){
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","Details not found");
			echo "}";
			return;
		}
				
			echo "{";
			echo jsonn("result",1). ",";
			echo '"person":[{';
			echo jsons("name",$row['name'] ).",";
			echo jsons("username",$row['username']).",";
			echo jsonn("ticketid",$row['ticketid']).",";
			echo jsons("date",$row['date']).",";
			echo jsonn("facultyId",$row['facultyId']);
			echo "}]";
		echo "}";
	}
	
			function filter(){
	//creates an object of the growing class
		include("bus_functions.php");
		$vs=get_data("vs");
                
                $obj = new bus();
			
			//calls the querry that shows the details of a child
			$row=$obj->filter($vs);
	
			if(!$row){
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","Details not found");
			echo "}";
			return;
		}
				
		$row=$obj->fetch();
			echo "{";
			echo '"person":[';
			while( $row){
					
			echo "{";
			echo jsonn("result",1). ",";
			//echo '"gChild":[{';
			echo jsons("name",$row['name'] ).",";
			echo jsons("username",$row['username']).",";
			echo jsonn("ticketid",$row['ticketid']).",";
			echo jsons("date",$row['date']).",";
			echo jsonn("facultyId",$row['facultyId']);
		
			echo "}";
			
			$row=$obj->fetch();
			if($row){
				echo ",";
			}

		}
		echo "]";
			echo "}";
	}
	//get the number of sick children
	function numPeople(){
	
		include("bus_functions.php");
		
		$obj = new bus();
		$row=$obj->numPeople();
	
		if(!$row)
			{
			echo'{"result":0,"message":"Unable to retrive report"}';
			return;
			}
			$row=$obj->fetch();
		echo "{";
			echo jsonn("result",1). ",";
			echo jsonn("numPeople",$row['numPeople']);
			echo "}";
	}
        
        function markAttendence(){
            include("sch_functions.php");
		$name=get_data("name");
                $event=get_data("event");
                
                $obj = new sch();
			
			//calls the querry that shows the details of a child
			$row=$obj->attendance($name,$event);
	
			if(!$row){
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","Unable to update information");
			echo "}";
			return;
		}
                echo true;
        }
        
        function updateAttendence(){
         include("sch_functions.php");
		$value=get_datan("number");
                $event=get_data('event');          
                $obj = new sch();
			
			//calls the querry that shows the details of a child
			$row=$obj->myAttendence($value,$event);
	
			if(!$row){
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","Unable to update information");
			echo "}";
			return;
		}
                echo true;
        }
        
        function numAttended(){
            	include("sch_functions.php");
                $event= get_data("event");
                  
		if(!get_data('event')){
		//display message
			echo'{"result":0,"message":"Unable to add. Non-exsisting hospitail ID"}';
		return;
		}
		//$vs=get_data("vs");
                
                $obj = new sch();
			
			//calls the querry that shows the details of a child
			$row=$obj->numAttend($event);
	
			if(!$row){
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","Details not found");
			echo "}";
			return;
		}
                    $row=$obj->fetch();
                    echo $row['attendence'];
                   
                    
		
        }
?>
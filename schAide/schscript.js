

function syncAjax(u){
	var obj=$.ajax(
            {url:u,
                async:false
            });
	return $.parseJSON(obj.responseText);
    }


function post_assignment(){
    var teacher=("#select-teacher").val();
    var subject=("#select-subject").val();
    var year=("#select-choice-year").val();
    var task=("#homeWork").val();
    
    var u="sch_action.php?cmd=2&teach="
          +teacher+"sub="+subject+"year="+year+
          "task="+task;
			
   var r=syncAjax(u);
   
   if(r.result==0){
       return;
   }
}
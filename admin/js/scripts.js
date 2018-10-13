$(document).ready(function(){
    // Ck Editor
    // https://ckeditor.com/ckeditor-5/download/
         ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );
    
    
    // Rest code
    
    $('#selectAllBoxes').click(function(event){
     if(this.checked){
        $('.checkBoxes').each(function(){
            this.checked = true;
        });
        
    }else{
        $('.checkBoxes').each(function(){
            this.checked = false;
        });   
    }
    });
    
    
//Loading
    
    var div_box = "<div id ='load-screen'><div id='loading'></div></div>"
    
    $("body").prepend(div_box);
    $('#load-screen').delay(100).fadeOut(100,function(){
        $(this).remove();
    });
   
});

//users online
    function loadUsersOnline(){
        $.get("functions.php?onlineusers=result", function(data){
            $(".usersonline").text(data);
            
        });
    }
setInterval(function(){ 
     loadUsersOnline();   
},500);














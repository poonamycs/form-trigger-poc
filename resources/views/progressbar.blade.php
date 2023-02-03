<!doctype html>
<html lang = "en">
   <head>
      <meta charset = "utf-8">
      <title>jQuery UI ProgressBar functionality</title>
      <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
      <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
      
      <style>
         .ui-widget-header {
            background: #cedc98;
            border: 1px solid #DDDDDD;
            color: #333333;
            font-weight: bold;
         }
      </style>
      </head>
      <body>
      <div id = "progressbar-2" style="width:40%"></div>
      <div id = "progressbar-1" style="width:40%"></div>
      <button id="pause">PAUSE</button>  
<button id="continue">CONTINUE</button> 
      <div id="email_error" style="color:red"></div>
      <form type="form">
        <p>
          <label>name : <input type="text" name="name" id="name" required/></label>
        </p>
        <p>
          <label>email : <input type="email" name="email" id="email" required/></label>
        </p>
        <p>
          <label>phone : <input type="number" name="phone_number" id="phone_number" required/></label>
          <input type="hidden" name="password" value="hello" id="password">
          <input type="hidden" name="div_id" id="div_id">
        </p>
        
        <p>
          <button type="button" class ="btn-submit">Submit</button>
        </p>
      </form>
      </body>
      <script>
         $(function() {
         var i=0;
         var percentValue =0 ;
         $("#pause").hide();
         $("#continue").hide();
          $(".btn-submit").click(function() {
                var msg = " ";
                var name = $('#name').val();
                var email = $('#email').val();
                var phone_number = $('#phone_number').val();
                var password = $('#password').val();
                if(name && email && phone_number)
                {
                    $.ajax({
                        type:'get',
                        url:"{{ url('form-submit') }}",
                        data:{name:name, 
                            email:email,
                            phone_number:phone_number,
                            password:password,
                            },
                        success:function(data){
                            console.log(data);
                            $('#div_id').val(data);
                        }
                    });
                    var progressbar = $( "#progressbar-2" );
                    
                    $( "#progressbar-2" ).progressbar({
                      value: 10,
                      max:100
                    });
                    setTimeout( progress, 10000 );
                    $("#pause").show();
                }
                else
                {
                  $("#progressbar-2").hide();
                    alert("Please Fill information first");
                }
            
            function progress() {
              var id = $('#div_id').val();
               if(id > 0){
               var val = progressbar.progressbar( "value" ) || 0;
               progressbar.progressbar( "value", val + 10 );
               if ( val < 99 ) {
                    i++;
                  setTimeout( progress, 2000 );
               }
               console.log(val);
               console.log(i);
                $('#pause').click(function(){
                        msg = "pause";
                        var progressbar1 = $( "#progressbar-1" );
                        $( "#progressbar-1" ).progressbar({
                        value: 10,
                        max:100
                        });
                    percentValue = i*10;
                    $("#progressbar-2").hide();
                    $("#continue").show();
                    $("#pause").hide();
                    progressbar1.progressbar( "value", percentValue );
                });
                $('#continue').click(function(){
                    $("#continue").hide();
                    $("#pause").show();
                    var progressbar1 = $( "#progressbar-1" );
                    setTimeout( progress1, 2000 );
                    function progress1()
                    {                        
                        if ( percentValue < 99 ) {
                                percentValue = percentValue + 10;
                                progressbar1.progressbar( "value", percentValue );
                            setTimeout( progress1, 2000 );
                        }
                        progressbar1.progressbar( "value", percentValue );
                    } 
                    msg = "continue";
                });
               if(val > 99 || percentValue > 99 && msg == "continue")
               {
                // alert(msg);
                    $.ajax({
                        type:'get',
                        url:"{{ url('status-change') }}",
                        data:{
                               id:id
                             },
                        success:function(data){
                            $('#div_id').html(data);
                        }
                    });
                }
                }
                else
                {
                  $('#email_error').html(id);
                  $("#progressbar-2").hide();
                  $("#pause").hide();
                }
              }
              
          });
         });
        
      </script>
   
</html>
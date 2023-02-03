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
          $(".btn-submit").click(function() {
            
            var name = $('#name').val();
                var email = $('#email').val();
                var phone_number = $('#phone_number').val();
                var password = $('#password').val();
                if(name && email && phone_number)
                {
                    $('#loader').show();
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
                    setTimeout( progress, 20000 );
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
               progressbar.progressbar( "value", val + 1 );
               if ( val < 99 ) {
                  setTimeout( progress, 200 );
               }
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
                else
                {
                  $('#email_error').html(id);
                  $("#progressbar-2").hide();
                }
              // }
              }
              
          });
         });
      </script>
   
</html>
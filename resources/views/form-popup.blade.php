<!DOCTYPE html>
<html>
<head>
    <title>Laravel Loading Spinner Example - ItSolutionStuff.com</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
  
    <style type="text/css">
        .loading {
            z-index: 20;
            position: absolute;
            top: 0;
            left:-5px;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }
        .loading-content {
            position: absolute;
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            top: 40%;
            left:50%;
            animation: spin 20000s linear infinite;
            }
              
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        #loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            background: rgba(0,0,0,0.75) url("/your_loading_image.gif") no-repeat center center;
            z-index: 99999;
        }
        .ui-widget-header {
            background: #cedc98;
            border: 1px solid #DDDDDD;
            color: #333333;
            font-weight: bold;
         }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
    @if(Session::has('error_message'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-bs-dismiss="alert">&times;</button>
        <strong>{!! session('error_message') !!}</strong>
    </div>
    @endif
    @if(Session::has('success_message'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-bs-dismiss="alert">&times;</button>
        <strong>{!! session('success_message') !!}</strong>
    </div>
    @endif
        <section id="loading">
            <div id="loading-content"></div>
        </section>
        <div id = "progressbar-2"></div>
        <div id='loader'></div>
        <div id="error_div"></div>
        <h2>Form For Trigger</h2>
        <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Time Slot</th>
            <th scope="col">Name</th>
            <th scope="col">Gender</th>
            <th scope="col">Batch</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
            <tr>
                <th scope="row">{{$admin->id}}</th>
                <td>{{$admin->user_time_slot}}</td>
                <td>{{$admin->name}}</td>
                <td>{{$admin->gender}}</td>
                @if($admin->batch_id)
                    <?php $admin_batch = App\Models\Batch::where('id',$admin->batch_id)->first();?>
                    <td>{{$admin_batch->name}}</td>
                @else 
                <td></td>
                @endif
                <td>@if($admin->batch_id == NULL) <button type="button" class="btn btn-primary open_modal" data-toggle="modal" data-id="{{$admin->id}}">Modal</button>@endif</td>
            </tr>
            @endforeach
        </tbody>
        </table>
        
        <input type="hidden" name="time_slot" id="time_slot" value={{$diff_in_hours}}>  <!-- time slot is differnece b/w times in batch table -->
        <input type="hidden" name="time_slot_divide" id="time_slot_divide"/>
    <div>
        
    </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form popup in every 10 mins</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <form action="{{url('/form-popup')}}" method="Post">@csrf
            <input type="hidden" name="id" id="id">
        <p>
        <label>Full name : <input type="text" name="full_name" id="full_name" required/></label>
        </p>
        <p>
        <label>Gender : <input type="radio" name="gender" id="gender"/>Male<input type="radio" name="gender" id="gender"/>Female</label>
        </p>
        <p>
        <label>Hobby : <input type="checkbox" name="hobby1" id="hobby1" value="Reading"/>Reading<input type="checkbox" name="hobby2" id="hobby2" value="writing"/>Writing</label>
        </p>
        <p>
        <label>Batch : <select name="batch">
         @foreach($batches as $batch)
            <option value="{{$batch->id}}">{{$batch->name}}</option>
        @endforeach
        </select></label>
        </p>
        <input type="hidden" name="user_time_slot_id" id="user_time_slot_id">
        <input type="hidden" name="user_time_slot" id="user_time_slot">
        <input type="hidden" name="open_id" id="open_id">
        <input type="hidden" name="close_id" id="close_id">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_modal">Close</button>
            <button type="submit" class="btn btn-primary" id="save_modal">Save changes</button>
        </div>
        </form>
        </div>
    </div>
    </div>
</body>
 
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // var global_id = 0;
    $(document).ready(function() {
        var interval = 0;
        var closeinterval = 0;
        var global_id = localStorage.getItem("global_id");
        alert(global_id);
        load();
        
        function load() {
            var time_slot = $("#time_slot").val(); //time_slot in hour
            var time_slot_sec = (time_slot*60*1000)/3; //here 3 is deivide into chunks

            var time_slot_divide = 30;//(time_slot*10000*60)/20000; //pop up will show n times
            $("#time_slot_divide").val(time_slot_divide);
            console.log(localStorage.getItem("global_id"));
                var interval = setInterval(myURL, time_slot_sec);
                var time_slot_close = time_slot_sec + 10000;
                var closeinterval = setInterval(myURLClose, time_slot_close);
                var time_slot_check = time_slot_close + 100;
                var checkinterval = setInterval(myURLCheck, time_slot_check); 
            
            
            // var interval = setInterval(myURL, 20000);
            // var closeinterval = setInterval(myURLClose, 30000);
            // var checkinterval = setInterval(myURLCheck, 31000);
        }
        function myURL() {  
            var time_slot_divide = $("#time_slot_divide").val();   
            if(global_id != time_slot_divide)
            {
                $("#exampleModal").modal("show");
                global_id = parseInt(global_id);
                global_id = global_id+1;    //it should be reset again n again
                localStorage.setItem("global_id", global_id);
                var time = new Date().toLocaleTimeString('en-GB', { hour: "numeric", minute: "numeric", second: "numeric"});
                var user_time_slot = $("user_time_slot").val(time);
                var user_time_slot_id = $("#user_time_slot_id").val(global_id); 
            }
            clearInterval(interval);
            
            // alert(global_id);
        }
        function myURLClose() {
            $("#exampleModal").modal("hide");
            var close_id = $("#close_id").val(1);     //when automatically close
            clearInterval(closeinterval);
            var user_time_slot_id = $("#user_time_slot_id").val();
            var time_slot_divide = $("#time_slot_divide").val();
            if(global_id < time_slot_divide)
            { 
                $.ajax({
                        type:'get',
                        url:"{{ url('alot-time-slot') }}",
                        data:{
                                user_time_slot_id:user_time_slot_id
                            },
                        success:function(data){
                        }
                    });
            }
        }
        function myURLCheck() {
            var close = $("#close_id").val();
            id = 1; //id of user to send mail
            $.ajax({
                    type:'get',
                    url:"{{ url('mail-send') }}",
                    data:{
                            id:id
                            },
                    success:function(data){
                        if(data == 1)
                        {
                            $("#close_id").val(' ');
                        }
                    }
                });
        }
        $(".open_modal").click(function(){
            var id = $(this).attr('data-id');
            // global_id = parseInt(global_id);
            // $("#user_time_slot_id").val(global_id);
            $("#exampleModal").modal("show");
            $("#id").val(id);
        });
    });
</script>
@yield('javascript')
  
</html>
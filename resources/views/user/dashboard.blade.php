@extends('user.layout')

@section('content')
<style>
.file-upload{display:block;text-align:center;font-family: Helvetica, Arial, sans-serif;font-size: 12px;}
.file-upload .file-select{display:block;border: 2px solid #dce4ec;color: #34495e;cursor:pointer;height:40px;line-height:40px;text-align:left;background:#FFFFFF;overflow:hidden;position:relative;}
.file-upload .file-select .file-select-button{background:#dce4ec;padding:0 10px;display:inline-block;height:40px;line-height:40px;}
.file-upload .file-select .file-select-name{line-height:40px;display:inline-block;padding:0 10px;}
.file-upload .file-select:hover{border-color:#34495e;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
.file-upload .file-select:hover .file-select-button{background:#34495e;color:#FFFFFF;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
.file-upload.active .file-select{border-color:#3fa46a;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
.file-upload.active .file-select .file-select-button{background:#3fa46a;color:#FFFFFF;transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;}
.file-upload .file-select input[type=file]{z-index:100;cursor:pointer;position:absolute;height:100%;width:100%;top:0;left:0;opacity:0;filter:alpha(opacity=0);}
.file-upload .file-select.file-select-disabled{opacity:0.65;}
.file-upload .file-select.file-select-disabled:hover{cursor:default;display:block;border: 2px solid #dce4ec;color: #34495e;cursor:pointer;height:40px;line-height:40px;margin-top:5px;text-align:left;background:#FFFFFF;overflow:hidden;position:relative;}
.file-upload .file-select.file-select-disabled:hover .file-select-button{background:#dce4ec;color:#666666;padding:0 10px;display:inline-block;height:40px;line-height:40px;}
.file-upload .file-select.file-select-disabled:hover .file-select-name{line-height:40px;display:inline-block;padding:0 10px;}
</style>
<div class="col-span-12 mt-8">
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5">
            Translation Center
        </h2>
    </div>

    @if ($message = Session::get('message'))
        <div class="alert alert-success mt-3">
            <p>{{ $message }}</p>
        </div>
    @endif
    
    <div class="intro-y box">
        <div id="vertical-form" class="p-5">
            <div class="preview">
                <div>
                  <form action="{{ route('user.store') }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="intro-x mt-4">
                        <input type="text" name="language1" class="intro-x login__input form-control py-3 px-4 block" required placeholder="Current Laguage of the Document">
                        <input type="text" name="language2" class="intro-x login__input form-control py-3 px-4 block mt-4" required placeholder="What Language does the Document needs to be Translated into?">
                        <input type="text" name="access_code" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Access Code (for returning customers)">
                        <input type="text" name="casemanager" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Case Manager (optional)">
                        <div class="file-upload mt-6">
                            <div class="file-select">
                              <div class="file-select-button" id="fileName">Choose File</div>
                              <div class="file-select-name" id="noFile">No file chosen...</div> 
                              <input required type="file" multiple name="files[]" id="chooseFile">
                            </div>
                          </div>                                
                    </div>
                  
                  <button type="submit" class="btn btn-primary mt-5">Upload File for Translation</button>
                </form>
                </div>
            </div>
           
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script>
  $('#chooseFile').bind('change', function () {
  var filename = $("#chooseFile").val();
  if (/^\s*$/.test(filename)) {
    $(".file-upload").removeClass('active');
    $("#noFile").text("No file chosen..."); 
  }
  else {
    $(".file-upload").addClass('active');
    $("#noFile").text(filename.replace("C:\\fakepath\\", "")); 
  }
});
</script>
@endsection
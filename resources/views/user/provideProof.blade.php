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
            Provide Evidence of Payment for Order ({{ $order->worknumber }})
        </h2>
    </div>

    @if ($message = Session::get('message'))
        <div class="alert alert-success mt-3">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="alert alert-primary show flex items-start mb-4 mt-4" role="alert"> Once submitted - your payment proof will be examined by our team. Please be patient in the process! </div>

    <div class="intro-y box">
        <div id="vertical-form" class="p-5">
            <div class="preview">
                <div>
                  <form action="{{ route('processProof') }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="intro-x mt-4">
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <div class="file-upload mt-6">
                            <div class="file-select">
                              <div class="file-select-button" id="fileName">Choose File</div>
                              <div class="file-select-name" id="noFile">No file chosen...</div> 
                              <input required type="file" multiple name="files[]" id="chooseFile">
                            </div>
                          </div>                                
                    </div>
                  
                    <div class="btn-group mt-5" role="group" aria-label="Basic example" style="margin-top: 3rem;">
                      <div style="float: left;margin: auto !important;"> 
                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#superlarge-modal-size-preview" class="btn btn-pending">Need to attach multiple files?</a>                      </div> 
                        
                        <div id="superlarge-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog">
                              <div class="modal-content" style="width: 640px !important;">
                                  <div class="modal-body p-10 text-center"> 
                                    <iframe style="padding:20px;" width="560" height="315" src="https://www.youtube.com/embed/Kt9mLwSOARc"
                                     title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                      allowfullscreen></iframe>

                                     
                                  </div>
                              </div>
                          </div>
                      </div> 
                      <button type="submit" class="btn btn-primary ml-3">Upload Evidence</button> 
                    </div>
                  
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
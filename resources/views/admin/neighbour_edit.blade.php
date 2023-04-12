@extends('layouts.backends.master')
@section('title','Agent Info Update')
@section('content')

<div class="row mb-1">
    <div class="col-8">
    <h2 class="content-header-title float-left mb-0">Neighbour Update</h2>
    </div>
    <div class="col-4 d-flex flex-row-reverse">
    <a class="btn btn-primary btn-round btn-sm " href="{{route('admin.neighbour.index')}}">Neighbour List</a>
    </div>
</div>
<div class="content-body">
    <!-- Basic Tables start -->
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">     
                <div class="card-header">
                    <img style="height:220px; width:220px;" src="{{ $dataInfo->photo }}" alt="" srcset=""></div>      
                <div class="card-body">
                    <form class="row" id="ajax_form" action="{{route('admin.neighbour.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="dataId" value="{{ $dataInfo->id }}">
                        <div class="col-6 form-group">
                            <strong>Photo:</strong>
                            <input type="file" name="photo" class="form-control" >
                             <span style="color:red" ></span>
                        </div>
                         <div class="col-6 form-group">
                            <strong>Name:</strong>
                            <input type="text" name="name" placeholder="Name" class="form-control" required  value="{{ $dataInfo->name }}">
                             <span style="color:red" ></span>
                        </div>
                        <div class="col-6 form-group">
                            <strong>Title One:</strong>
                            <input type="text" name="titleOne" placeholder="Title One" class="form-control"  required value="{{ $dataInfo->titleOne }}">
                             <span style="color:red" ></span>
                        </div>
                        <div class="col-6 form-group">
                            <strong>Title Two:</strong>
                            <input type="text" name="titleTwo" placeholder="TitleTwo" class="form-control"  required value="{{ $dataInfo->titleTwo }}">
                             <span style="color:red" ></span>
                        </div>
                        <div class="col-6 form-group">
                            <strong>Title Three:</strong>
                            <input type="text" name="titleThree" placeholder="Last Name" class="form-control"  required value="{{ $dataInfo->titleThree }}">
                             <span style="color:red" ></span>
                        </div>
                        <div class="col-6 form-group">
                            {{-- <strong>Title Three:</strong>
                            <input type="text" name="titleThree" placeholder="Last Name" class="form-control"  required>
                             <span style="color:red" ></span> --}}
                        </div>
                        <div class="col-6 form-group">
                            <strong>Title One Details:</strong>
                            <textarea name="titleOneDetails" id="" cols="30" rows="10" class="form-control">{{ $dataInfo->titleOneDetails }}</textarea>
                             <span style="color:red" ></span>
                        </div>
                        <div class="col-6 form-group">
                            <strong>Title Two Details:</strong>
                            <textarea name="titleTwoDetails" id="" cols="30" rows="10" class="form-control">{{ $dataInfo->titleTwoDetails }}</textarea>
                             <span style="color:red" ></span>
                        </div>
                        <div class="col-6 form-group">
                            <strong>Title Three Details:</strong>
                            <textarea name="titleThreeDetails" id="" cols="30" rows="10" class="form-control">{{ $dataInfo->titleThreeDetails }}</textarea>
                             <span style="color:red" ></span>
                        </div>
                        <div class="col-12 d-flex flex-row-reverse">
                            <button class="btn btn-primary btn-icon" type="submit">
                               <i data-feather='save'></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
       
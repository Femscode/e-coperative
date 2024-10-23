@extends('vendordashboard.master')
@section('header')

@endsection

@section('content')


<div class="container-fluid">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
            <div class="row">

                <!-- Sales Card -->

                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card p-4">
                        <h4>Event Catering Profile.</h4>
                        <p class="d-flex align-items-center border p-2 rounded-2 border-dashed bg-body text-start mb-2">https://cttaste.com/{{ $user->slug }} <a href="#!" class="ms-auto fs-4"><i class="ti ti-copy"></i></a></p>
                            
                        @if($event->display_image !== null)
                        <img src='https://cttaste.com/cttaste_files/public/event_image/{{ $event->display_image }}' style='height:300px' height='300' width='300'
                            class="img-fluid rounded" alt="Display image">
                        @endif
                        <br>

                        <form method='post' action='/updateevent' enctype="multipart/form-data">@csrf
                            <div class='alert alert-primary'>Describe your event catering options briefly</div>

                            <label>Title (Short Description)</label>
                            <input type='hidden' value='{{ $event->id }}' name='eventId' />
                            <textarea type='text' rows="6" class='form-control'
                                name='title'>{{ $event->title }}</textarea>
                            <label>Display Image</label>
                            <input type='file' class='form-control' name='image' value='{{ $event->title }}' />
                            <br>
                            <div class='d-flex justify-content-center align-items-center'>
                                <button type='submit' style='margin:auto;' class='btn btn-primary'>Update</button>
                            </div>

                        </form>

                    </div>
                </div><!-- End Sales Card -->

                <div class='col-md-8'>
                    @if($event->display_image !== null)

                    <div class="card info-card sales-card p-4 ">
                        <h4>Upload Other Event Catering Images</h4>
                        <div class='alert alert-primary'>For fast upload, please do not select more than five(5)
                            pictures
                            at a time.
                        </div>
                        

                        <form method='post' action='/saveadditionalimages' enctype="multipart/form-data">@csrf
                            <input type='hidden' name='id' value='{{ $event->id }}' />
                            <input multiple accept="image/*" class='form-control' type='file' name='images[]' /><br>
                            <button type='submit' class='btn btn-primary' style=''>Upload</button>

                        </form>

                    </div>



                    <div class="card recent-sales overflow-auto">



                        <div class="card-body">
                            <h5 class="card-title">Additional Images</h5>
                            <!-- Gallery -->
                            <div class="row">
                                @foreach($additionalimages as $img)
                                <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
                                    <div class="position-relative">
                                        <img src='https://cttaste.com/cttaste_files/public/event_additional_image/{{ $img->image }}'
                                            class="w-100 shadow-1-strong rounded mb-4" style='height:250px' alt="Additional Images" />
                                        <a href='/deleteeventimage/{{ $img->id}}' type="button"
                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2"><i class='bx bx-trash'></i></a>
                                    </div>
                                </div>
                                @endforeach


                            </div>
                            <!-- Gallery -->


                        </div>

                    </div>

                    @endif
                </div>
            </div>
        </div><!-- End Left side columns -->



    </div>

</div>
@endsection

@section('script')

@endsection
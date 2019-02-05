@include('regulatory/RegulatoryMain')
<div class="page-content">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-title">
            <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
        </div>
    </div>
    @if(Session::has('message'))
        {{ Session::get('message') }}
    @endif
    {{ $details }}
<style>
    .BtnClass{
        background-color: #0063DC;
        color: white;
        padding: 50px 30px 50px 30px;
        text-decoration: none;
        font-weight: bold;
        font-size: 16px;
    }
    .BtnClass:hover, .BtnClass:focus {
        color: white !important;
        text-decoration: underline;
    }
</style>
<br><br><br><br><br><br><br><br><br><br><br><br>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <a href="RunSubmission" class="BtnClass">Run Submission</a>
            </div>
            <div class="col-lg-4">
                <a href="UploadSubmission" class="BtnClass">Upload Submission</a>
            </div>
            <div class="col-lg-4">
                <a href="SubmissionHistory" class="BtnClass">Submission History</a>
            </div>
        </div>
    </div>
</section>
</div>
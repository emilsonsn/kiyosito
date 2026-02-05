@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-md-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    @if (file_exists($pdf))
                        <iframe class="frame-wrapper" src="{{ whitePaperLink() }}" frameborder="0"></iframe>
                    @else
                        <h5 class="text-center py-5">{{ __($emptyMessage) }}</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ADD PHASE MODAL -->
    <div id="uploadModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Upload White Paper')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.white.paper.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <input type="file" accept=".pdf, .PDF" required name="pdf" id="pdf"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END ADD PHASE MODAL -->
@endsection

@push('breadcrumb-plugins')

    @if (file_exists($pdf))
        <a class="btn btn-sm btn-outline--primary" href="{{ whitePaperLink() }}" download>
            <i class="las la-cloud-download-alt"></i> @lang('Download PDF')</a>
    @endif
    <button type="button" class="btn btn-sm btn-outline--info uploadBtn"><i
            class="las la-cloud-upload-alt"></i>@lang('Upload')</button>
@endpush


@push('script')
    <script>
        (function($) {

            "use strict";


            $('.uploadBtn').on('click', function() {
                var modal = $('#uploadModal');
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .frame-wrapper {
            width: 100%;
            min-height: 700px !important;
        }
    </style>
@endpush

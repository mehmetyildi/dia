@extends('layouts.cms')
@section('title') <title>{{ config('app.cms_name') }} | Düzenle</title> @endsection
@section('styles')
	@include('cms.includes.form-partials.css-inserts')
@endsection
@section('content')

@component('cms.components.breadcrumb') 
	@slot('page') Düzenle @endslot
	<li><a href="{{ route('cms.'.$pageUrl.'.index') }}">{{ $pageName }}</a></li>
@endcomponent

<div class="wrapper wrapper-content animated fadeInRight">
   	<div class="row">
	   	{!! Form::model($record, ['route' => ['cms.'.$pageUrl.'.update', $record->id], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
	   		{!! method_field('PUT') !!}
		    <div class="col-lg-1 formActions">
		    	<a href="{{ route('cms.'.$pageUrl.'.index') }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left"></i> Geri</a>
		    	@can('edit_content')
		    	<button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Güncelle</button>
		    	@endcan
		    	@can('delete_content')
		    	<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> Sil</button>
		    	@endcan
				<hr>
				<h5><i class="fa fa-info-circle" style="float:none;"></i> Daha fazla...</h5>
				<hr>
				<a href="{{ route('cms.'.$pageUrl.'.gallery', ['record' => $record->id]) }}" class="btn btn-success btn-sm"><i class="fa fa-picture-o"></i>  Galeri</a>
		    </div>
		    <div class="col-lg-6">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><i class="fa fa-picture-o"></i> Görseller</h5>
						@include('cms.includes.form-partials.ibox-resize')
					</div>
					<div class="ibox-content">
						@include('cms.includes.crop-image-area', ['title' => 'Ana Görsel (1200x750)', 'field' => 'main_image', 'ratio' => '1.6', 'required' => false])
					</div>
				</div>
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><i class="fa fa-info-circle"></i> İçerik Bilgileri</h5>
						@include('cms.includes.form-partials.ibox-resize')
					</div>
					<div class="ibox-content">
						<div class="form-group">
							<label class="control-label col-sm-3">Makale Tarihi</label>
							<div class="col-sm-9">
								<div class="input-group date date2">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="actual_date" autocomplete="off" value="{{ $record->actual_date ? convertDate($record->actual_date) : '' }}">
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label class="col-sm-3 control-label">URL</label>
							<div class="col-sm-9">
								<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" href="#tab-url_tr"> TR</a></li>
									<li class=""><a data-toggle="tab" href="#tab-url_en">EN</a></li>
								</ul>
								<div class="tab-content">
									<div id="tab-url_tr" class="tab-pane active">
										{!! Form::text('url_tr', null, ['class' => 'form-control']) !!}
									</div>
									<div id="tab-url_en" class="tab-pane">
										{!! Form::text('url_en', null, ['class' => 'form-control']) !!}
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label class="col-sm-3 control-label">Başlık</label>
							<div class="col-sm-9">
								<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" href="#tab-title_tr"> TR</a></li>
									<li class=""><a data-toggle="tab" href="#tab-title_en">EN</a></li>
								</ul>
								<div class="tab-content">
									<div id="tab-title_tr" class="tab-pane active">
										{!! Form::text('title_tr', null, ['class' => 'form-control']) !!}
									</div>
									<div id="tab-title_en" class="tab-pane">
										{!! Form::text('title_en', null, ['class' => 'form-control']) !!}
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label class="col-sm-3 control-label">Ön Yazı</label>
							<div class="col-sm-9">
								<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" href="#tab-caption_tr"> TR</a></li>
									<li class=""><a data-toggle="tab" href="#tab-caption_en">EN</a></li>
								</ul>
								<div class="tab-content">
									<div id="tab-caption_tr" class="tab-pane active">
										{!! Form::textarea('caption_tr', null, ['class' => 'form-control', 'rows' => '3']) !!}
									</div>
									<div id="tab-caption_en" class="tab-pane">
										{!! Form::textarea('caption_en', null, ['class' => 'form-control', 'rows' => '3']) !!}
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label class="col-sm-3 control-label">Yazı</label>
							<div class="col-sm-9">
								<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" href="#tab-description_tr"> TR</a></li>
									<li class=""><a data-toggle="tab" href="#tab-description_en">EN</a></li>
								</ul>
								<div class="tab-content">
									<div id="tab-description_tr" class="tab-pane active">
										{!! Form::textarea('description_tr', null, ['class' => 'form-control ckeditor', 'rows' => '3']) !!}
									</div>
									<div id="tab-description_en" class="tab-pane">
										{!! Form::textarea('description_en', null, ['class' => 'form-control ckeditor', 'rows' => '3']) !!}
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label class="col-sm-3 control-label">Video Linki</label>
							<div class="col-sm-9">
								{!! Form::text('video_path', null, ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
				</div>
		    </div>
			<div class="col-lg-5">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><i class="fa fa-bullhorn"></i> Vitrin</h5>
						@include('cms.includes.form-partials.ibox-resize')
					</div>
					<div class="ibox-content">
						<div class="form-group">
							<label class="col-sm-3 control-label" for="promote">Vitrine Al</label>
							<div class="col-sm-9">
								<input type="checkbox" name="promote" class="js-switch js-switch2" {{ $record->promote ? 'checked' : '' }}/>
							</div>
						</div>
						<hr>
					</div>
				</div>
				@include('cms.includes.form-partials.edit-publish-settings')
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><i class="fa fa-upload"></i> Yüklenmiş Öğeler</h5>
						@include('cms.includes.form-partials.ibox-resize')
					</div>
					<div class="ibox-content clearfix">
						@if($record->main_image)
							<div class="form-group">
								<label class="control-label col-sm-3">
									Mevcut Ana Görsel <br><br>
									<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteMainImage"><i class="fa fa-trash"></i> Sil</button>
								</label>
								<div class="input-group col-sm-9">
									<img src="{{ url('storage/'.$record->main_image) }}" class="img-responsive" alt="">
								</div>
							</div>
						@else
							Yüklenmiş Bir Ana Görsel Yok
						@endif
						<hr>
						@if(strpos($record->video_path, 'https://www.youtube.com/embed/') !== false || strpos($record->video_path, 'https://player.vimeo.com/') !== false)
							<div class="form-group">
								<label class="control-label col-sm-3">Mevcut Video</label>
								<div class="input-group col-sm-9">
									<div class="controls embed-responsive embed-responsive-16by9" >
										<iframe class="embed-responsive-item" src="{{ $record->video_path }}" style="width:100%;"></iframe>
									</div>
									<small>*Videoyu silmek için "Video Linki" alanındaki linki silip, kaydı güncelleyin.</small>
								</div>
							</div>

						@else
							Yüklenmiş Bir Video Yok
						@endif

				</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</div>

<!-- Delete Object Modal -->
@include('cms.includes.delete-object-modal', [
	'modal_id' => 'deleteMainImage',
	'field' => 'main_image',
	'route' => 'cms.'.$pageUrl.'.delete-file',
	'id' => ['record' => $record->id]
])
<!-- End Delete Object Modal -->

<!-- Delete Modal -->
@include('cms.includes.delete-modal', [
	'modal_id' => 'deleteModal', 
	'route' => 'cms.'.$pageUrl.'.delete', 
	'id' => ['role' => $record->id]
])
<!-- End Delete Modal -->

@endsection

@section('scripts')
	@include('cms.includes.form-partials.js-inserts')
	<script>
		$(document).ready(function(){
            new Switchery(document.querySelector('.js-switch1'), { color: '#1AB394' });
            new Switchery(document.querySelector('.js-switch2'), { color: '#1AB394' });
            $('.input-group.date1').datepicker({
                todayHighlight: true,
                format: "dd/mm/yyyy",
                weekStart: 1,
                startDate: "{{ todayWithFormat('d/m/Y') }}"
            });
            $('.input-group.date2').datepicker({
                todayHighlight: true,
                format: "dd/mm/yyyy",
                weekStart: 1
            });
        });
	</script>
@endsection
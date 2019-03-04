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
		    </div>
			<div class="col-lg-6">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><i class="fa fa-picture-o"></i> Görseller</h5>
						@include('cms.includes.form-partials.ibox-resize')
					</div>
					<div class="ibox-content">
						@include('cms.includes.crop-image-area', ['title' => 'Görsel (TR) (700x500)', 'field' => 'image_path_tr', 'ratio' => '1.4', 'required' => false])
						@include('cms.includes.crop-image-area', ['title' => 'Görsel (EN) (700x500)', 'field' => 'image_path_en', 'ratio' => '1.4', 'required' => false])
					</div>
				</div>
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><i class="fa fa-info-circle"></i> İçerik Bilgileri</h5>
						@include('cms.includes.form-partials.ibox-resize')
					</div>
					<div class="ibox-content">
						<div class="form-group">
							<label class="col-sm-3 control-label">Adı</label>
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
							<label class="col-sm-3 control-label">Video Linki</label>
							<div class="col-sm-9">
								{!! Form::text('video_path', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label class="col-sm-3 control-label">Link</label>
							<div class="col-sm-9">
								{!! Form::text('link', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label class="col-sm-3 control-label">Süre (sn.)</label>
							<div class="col-sm-9">
								{!! Form::number('duration', null, ['class' => 'form-control', 'step' => '1']) !!}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-5">
				@include('cms.includes.form-partials.edit-publish-settings')
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><i class="fa fa-upload"></i> Yüklenmiş Öğeler</h5>
						@include('cms.includes.form-partials.ibox-resize')
					</div>
					<div class="ibox-content">
						@if($record->image_path_tr)
							<div class="form-group">
								<label class="control-label col-sm-3">
									Mevcut Türkçe görsel <br><br>
									<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteTrImage"><i class="fa fa-trash"></i> Sil</button>
								</label>
								<div class="input-group col-sm-9">
									<img src="{{ url('storage/'.$record->image_path_tr) }}" class="img-responsive" alt="">
								</div>
							</div>
						@else
							Yüklenmiş bir Türkçe görsel yok.
						@endif
						<hr>
						@if($record->image_path_en)
							<div class="form-group">
								<label class="control-label col-sm-3">
									Mevcut İngilizce görsel <br><br>
									<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteEnImage"><i class="fa fa-trash"></i> Sil</button>
								</label>
								<div class="input-group col-sm-9">
									<img src="{{ url('storage/'.$record->image_path_en) }}" class="img-responsive" alt="">
								</div>
							</div>
						@else
							Yüklenmiş bir İngilizce görsel yok.
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
    'modal_id' => 'deleteTrImage',
    'field' => 'image_path_tr',
    'route' => 'cms.'.$pageUrl.'.delete-file',
    'id' => ['record' => $record->id]
])
<!-- End Delete Object Modal -->

<!-- Delete Object Modal -->
@include('cms.includes.delete-object-modal', [
    'modal_id' => 'deleteEnImage',
    'field' => 'image_path_en',
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
            $('.input-group.date1').datepicker({
                todayHighlight: true,
                format: "dd/mm/yyyy",
                weekStart: 1,
                startDate: "{{ todayWithFormat('d/m/Y') }}"
            });
        });
	</script>
@endsection
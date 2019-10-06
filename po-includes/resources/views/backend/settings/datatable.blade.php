@extends('layouts.app')
@section('title', 'Settings')

@section('content')
	<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-20">
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="{{ url('/dashboard/themes/table') }}">Appearance</a></li>
					<li class="breadcrumb-item"><a href="{{ url('/dashboard/settings/table') }}">Settings</a></li>
					<li class="breadcrumb-item active" aria-current="page">List Settings</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">List Settings</h4>
		</div>
		
		<div><a href="{{ url('dashboard/settings/create') }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-t-10"><i data-feather="plus" class="wd-10 mg-r-5"></i> Add</a></div>
	</div>
	
	<div class="card">
		<div class="card-body pd-b-0">
			{!! Form::open(['url' => 'dashboard/settings/deleteall', 'method' => 'post', 'class' => 'form-horizontal']) !!}
				<input type="hidden" name="totaldata" id="totaldata" value="0" />
				<div class="table-wrapper">
					<table id="settings-table" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th style="text-align:center;" width="15"></th>
								<th style="text-align:center;" width="25">ID</th>
								<th>Group</th>
								<th>Options</th>
								<th>Value</th>
								<th width="120">Create By</th>
								<th style="text-align:center;" width="140">Actions</th>
								<th></th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<td style="width:10px;" style="text-align:center;">
									<input type="checkbox" id="titleCheck" data-toggle="tooltip" title="Check All" />
								</td>
								<td colspan="6">
									<button class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target="#alertalldel"><i class="fa fa-trash"></i> Delete Selected</button>
								</td>
								<td></td>
							</tr>
						</tfoot>
					</table>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection

@push('scripts')
<script type="text/javascript">
	$(function() {
		'use strict'
		
		var table = $('#settings-table').DataTable({
			processing: true,
			serverSide: true,
			stateSave: true,
			responsive: {
				details: {
					type: 'column',
					target: -1
				}
			},
			ajax: '{{ url("dashboard/settings/data") }}',
			autoWidth: false,
			order: [[1, 'asc']],
			columnDefs: [{
				targets: 'no-sort',
				orderable: false
			},{
				className: 'control',
				orderable: false,
				targets:   -1
			}],
			columns: [
				{ data: 'check', name: 'check', orderable: false, searchable: false },
				{ data: 'id', name: 'settings.id' },
				{ data: 'groups', name: 'settings.groups' },
				{ data: 'options', name: 'settings.options' },
				{ data: 'value', name: 'settings.value' },
				{ data: 'uname', name: 'users.name' },
				{ data: 'action', name: 'action', orderable: false, searchable: false },
				{ data: 'control', name: 'control', orderable: false, searchable: false },
			],
			drawCallback: function(settings) {
				$("#titleCheck").click(function() {
					var checkedStatus = this.checked;
					$("table tbody tr td div:first-child input[type=checkbox]").each(function() {
						this.checked = checkedStatus;
						if (checkedStatus == this.checked) {
							$(this).closest('table tbody tr').removeClass('selected');
							$(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
							$('#totaldata').val($('table tbody input[type=checkbox]:checked').length);
						}
						if (this.checked) {
							$(this).closest('table tbody tr').addClass('selected');
							$(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
							$('#totaldata').val($('table tbody input[type=checkbox]:checked').length);
						}
					});
				});	
				$('table tbody tr td div:first-child input[type=checkbox]').on('click', function () {
					var checkedStatus = this.checked;
					this.checked = checkedStatus;
					if (checkedStatus == this.checked) {
						$(this).closest('table tbody tr').removeClass('selected');
						$(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
						$('#totaldata').val($('table tbody input[type=checkbox]:checked').length);
					}
					if (this.checked) {
						$(this).closest('table tbody tr').addClass('selected');
						$(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
						$('#totaldata').val($('table tbody input[type=checkbox]:checked').length);
					}
				});
				$('table tbody tr td div:first-child input[type=checkbox]').change(function() {
					$(this).closest('tr').toggleClass("selected", this.checked);
				});
				deleter.init();
				$('[data-toggle="tooltip"]').tooltip();
			},
			language: {
				searchPlaceholder: 'Search...',
				sSearch: '',
				lengthMenu: '_MENU_ items/page',
			}
		});
		
		$('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
	});
</script>
@endpush

@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="card">
			<div class="card-header">My Suppliers <a href="{{ url('suppliers/create/new') }}" class="float-right">Add Supplier</a></div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-stripped">
						<thead>
							<tr>
								<th>S/N</th>
								<th>Name</th>
								<th>Email</th>
								<th>Added on</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@forelse($suppliers as $supplier)
								<tr>
									<td>
										{{ $supplier->id }}
									</td>
									<td>
										{{ $supplier->name }}
									</td>
									<td>{{ $supplier->email }}</td>
									<td>
										{{ $supplier->created_at }}
									</td>
									<td>
										<a href="{{ url('suppliers/'.$supplier->id . '/edit') }}">Edit</a> | 
										<a href="{{ url('suppliers/'.$supplier->id.'/pay') }}">Pay</a>
									</td>
								</tr>
							@empty
							You have not added any suppliers yet. When you do, you will see them here
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection
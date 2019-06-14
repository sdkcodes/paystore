@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="table-responsive">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>S/N</th>
								<th>Paid to</th>
								<th>Amount Paid (N)</th>
								<th>Paid on</th>
							</tr>
						</thead>
						<tbody>
							@forelse($payments as $payment)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>
										{{ $payment->supplier->name }}
									</td>
									<td>
										{{ $payment->amount}}
									</td>
									<td>
										{{ $payment->created_at->toFormattedDateString() }}
									</td>
								</tr>
							@empty
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection
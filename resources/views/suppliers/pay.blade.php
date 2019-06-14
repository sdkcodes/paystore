@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Pay {{ $supplier->name }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('payments/create/'.$supplier->id) }}">
                    	{{ csrf_field() }}
                    	<div class="form-group">
                    		<label>How much do you want to pay this supplier</label>
                    		<input type="number" name="amount" id="amount" class="form-control" placeholder="20000" required> 
                    	</div>
                    	<button class="btn btn-primary" type="submit">Pay supplier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-12">
    		<div class="card">
    			<div class="card-header">Past payments to {{ $supplier->name }}</div>
    			<div class="card-body">
    				<div class="table-responsive">
    					<table class="table table-striped table-bordered">
    						<thead>
    							<tr>
    								<th>S/N</th>
    								<th>Amount paid (N)</th>
    								<th>Paid on</th>
    							</tr>
    						</thead>
    						<tbody>
    							@forelse($history as $payment)
	    							<tr>
	    								<td>{{ $loop->iteration }}</td>
	    								<td>
	    									{{$payment->amount}}
	    								</td>
	    								<td>
	    									{{ $payment->created_at->toFormattedDateString() }}
	    								</td>
	    							</tr>
    							@empty
    							You have not made any payment to {{ $supplier->name }} in the past
    							@endforelse
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
@endsection

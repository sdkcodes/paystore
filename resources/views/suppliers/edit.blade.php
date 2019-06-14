@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="card">
			<div class="card-header">Update details of {{ $supplier->name }}</div>
			<div class="card-body">
				<div class="row">
				    <div class="col-12">
				        
		                <form method="POST" action="{{ url('suppliers/'.$supplier->id . '/edit') }}">
		                    @if ($errors->any())
		                        <div class="alert alert-danger">
		                            <ul>
		                                @foreach ($errors->all() as $error)
		                                    <li>{{ $error }}</li>
		                                @endforeach
		                            </ul>
		                        </div>
		                    @endif
		                    {{ method_field('PUT')}}
		                    {{ csrf_field() }}
		                    <div class="form-group">
		                        <label for="">Supplier name</label>
		                        <input type="text" name="name" placeholder="Supplier name" id="" class="form-control" value="{{ $supplier->name }}">
		                    </div>
		                    <div class="form-group">
		                        <label for="">Email</label>
		                        <input type="email" name="email" class="form-control" value="{{ $supplier->email }}" placeholder="email@example.com">
		                    </div>
		                    <div class="form-group">
		                        <label for="">Phone number</label>
		                        <input type="text" name="phone" class="form-control" placeholder="Phone number" value="{{ $supplier->phone }}"> 
		                    </div>
		                    
		                    <div class="form-group">
		                        <label for="">Bank Name</label>
		                        <select name="bank_name" id="banks" class="form-control">
		                        	<option value="">Select a bank</option>
		                        	@forelse($banks as $bank)
		                        	<option value="{{ $bank->name }}" {{ $bank->name == $supplier->bank_name ? 'selected' : '' }}>{{ $bank->name }}</option>
		                        	@empty
		                        		
		                        	@endforelse
		                        </select>
		                    </div>
		                    <div class="form-group">
		                        <label for="">Bank Account number</label>
		                        <input type="text" name="account_number" class="form-control" placeholder="Account number" value="{{ $supplier->account_number }}" required>
		                    </div>
		                    <div class="form-group">
		                        <label for="">Bank Account name</label>
		                        <input type="text" name="account_name" placeholder="Account name" class="form-control" value="{{ $supplier->account_name }}" required>
		                    </div>
		                    
		                    <div class="form-group">
		                        <button class="btn btn-primary" type="submit">Update supplier</button>
		                    </div>
		                </form>
				            
				    </div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('after_scripts')
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
    	let paystackPublicKey = "{{env('PAYSTACK_PUBLIC_KEY')}}";
    	function retrieveBanks(){
    		axios.get("https://api.paystack.co/bank", {headers: {
    		    Authorization: "Bearer " + paystackPublicKey
    		}}).then(res => {
    		    console.log(res)
    		    $.each(res.data.data, (i, obj) => {
    		        $("#banks").append($("<option>").text(obj.name).attr("value", obj.name))
    		    })
    		})	
    	}
        
    </script>
@endsection
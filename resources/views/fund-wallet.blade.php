@extends('layout.main')
@section('content')

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/67de576c5a8f99190f7211c2/1imu8b0nm';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script--> 
    <section id="technologies mt-4 my-5">
        <div class="container title my-5">
            <div class="row justify-content-center text-center wow fadeInUp" data-wow-delay="0.2s">
                <div class="col-md-8 col-xl-6">
                    <h4 class="mb-3 text-danger">Hi {{ Auth::user()->name }},</h4>
                    <p class="mb-0">
                        <a href="fund-wallet" class="btn btn-dark" >Fund Your Wallet</a>
                    </p>
                </div>
            </div>
        </div>


        <div class="container technology-block">

            <div class="row p-3">
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            @if (session()->has('error'))
                                <div class="alert alert-danger">
                                    <strong>Error:</strong> {{ session()->get('error') }}
                                    @if(config('app.debug'))
                                        <br><small class="text-muted">Debug: Check the application logs for more details.</small>
                                    @endif
                                </div>
                            @endif

                            <form id="fund-form" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="1">

                                <label class="my-2 fw-bold">Enter the Amount (NGN)</label>
                                <input type="number" name="amount" id="amount-input" class="form-control form-control-lg" min="1000" max="100000"
                                placeholder="Enter the Amount you want to Add" required>

                                <div id="payment-method-section" class="mt-4" style="display: none;">
                                    <label class="my-2 fw-bold">Select Payment Method</label>
                                    <select name="payment_method" id="payment-method-select" class="form-control form-control-lg" required>
                                        <option value="">Choose a payment method...</option>
                                         <option value="payvibe">PayVibe - Virtual Account</option>
                                         {{-- <option value="xtrapay">XtraPay - Instant Payment</option> --}}
                                    </select>

                                    <button type="submit"
                                            class="btn btn-primary btn-lg w-100 mt-4" id="submit-btn">
                                        <i class="fas fa-plus-circle me-2"></i>Add Funds
                                    </button>
                                </div>
                            </form>

                            <style>
                                .form-control-lg {
                                    padding: 12px 16px;
                                    font-size: 16px;
                                    border-radius: 8px;
                                }
                                
                                .btn-lg {
                                    padding: 12px 24px;
                                    font-size: 16px;
                                    border-radius: 8px;
                                }
                                
                                #payment-method-section {
                                    transition: all 0.3s ease;
                                    opacity: 0;
                                }
                                
                                .card {
                                    border-radius: 12px;
                                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                                }
                                
                                .card-body {
                                    padding: 2rem;
                                }
                                
                                /* Mobile responsive styles */
                                @media (max-width: 768px) {
                                    .card-body {
                                        padding: 1rem;
                                    }
                                    
                                    .table-responsive {
                                        font-size: 12px;
                                    }
                                    
                                    .btn-lg {
                                        padding: 10px 20px;
                                        font-size: 14px;
                                    }
                                    
                                    .form-control-lg {
                                        padding: 10px 14px;
                                        font-size: 14px;
                                    }
                                }
                                
                                /* Table improvements */
                                .table th {
                                    background-color: #f8f9fa;
                                    border-bottom: 2px solid #dee2e6;
                                    font-weight: 600;
                                }
                                
                                .table td {
                                    vertical-align: middle;
                                }
                                
                                .badge {
                                    font-size: 0.75em;
                                }
                            </style>

                            <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const amountInput = document.getElementById('amount-input');
                                const paymentSection = document.getElementById('payment-method-section');
                                const fundForm = document.getElementById('fund-form');
                                
                                if (amountInput && paymentSection) {
                                    amountInput.addEventListener('input', function() {
                                        const amount = this.value;
                                        
                                        if (amount && amount >= 1000) {
                                            paymentSection.style.display = 'block';
                                            paymentSection.style.opacity = '1';
                                        } else {
                                            paymentSection.style.display = 'none';
                                            paymentSection.style.opacity = '0';
                                        }
                                    });
                                }
                                
                                if (fundForm) {
                                    fundForm.addEventListener('submit', function(e) {
                                        e.preventDefault();
                                        
                                        const paymentMethod = document.getElementById('payment-method-select').value;
                                        const amount = document.getElementById('amount-input').value;
                                        
                                        if (!paymentMethod) {
                                            alert('Please select a payment method');
                                            return;
                                        }
                                        
                                        if (!amount || amount < 1000) {
                                            alert('Please enter a valid amount (minimum NGN 1,000)');
                                            return;
                                        }
                                        
                                        // Set the form action based on selected payment method
                                        if (paymentMethod === 'xtrapay') {
                                            this.action = 'fund-now-xtrapay';
                                        } else if (paymentMethod === 'payvibe') {
                                            this.action = 'fund-now-payvibe';
                                        }
                                        
                                        // Show loading state
                                        const submitBtn = document.getElementById('submit-btn');
                                        if (submitBtn) {
                                            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                                            submitBtn.disabled = true;
                                        }
                                        
                                        // Submit the form
                                        this.submit();
                                    });
                                }
                            });
                            </script>

                                <a href="https://faddedsms.com/api/verify" class="btn btn-danger w-100  my-4">Having deposit issue? resolve here</a>

                        </div>

                    </div>


                </div>


                <div class="col-lg-6 col-sm-12">
                    <div class="card border-0 shadow-lg p-3 mb-5 bg-body rounded-40">

                        <div class="card-body">


                            <div class="">

                                <div class="p-2 col-lg-6">
                                    <strong>
                                        <h4>Latest Transactions</h4>
                                    </strong>
                                </div>

                                <div>


                                    <div class="table-responsive ">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Verify</th>
                                                <th>Date</th>

                                            </tr>
                                            </thead>
                                            <tbody>


                                            @forelse($transaction as $data)
                                                <tr>
                                                    <td style="font-size: 12px;">{{ $data->id }}</td>
                                                    <td style="font-size: 12px;">₦{{ number_format($data->final_amount, 2) }}</td>
                                                    <td>
                                                        @if ($data->status == 1)
                                                            <span class="badge bg-warning text-dark">Pending</span>
                                                        @elseif ($data->status == 2)
                                                            <span class="badge bg-success">Completed</span>
                                                        @else
                                                            <span class="badge bg-secondary">Unknown</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($data->method == 118 && $data->status == 1)
                                                            <a href="https://faddedsms.com/xtrapay/verify/{{ $data->ref_id }}"
                                                               class="btn btn-primary btn-sm">
                                                                Verify XtraPay
                                                            </a>
                                                        @elseif($data->method == 119 && $data->status == 1)
                                                            <a href="https://faddedsms.com/xtrapay/verify/{{ $data->ref_id }}"
                                                               class="btn btn-primary btn-sm">
                                                                Verify PayVibe
                                                            </a>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td style="font-size: 12px;">{{ $data->created_at }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-4">
                                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                                        <br>No transactions found
                                                    </td>
                                                </tr>
                                            @endforelse

                                            </tbody>

                                            {{ $transaction->links() }}

                                        </table>
                                    </div>
                                </div>


                            </div>
                        </div>


                    </div>
                </div>


            </div>


        </div>
    </section>

@endsection

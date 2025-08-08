@extends('layout.main')
@section('content')

<style>
/* Modal animation */
@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Ensure modal displays properly */
.payvibe-modal {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    z-index: 9999 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    background: rgba(0,0,0,0.6) !important;
    backdrop-filter: blur(5px) !important;
    padding: 20px !important;
}

.payvibe-modal .modal-dialog {
    max-width: 800px !important;
    width: 100% !important;
    margin: 0 auto !important;
    position: relative !important;
    z-index: 10000 !important;
}

.payvibe-modal .modal-content {
    background: rgb(247,248,255) !important;
    border-radius: 15px !important;
    box-shadow: 0 20px 60px rgba(0,0,0,0.4) !important;
    border: none !important;
    position: relative !important;
    z-index: 10001 !important;
    animation: modalSlideIn 0.3s ease-out !important;
}

/* Force modal to be visible */
.payvibe-modal,
.payvibe-modal * {
    visibility: visible !important;
    opacity: 1 !important;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .payvibe-modal {
        padding: 5px !important;
        align-items: flex-start !important;
    }
    
    .payvibe-modal .modal-dialog {
        max-width: calc(100% - 10px) !important;
        margin-top: 10px !important;
    }
    
    .payvibe-modal .modal-content {
        max-height: 95vh !important;
        overflow-y: auto !important;
        font-size: 14px !important;
    }
    
    .payvibe-modal .card {
        margin-bottom: 10px !important;
    }
    
    .payvibe-modal .card-body {
        padding: 0.75rem !important;
    }
    
    .payvibe-modal .input-group {
        flex-direction: column !important;
    }
    
    .payvibe-modal .input-group .form-control {
        border-radius: 0.375rem !important;
        margin-bottom: 5px !important;
        font-size: 12px !important;
    }
    
    .payvibe-modal .input-group .btn {
        border-radius: 0.375rem !important;
        width: 100% !important;
        font-size: 12px !important;
        padding: 0.375rem 0.75rem !important;
    }
    
    .payvibe-modal .modal-header {
        padding: 0.75rem !important;
    }
    
    .payvibe-modal .modal-body {
        padding: 0.75rem !important;
    }
    
    .payvibe-modal .alert {
        font-size: 12px !important;
        padding: 0.5rem !important;
    }
}

/* Override any conflicting styles */
body.payvibe-open {
    overflow: hidden !important;
}

/* Improve button styling */
.payvibe-modal .btn {
    border-radius: 8px !important;
    font-weight: 500 !important;
    transition: all 0.2s ease !important;
}

.payvibe-modal .btn:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
}

/* Card styling improvements */
.payvibe-modal .card {
    border-radius: 10px !important;
    border: none !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
}

.payvibe-modal .card-header {
    border-radius: 10px 10px 0 0 !important;
    border-bottom: none !important;
}

/* Close button hover effect */
.payvibe-modal .btn-close:hover {
    color: #dc3545 !important;
    background-color: rgba(220, 53, 69, 0.1) !important;
}

/* Ensure input fields are visible and properly sized */
.payvibe-modal .form-control {
    color: black !important;
    background-color: white !important;
    border: 1px solid #ced4da !important;
    min-width: 200px !important;
    font-size: 14px !important;
    padding: 8px 12px !important;
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

.payvibe-modal .input-group {
    display: flex !important;
    width: 100% !important;
}

.payvibe-modal .input-group .form-control {
    flex: 1 !important;
    min-width: 0 !important;
}
</style>



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

<!-- Full page overlay -->
<div class="payvibe-modal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 9999; display: flex; align-items: flex-start; justify-content: center; padding: 20px; backdrop-filter: blur(5px); overflow-y: auto;">
    <div style="max-width: 800px; width: 100%; background: rgb(247,248,255); border-radius: 15px; box-shadow: 0 20px 60px rgba(0,0,0,0.4); position: relative; animation: modalSlideIn 0.3s ease-out;">
            <div class="modal-header" style="padding: 1rem; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
                <h5 class="modal-title mb-0"><span class="text-primary">PayVibe</span> Virtual Account</h5>
                <a href="/fund-wallet" style="text-decoration: none;">
                    <button type="button" class="btn-close" aria-label="Close" style="background: none; border: none; font-size: 1.8rem; cursor: pointer; color: #6c757d; transition: color 0.2s ease; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">&times;</button>
                </a>
            </div>
            <div class="modal-body" style="padding: 1rem;">
                <div class="text-center mb-4">
                    <i class="bi bi-credit-card text-primary" style="font-size: 3rem;"></i>
                    <h4 class="mt-2">PayVibe Virtual Account</h4>
                    <p class="text-muted">Transfer the exact amount to complete your payment</p>
                    
                    {{-- <!-- Debug Info -->
                    <div class="alert alert-info" style="font-size: 12px; margin-top: 10px;">
                        <strong>Debug Info:</strong><br>
                        Reference: {{ $reference ?? 'N/A' }}<br>
                        Virtual Account: {{ $virtual_account ?? 'N/A' }}<br>
                        Account Name: {{ $account_name ?? 'N/A' }}<br>
                        Bank Name: {{ $bank_name ?? 'N/A' }}<br>
                        Amount: {{ $amount ?? 'N/A' }}
                    </div> --}}
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><i class="bi bi-bank me-2"></i>Account Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Account Number</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $virtual_account ?? 'N/A' }}" readonly style="color: black !important; background-color: white !important; min-width: 200px !important; font-size: 14px !important; padding: 8px 12px !important; border: 1px solid #ced4da !important;">
                                        <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard('{{ $virtual_account ?? '' }}')">
                                            <i class="bi bi-copy"></i>
                                        </button>
                                    </div>
                                    {{-- <small class="text-muted">Raw value: "{{ $virtual_account ?? 'EMPTY' }}"</small> --}}
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Account Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $account_name ?? 'N/A' }}" readonly style="color: black !important; background-color: white !important; min-width: 200px !important; font-size: 14px !important; padding: 8px 12px !important; border: 1px solid #ced4da !important;">
                                        <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard('{{ $account_name ?? '' }}')">
                                            <i class="bi bi-copy"></i>
                                        </button>
                                    </div>
                                    {{-- <small class="text-muted">Raw value: "{{ $account_name ?? 'EMPTY' }}"</small> --}}
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Bank Name</label>
                                    <input type="text" class="form-control" value="{{ $bank_name ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6 mb-3">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0"><i class="bi bi-calculator me-2"></i>Payment Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Amount to Transfer</label>
                                    <input type="text" class="form-control fw-bold text-success" value="₦{{ number_format($amount ?? 0) }}" readonly>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Reference</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $reference ?? 'N/A' }}" readonly>
                                        <button class="btn btn-outline-success" type="button" onclick="copyToClipboard('{{ $reference ?? '' }}')">
                                            <i class="bi bi-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Important:</strong> Transfer exactly ₦{{ number_format($amount ?? 0) }} to avoid payment issues.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <div class="alert alert-warning">
                        <i class="bi bi-clock me-2"></i>
                        <strong>Payment Time:</strong> Your payment will be processed within 5-10 minutes after transfer.
                    </div>
                    
                    <a href="/fund-wallet" class="btn btn-secondary me-2">
                        <i class="bi bi-arrow-left me-2"></i>Back to Wallet
                    </a>
                    
                    <a href="/xtrapay/verify/{{ $reference ?? '' }}" class="btn btn-primary" onclick="return confirm('Are you sure you have completed the transfer?')">
                        <i class="bi bi-check-circle me-2"></i>I've Made the Transfer
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Ensure modal is visible
document.addEventListener('DOMContentLoaded', function() {
    // Add class to body to prevent scrolling
    document.body.classList.add('payvibe-open');
    
    // Force modal to be visible
    const modal = document.querySelector('.payvibe-modal');
    if (modal) {
        modal.style.display = 'flex';
        modal.style.visibility = 'visible';
        modal.style.opacity = '1';
        modal.style.zIndex = '9999';
        
        // Force all child elements to be visible
        const modalElements = modal.querySelectorAll('*');
        modalElements.forEach(function(element) {
            element.style.visibility = 'visible';
            element.style.opacity = '1';
        });
        
        // Ensure input fields are properly populated and visible
        const accountNumberInput = modal.querySelector('input[value*="PAYVIBE"]');
        const accountNameInput = modal.querySelector('input[value*="Finspa"]');
        
        if (accountNumberInput) {
            accountNumberInput.style.color = 'black !important';
            accountNumberInput.style.backgroundColor = 'white !important';
            console.log('Account number input found:', accountNumberInput.value);
        }
        
        if (accountNameInput) {
            accountNameInput.style.color = 'black !important';
            accountNameInput.style.backgroundColor = 'white !important';
            console.log('Account name input found:', accountNameInput.value);
        }
        
        // Log all input values for debugging
        const allInputs = modal.querySelectorAll('input[type="text"]');
        allInputs.forEach(function(input, index) {
            console.log(`Input ${index + 1}:`, input.value, 'Type:', typeof input.value);
            
            // Force input field to be visible and properly sized
            input.style.color = 'black';
            input.style.backgroundColor = 'white';
            input.style.border = '1px solid #ced4da';
            input.style.minWidth = '200px';
            input.style.fontSize = '14px';
            input.style.padding = '8px 12px';
            input.style.display = 'block';
            input.style.visibility = 'visible';
            input.style.opacity = '1';
            input.style.width = '100%';
            
            // Force the input to show its value
            input.setAttribute('style', input.getAttribute('style') + '; color: black !important; background-color: white !important;');
        });
    }
});

function copyToClipboard(text) {
    if (text && text !== 'N/A') {
        navigator.clipboard.writeText(text).then(function() {
            // Show success message
            const button = event.target.closest('button');
            if (button) {
                const originalHTML = button.innerHTML;
                button.innerHTML = '<i class="bi bi-check"></i>';
                button.classList.remove('btn-outline-primary', 'btn-outline-success');
                button.classList.add('btn-success');
                
                setTimeout(function() {
                    button.innerHTML = originalHTML;
                    button.classList.remove('btn-success');
                    if (originalHTML.includes('btn-outline-primary')) {
                        button.classList.add('btn-outline-primary');
                    } else {
                        button.classList.add('btn-outline-success');
                    }
                }, 2000);
            }
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
        });
    }
}
</script>

@endsection 
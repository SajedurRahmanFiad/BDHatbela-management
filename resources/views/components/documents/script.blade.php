@push('scripts_start')
    @php
        $document_items = 'false';
        $document_app_env = env('APP_ENV');

        if ($items) {
            $document_items = json_encode($items);
        } else if (old('items')) {
            $document_items = json_encode(old('items'));
        }
    @endphp

    <script type="text/javascript">
        var document_items = {!! $document_items !!};
        var document_default_currency = '{{ $currency_code }}';
        var document_currencies = {!! $currencies !!};
        var document_taxes = {!! $taxes !!};
        var document_app_env = '{{ $document_app_env }}';

        if (typeof aka_currency !== 'undefined') {
            aka_currency = {!! json_encode(! empty($document) ? $document->currency : config('money.currencies.' . company()->currency)) !!};
        } else {
            var aka_currency = {!! json_encode(! empty($document) ? $document->currency : config('money.currencies.' . company()->currency)) !!};
        }

        // Steadfast Courier button handler
        document.addEventListener('DOMContentLoaded', function() {
            attachSteadfastCourierHandler();
        });

        // Attach handler to all current and future buttons
        function attachSteadfastCourierHandler() {
            var buttons = document.querySelectorAll('.send-steadfast-courier-btn, .send-steadfast-courier-btn-direct');
            buttons.forEach(function(btn) {
                // Remove existing listeners
                btn.replaceWith(btn.cloneNode(true));
            });
            
            // Re-attach with event delegation
            document.addEventListener('click', function(e) {
                if (e.target.closest('.send-steadfast-courier-btn')) {
                    e.preventDefault();
                    e.stopPropagation();
                    var btn = e.target.closest('.send-steadfast-courier-btn');
                    var invoiceId = btn.getAttribute('data-invoice-id');
                    onSendStealthfastCourier(invoiceId);
                }

                if (e.target.closest('.send-steadfast-courier-btn-direct')) {
                    e.preventDefault();
                    e.stopPropagation();
                    var btn = e.target.closest('.send-steadfast-courier-btn-direct');
                    var invoiceId = btn.getAttribute('data-invoice-id');
                    onSendStealthfastCourierDirect(invoiceId);
                }
            });
        }

        // Also try with MutationObserver for dynamically added buttons
        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes.length) {
                    var hasStealthfastBtn = Array.from(mutation.addedNodes).some(function(node) {
                        return node.classList && (node.classList.contains('send-steadfast-courier-btn') || node.classList.contains('send-steadfast-courier-btn-direct'));
                    });
                    if (hasStealthfastBtn) {
                        attachSteadfastCourierHandler();
                    }
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });

        // Steadfast Courier send function
        function onSendStealthfastCourier(invoiceId) {
            console.log('onSendStealthfastCourier called with invoiceId:', invoiceId);
            
            if (!invoiceId) {
                alert('Invoice ID is missing');
                console.error('Invoice ID is missing');
                return;
            }

            console.log('Sending request to /api/steadfast-courier/prepare-order');
            
            // Send request to backend
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/api/steadfast-courier/prepare-order', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    console.log('XHR response received. Status:', xhr.status);
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        console.log('Steadfast Courier Order Data:', response);
                        alert('Order data prepared! Check console for details.');
                        // Ready to add API call here:
                        // var response = SteadfastCourier.placeOrder(response.data);
                    } else {
                        alert('Error preparing order: ' + xhr.status);
                        console.error('Error response:', xhr.responseText);
                    }
                }
            };

            xhr.onerror = function() {
                console.error('XHR error occurred');
                alert('Network error occurred');
            };

            console.log('Sending data:', JSON.stringify({
                invoice_id: invoiceId
            }));

            xhr.send(JSON.stringify({
                invoice_id: invoiceId
            }));
        }

        // Steadfast Courier direct send function
        function onSendStealthfastCourierDirect(invoiceId) {
            console.log('onSendStealthfastCourierDirect called with invoiceId:', invoiceId);
            
            if (!invoiceId) {
                alert('Invoice ID is missing');
                console.error('Invoice ID is missing');
                return;
            }

            console.log('Sending request to /api/steadfast-courier/send-order');
            
            // Send request to backend
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/api/steadfast-courier/send-order', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    console.log('XHR response received. Status:', xhr.status);
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        console.log('Steadfast Courier Response:', response);
                        alert('Order sent to Steadfast Courier!');
                    } else {
                        alert('Error sending order: ' + xhr.status);
                        console.error('Error response:', xhr.responseText);
                    }
                }
            };

            xhr.onerror = function() {
                console.error('XHR error occurred');
                alert('Network error occurred');
            };

            console.log('Sending data:', JSON.stringify({
                invoice_id: invoiceId
            }));

            xhr.send(JSON.stringify({
                invoice_id: invoiceId
            }));
        }
    </script>
@endpush

<x-script :alias="$alias" :folder="$folder" :file="$file" />

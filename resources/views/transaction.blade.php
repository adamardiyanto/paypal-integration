
<button id="apiCallButton" class="btn btn-primary">Call API</button>
@if (Session::has('success'))
    <div class="feedback valid">{{ Session::get('success') }}</div>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var session = '{{ Session::get('success') }}';
    console.log('Session:', session);
    console.log('Transaction page loaded!');
    $('#apiCallButton').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: '/process-transaction',
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(data) {
                console.log(data);
                if (data.status === 'CREATED') {
                    const approvalLink = data.links.find(item => item.rel === 'approve');
                    if (approvalLink) {
                        window.location.href = approvalLink.href;
                    }
                } else {
                    alert('Transaction failed!');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Transaction processing failed!');
            }
        });
    });
</script>
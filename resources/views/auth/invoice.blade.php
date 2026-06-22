<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
</head>
<body>
    <div style="text-align: center; margin-top: 50px; font-family: sans-serif;">
        <h2>Selesaikan Pembayaran Anda</h2>
        <p>Total Tagihan: <strong style="color: #2b6cb0;">Rp {{ number_format($transaction->total_payable, 0, ',', '.') }}</strong></p>
        <button id="pay-button" style="padding: 12px 24px; font-size: 16px; background-color: #2b6cb0; color: white; border: none; cursor: pointer; border-radius: 5px; font-weight: bold;">
            Bayar Sekarang
        </button>
    </div>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            // Memicu jendela pop-up kasir Midtrans
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    console.log(result);

                    // PROSES BYPASS LOCALHOST: Tembak route Laravel untuk mengubah status DB menjadi success
                    fetch("/transaction/set-success/{{ $transaction->id }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert("Pembayaran sukses!");
                        // Alihkan ke dashboard user dengan membawa parameter info pembayaran sukses
                        window.location.href = '/dashboard?payment=success';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Fallback tetap pindah halaman jika ada kendala fetch
                        window.location.href = '/dashboard';
                    });
                },
                onPending: function(result){
                    alert("Menunggu pembayaran!");
                    console.log(result);
                    window.location.href = '/dashboard';
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                    console.log(result);
                    window.location.href = '/dashboard';
                },
                onClose: function(){
                    alert('Anda menutup halaman pembayaran sebelum selesai.');
                }
            });
        });
    </script>
</body>
</html>
